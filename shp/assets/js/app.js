let quickFilter = "all";
let manualView = "auto";

function getEl(id) {
  return document.getElementById(id);
}

function getCurrentStaff() {
  return rotaData.find(person => person.name === currentStaffName) || null;
}

function getVisibleCompanyData() {
  const currentStaff = getCurrentStaff();
  if (!currentStaff) return [];
  return rotaData
    .filter(person => person.company === currentStaff.company)
    .sort((a, b) => {
      if (a.name === currentStaff.name) return -1;
      if (b.name === currentStaff.name) return 1;
      return a.name.localeCompare(b.name);
    });
}

function getShiftHours(shift) {
  if (["leave", "sick"].includes(shift.type)) return 0;
  if (shift.note && /(\d+(?:\.\d+)?)\s*hrs?/i.test(shift.note)) {
    return Number(shift.note.match(/(\d+(?:\.\d+)?)\s*hrs?/i)[1]);
  }
  const match = shift.label.match(/(\d{1,2}):(\d{2})-(\d{1,2}):(\d{2})/);
  if (!match) return 8;
  let [, sh, sm, eh, em] = match.map(Number);
  let start = sh + sm / 60;
  let end = eh + em / 60;
  if (end <= start) end += 24;
  return end - start;
}

function totalHours(person) {
  return Object.values(person.shifts).flat().reduce((sum, shift) => sum + getShiftHours(shift), 0);
}

function countNightShifts(person) {
  return Object.values(person.shifts).flat().filter(shift => shift.mode === "night").length;
}

function hasExceptions(person) {
  return Object.values(person.shifts).flat().some(shift => ["leave", "training", "sick"].includes(shift.type));
}

function hasNightShift(person) {
  return Object.values(person.shifts).flat().some(shift => shift.mode === "night");
}

function variance(person) {
  return totalHours(person) - Number(person.contract || 0);
}

function getVarianceMeta(diff) {
  if (Math.abs(diff) < 0.1) return { label: "On target", className: "variance-neutral" };
  if (diff > 0) return { label: `+${diff.toFixed(1)}h`, className: "variance-over" };
  return { label: `${diff.toFixed(1)}h`, className: "variance-under" };
}

function shiftChip(shift) {
  const classes = ["shift-chip", shift.type];
  if (shift.mode === "night") classes.push("night");
  const icon = shift.mode === "night" ? "🌙" : "•";
  return `
    <span class="${classes.join(" ")}">${icon} ${shift.label}</span>
    ${shift.note ? `<span class="cell-note">${shift.note}</span>` : ""}
  `;
}

function staffMatchesType(person, selectedType) {
  if (selectedType === "all") return true;
  if (selectedType === "night") return hasNightShift(person);
  return Object.values(person.shifts).flat().some(shift => shift.type === selectedType);
}

function staffMatchesQuickFilter(person) {
  const diff = variance(person);
  const currentStaff = getCurrentStaff();

  if (quickFilter === "all") return true;
  if (quickFilter === "over") return diff > 0.1;
  if (quickFilter === "under") return diff < -0.1;
  if (quickFilter === "night") return hasNightShift(person);
  if (quickFilter === "exceptions") return hasExceptions(person);
  if (quickFilter === "mine") return currentStaff && person.name === currentStaff.name;
  return true;
}

function updateQuickFiltersUI() {
  const wrap = getEl("quickFilters");
  if (!wrap) return;
  [...wrap.querySelectorAll(".quick-chip")].forEach(btn => {
    btn.classList.toggle("active", btn.dataset.filter === quickFilter);
  });
}

function renderShellInfo() {
  const me = getCurrentStaff();
  const navUserPill = getEl("navUserPill");
  const navCompanyPill = getEl("navCompanyPill");

  if (!navUserPill || !navCompanyPill) return;

  if (!me) {
    navUserPill.textContent = "👤 Staff not found";
    navCompanyPill.textContent = "🏢 No company";
    return;
  }

  navUserPill.textContent = `👤 ${me.name}`;
  navCompanyPill.textContent = `🏢 ${me.company}`;
}

function renderDesktopTable(filtered, currentStaff) {
  const rotaBody = getEl("rotaBody");
  if (!rotaBody) return;

  rotaBody.innerHTML = filtered.length ? filtered.map(person => {
    const total = totalHours(person);
    const diff = variance(person);
    const diffMeta = getVarianceMeta(diff);
    const isMe = currentStaff && person.name === currentStaff.name;

    return `
      <tr>
        <td class="sticky-col">
          <div class="staff-name">${person.name} ${isMe ? '<span class="badge text-bg-danger ms-1">You</span>' : ''}</div>
          <div class="staff-meta">${person.company}</div>
        </td>
        <td class="sticky-col-2">
          <div class="fw-semibold">${person.role}</div>
          <div class="staff-meta">${countNightShifts(person)} night shift(s)</div>
        </td>
        ${days.map(day => {
          const shifts = person.shifts[day] || [];
          return `<td>${shifts.length ? shifts.map(shiftChip).join("") : '<span class="text-muted small">—</span>'}</td>`;
        }).join("")}
        <td class="text-center"><span class="hours-badge">${person.contract}h</span></td>
        <td class="text-center"><span class="hours-badge">${total.toFixed(1)}h</span></td>
        <td class="text-center"><span class="variance-badge ${diffMeta.className}">${diffMeta.label}</span></td>
      </tr>
    `;
  }).join("") : `
    <tr>
      <td colspan="12">
        <div class="empty-state">
          <div class="fw-bold mb-1">No staff match your filters</div>
          <div class="small">Try resetting the search or quick filters.</div>
        </div>
      </td>
    </tr>
  `;
}

function renderMobileCards(filtered, currentStaff) {
  const mobileList = getEl("mobileList");
  if (!mobileList) return;

  mobileList.innerHTML = filtered.length ? filtered.map(person => {
    const total = totalHours(person);
    const diff = variance(person);
    const diffMeta = getVarianceMeta(diff);
    const progressValue = person.contract ? Math.min((total / person.contract) * 100, 100) : 0;
    const isMe = currentStaff && person.name === currentStaff.name;

    return `
      <div class="mobile-card">
        <div class="mobile-card-header">
          <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
              <div class="staff-name">${person.name} ${isMe ? '<span class="badge text-bg-danger ms-1">You</span>' : ''}</div>
              <div class="staff-meta">${person.role} • ${person.company}</div>
            </div>
            <span class="variance-badge ${diffMeta.className}">${diffMeta.label}</span>
          </div>
          <div class="mobile-meta-row">
            <div class="mini-stat">
              <div class="small-label text-dark">Contract</div>
              <div class="value">${person.contract}h</div>
            </div>
            <div class="mini-stat">
              <div class="small-label text-dark">Scheduled</div>
              <div class="value">${total.toFixed(1)}h</div>
            </div>
            <div class="mini-stat">
              <div class="small-label text-dark">Night shifts</div>
              <div class="value">${countNightShifts(person)}</div>
            </div>
          </div>
          <div class="progress-wrap">
            <div class="d-flex justify-content-between small mb-1">
              <span class="fw-semibold">Contract usage</span>
              <span>${person.contract ? Math.round((total / person.contract) * 100) : 0}%</span>
            </div>
            <div class="progress">
              <div class="progress-bar" role="progressbar" style="width: ${progressValue}%"></div>
            </div>
          </div>
        </div>

        <div class="mobile-days">
          ${days.map(day => {
            const shifts = person.shifts[day] || [];
            return `
              <div class="mobile-day">
                <div class="mobile-day-head">
                  <span>${day}</span>
                  <span class="small text-secondary">${shifts.length ? shifts.length + " item(s)" : "No shift"}</span>
                </div>
                <div>
                  ${shifts.length ? shifts.map(shiftChip).join("") : '<div class="mobile-day-empty">No rota entry</div>'}
                </div>
              </div>
            `;
          }).join("")}
        </div>
      </div>
    `;
  }).join("") : `<div class="empty-state">No staff match your current filters.</div>`;
}

function updateSummary(filtered) {
  const totalStaff = getEl("totalStaff");
  if (!totalStaff) return;

  const allShifts = filtered.flatMap(person => Object.values(person.shifts).flat());
  const totalScheduledHours = filtered.reduce((sum, person) => sum + totalHours(person), 0);
  const totalNightShifts = allShifts.filter(s => s.mode === "night").length;

  totalStaff.textContent = filtered.length;
  getEl("assignedCount").textContent = allShifts.filter(s => s.type === "assigned").length;
  getEl("pickupCount").textContent = allShifts.filter(s => s.type === "pickup").length;
  getEl("exceptionCount").textContent = allShifts.filter(s => ["leave", "training", "sick"].includes(s.type)).length;
  getEl("visibleCount").textContent = `${filtered.length} staff shown`;
  getEl("hoursCount").textContent = `${totalScheduledHours.toFixed(1)} total scheduled hours`;
  getEl("nightCount").textContent = `${totalNightShifts} night shifts`;
}

function applyViewState() {
  const desktopTableWrap = getEl("desktopTableWrap");
  const mobileList = getEl("mobileList");
  const tableViewBtn = getEl("tableViewBtn");
  const cardViewBtn = getEl("cardViewBtn");

  if (!desktopTableWrap || !mobileList || !tableViewBtn || !cardViewBtn) return;

  const isMobile = window.innerWidth < 992;
  const useCards = manualView === "cards" || (manualView === "auto" && isMobile);

  desktopTableWrap.style.display = useCards ? "none" : "block";
  mobileList.style.display = useCards ? "block" : "none";

  tableViewBtn.classList.toggle("active", !useCards);
  cardViewBtn.classList.toggle("active", useCards);
}

function renderRotaPage() {
  if (!getEl("rotaBody")) return;

  const currentStaff = getCurrentStaff();
  const searchInput = getEl("searchInput");
  const typeFilter = getEl("typeFilter");
  const rotaBody = getEl("rotaBody");
  const mobileList = getEl("mobileList");

  getEl("weekLabelRota").textContent = weekLabel;

  if (!currentStaff) {
    rotaBody.innerHTML = `
      <tr>
        <td colspan="12" class="text-center py-4">
          <div class="fw-bold mb-1">Staff access could not be loaded</div>
          <div class="text-muted small">Check the currentStaffName value in the script.</div>
        </td>
      </tr>
    `;
    mobileList.innerHTML = "";
    getEl("viewerPill").textContent = "👤 Staff not found";
    getEl("companyPill").textContent = "🏢 No company";
    return;
  }

  getEl("viewerPill").textContent = `👤 ${currentStaff.name}`;
  getEl("companyPill").textContent = `🏢 ${currentStaff.company}`;

  const q = searchInput.value.trim().toLowerCase();
  const selectedType = typeFilter.value;

  const filtered = getVisibleCompanyData().filter(person => {
    const haystack = `${person.name} ${person.role} ${person.company}`.toLowerCase();
    const searchOk = !q || haystack.includes(q);
    const typeOk = staffMatchesType(person, selectedType);
    const quickOk = staffMatchesQuickFilter(person);
    return searchOk && typeOk && quickOk;
  });

  renderDesktopTable(filtered, currentStaff);
  renderMobileCards(filtered, currentStaff);
  updateSummary(filtered);
  applyViewState();
}

function getMyStats() {
  const me = getCurrentStaff();
  if (!me) return { hours: 0, nights: 0, variance: 0 };
  return {
    hours: totalHours(me),
    nights: countNightShifts(me),
    variance: variance(me)
  };
}

function renderDashboard() {
  if (!getEl("dashboardName")) return;

  const me = getCurrentStaff();
  const companyData = getVisibleCompanyData();
  const myStats = getMyStats();
  const trainingDone = Math.round(trainingData.reduce((sum, item) => sum + item.progress, 0) / trainingData.length);
  const rewardPoints = 420;

  getEl("weekLabelDashboard").textContent = weekLabel;
  getEl("dashboardName").textContent = me ? me.name.split(" ")[0] : "Staff";
  getEl("dashboardViewerPill").textContent = me ? `👤 ${me.name}` : "👤 Staff";
  getEl("dashboardCompanyPill").textContent = me ? `🏢 ${me.company}` : "🏢 Company";
  getEl("dashVisibleStaff").textContent = companyData.length;
  getEl("dashMyHours").textContent = `${myStats.hours.toFixed(1)}h`;
  getEl("dashTrainingDone").textContent = `${trainingDone}%`;
  getEl("dashRewardPoints").textContent = rewardPoints;

  getEl("staffFeed").innerHTML = staffFeedData.map(item => `
    <div class="feed-item">
      <div class="d-flex gap-3 align-items-start">
        <div class="avatar sm">${item.icon}</div>
        <div class="flex-grow-1">
          <div class="fw-bold">${item.title}</div>
          <div class="text-secondary small mb-2">${item.text}</div>
          <button class="mini-chip" data-page-open="${item.page}">Open</button>
        </div>
      </div>
    </div>
  `).join("");

  getEl("kudosList").innerHTML = kudosData.slice(0, 3).map(item => `
    <div class="kudos-item">
      <div class="d-flex gap-3">
        <div class="avatar sm">${item.name.split(" ").map(n => n[0]).join("").slice(0,2)}</div>
        <div>
          <div class="fw-bold">${item.name}</div>
          <div class="small text-secondary mb-2">${item.note}</div>
          <span class="tag-badge">🏅 ${item.badge}</span>
        </div>
      </div>
    </div>
  `).join("");
}

function renderTeamPage() {
  if (!getEl("teamList")) return;

  const me = getCurrentStaff();
  const team = getVisibleCompanyData();

  getEl("teamCompanyTitle").textContent = me ? me.company : "Company";
  getEl("teamCountPill").textContent = `${team.length} team members`;

  getEl("teamList").innerHTML = team.map(person => {
    const isMe = me && person.name === me.name;
    const shifts = Object.values(person.shifts).flat();
    const shiftTypeCounts = shifts.reduce((acc, s) => {
      acc[s.type] = (acc[s.type] || 0) + 1;
      return acc;
    }, {});
    const dominant = Object.entries(shiftTypeCounts).sort((a,b) => b[1]-a[1])[0]?.[0] || "No shifts";

    return `
      <div class="team-person">
        <div class="d-flex gap-3 align-items-start">
          <div class="avatar">${person.name.split(" ").map(n => n[0]).join("").slice(0,2)}</div>
          <div class="flex-grow-1">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
              <div>
                <div class="staff-name">${person.name} ${isMe ? '<span class="badge text-bg-danger ms-1">You</span>' : ''}</div>
                <div class="staff-meta">${person.role} • ${person.company}</div>
              </div>
              <span class="tag-badge">${countNightShifts(person)} night shift(s)</span>
            </div>

            <div class="row g-2 mt-2">
              <div class="col-sm-4">
                <div class="mini-stat">
                  <div class="small-label text-dark">Contract</div>
                  <div class="value">${person.contract}h</div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mini-stat">
                  <div class="small-label text-dark">Scheduled</div>
                  <div class="value">${totalHours(person).toFixed(1)}h</div>
                </div>
              </div>
              <div class="col-sm-4">
                <div class="mini-stat">
                  <div class="small-label text-dark">Main shift type</div>
                  <div class="value" style="font-size:0.95rem">${dominant}</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    `;
  }).join("");

  const teamShifts = team.flatMap(person => Object.values(person.shifts).flat());
  const shiftTypes = ["assigned", "pickup", "leave", "training", "sick"];
  const topType = shiftTypes.map(type => ({
    type,
    count: teamShifts.filter(s => s.type === type).length
  })).sort((a,b) => b.count - a.count)[0];

  getEl("teamTopShiftType").textContent = topType ? `${topType.type}` : "Assigned";
}

function renderSwapsPage() {
  if (!getEl("swapList")) return;

  const me = getCurrentStaff();
  const sameCompanyNames = new Set(getVisibleCompanyData().map(p => p.name));
  const visibleSwaps = swapBoardData.filter(item => sameCompanyNames.has(item.owner));

  getEl("swapList").innerHTML = visibleSwaps.map(item => `
    <div class="swap-item">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <div>
          <div class="fw-bold">${item.owner}${me && item.owner === me.name ? ' <span class="badge text-bg-danger ms-1">You</span>' : ''}</div>
          <div class="small text-secondary">${item.shift}</div>
        </div>
        <span class="tag-badge">🔁 ${item.type}</span>
      </div>
      <div class="small text-secondary mb-3">${item.note}</div>
      <div class="d-flex flex-wrap gap-2">
        <button class="mini-chip">I'm interested</button>
        <button class="mini-chip">Message admin</button>
      </div>
    </div>
  `).join("");
}

function renderTrainingPage() {
  if (!getEl("trainingList")) return;

  const avg = Math.round(trainingData.reduce((sum, item) => sum + item.progress, 0) / trainingData.length);
  getEl("learningStreak").textContent = "5 days";
  getEl("trainingCompletionRate").textContent = `${avg}%`;

  getEl("trainingList").innerHTML = trainingData.map(item => `
    <div class="training-item">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <div>
          <div class="fw-bold">${item.title}</div>
          <div class="small text-secondary">${item.status}</div>
        </div>
        <span class="tag-badge">📌 ${item.due}</span>
      </div>
      <div class="progress mb-2">
        <div class="progress-bar" style="width:${item.progress}%"></div>
      </div>
      <div class="small text-secondary">${item.progress}% complete</div>
    </div>
  `).join("");
}

function renderRewardsPage() {
  if (!getEl("perkList")) return;

  const points = 420;
  getEl("rewardPointsHeader").textContent = `${points} points`;

  getEl("perkList").innerHTML = rewardsData.map(item => `
    <div class="perk-item">
      <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
        <div>
          <div class="fw-bold">${item.title}</div>
          <div class="small text-secondary">${item.desc}</div>
        </div>
        <span class="tag-badge">⭐ ${item.points} pts</span>
      </div>
      <button class="mini-chip">Save for later</button>
    </div>
  `).join("");

  const spotlight = kudosData[0];
  getEl("spotlightCard").innerHTML = `
    <div class="highlight-card mb-3">
      <div class="small-label text-dark">This week’s spotlight</div>
      <div class="fs-4 fw-bold mt-1">${spotlight.name}</div>
      <div class="small text-secondary mt-2">${spotlight.note}</div>
    </div>

    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Your current points</div>
        <div class="small text-secondary">${points} total</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Next badge target</div>
        <div class="small text-secondary">Only 80 points away from “Reliable Star”.</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Birthday & milestones</div>
        <div class="small text-secondary">Great place to show staff celebrations later.</div>
      </div>
    </div>
  `;
}

function renderProfilePage() {
  if (!getEl("profileMainCard")) return;

  const me = getCurrentStaff();
  if (!me) return;

  const myHours = totalHours(me);
  const myVariance = getVarianceMeta(variance(me));
  const trainingDone = Math.round(trainingData.reduce((sum, item) => sum + item.progress, 0) / trainingData.length);

  getEl("profileMainCard").innerHTML = `
    <div class="d-flex gap-3 align-items-center mb-3">
      <div class="avatar" style="width:64px;height:64px;font-size:1.1rem">${me.name.split(" ").map(n => n[0]).join("").slice(0,2)}</div>
      <div>
        <h5 class="mb-1">${me.name}</h5>
        <div class="text-secondary small">${me.role}</div>
        <div class="text-secondary small">${me.company}</div>
      </div>
    </div>

    <div class="mini-stat mb-2">
      <div class="small-label text-dark">Contract hours</div>
      <div class="value">${me.contract}h</div>
    </div>
    <div class="mini-stat mb-2">
      <div class="small-label text-dark">Scheduled this week</div>
      <div class="value">${myHours.toFixed(1)}h</div>
    </div>
    <div class="mini-stat">
      <div class="small-label text-dark">Night shifts</div>
      <div class="value">${countNightShifts(me)}</div>
    </div>
  `;

  getEl("profileWeeklyCard").innerHTML = `
    <h5>Weekly overview</h5>
    <div class="highlight-card">
      <div class="small-label text-dark">Variance</div>
      <div class="fs-4 fw-bold">${myVariance.label}</div>
      <div class="small text-secondary mt-2">Compared with your contract hours.</div>
    </div>
    <div class="mt-3">
      <div class="small text-secondary">Contract usage</div>
      <div class="progress mt-2">
        <div class="progress-bar" style="width:${Math.min((myHours / me.contract) * 100, 100)}%"></div>
      </div>
    </div>
  `;

  getEl("profileAchievementCard").innerHTML = `
    <h5>Achievements</h5>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Training progress</div>
        <div class="small text-secondary">${trainingDone}% complete</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Recognition points</div>
        <div class="small text-secondary">420 points earned</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Team visibility</div>
        <div class="small text-secondary">You can view same-company rota only.</div>
      </div>
    </div>
  `;

  getEl("profileChecklistCard").innerHTML = `
    <h5>Personal checklist</h5>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Check this week’s rota</div>
        <div class="small text-secondary">Stay on top of any updates.</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Review open shift board</div>
        <div class="small text-secondary">You might want extra cover hours.</div>
      </div>
    </div>
    <div class="check-row">
      <span class="check-dot"></span>
      <div>
        <div class="fw-semibold">Continue training modules</div>
        <div class="small text-secondary">Build your streak and keep compliance healthy.</div>
      </div>
    </div>
  `;
}

function bindRotaEvents() {
  const quickFiltersWrap = getEl("quickFilters");
  const tableViewBtn = getEl("tableViewBtn");
  const cardViewBtn = getEl("cardViewBtn");
  const searchInput = getEl("searchInput");
  const typeFilter = getEl("typeFilter");
  const resetBtn = getEl("resetBtn");

  if (quickFiltersWrap) {
    quickFiltersWrap.addEventListener("click", (event) => {
      const button = event.target.closest(".quick-chip");
      if (!button) return;
      quickFilter = button.dataset.filter;
      updateQuickFiltersUI();
      renderRotaPage();
    });
  }

  if (tableViewBtn) {
    tableViewBtn.addEventListener("click", () => {
      manualView = "table";
      applyViewState();
    });
  }

  if (cardViewBtn) {
    cardViewBtn.addEventListener("click", () => {
      manualView = "cards";
      applyViewState();
    });
  }

  if (searchInput) searchInput.addEventListener("input", renderRotaPage);
  if (typeFilter) typeFilter.addEventListener("change", renderRotaPage);

  if (resetBtn) {
    resetBtn.addEventListener("click", () => {
      searchInput.value = "";
      typeFilter.value = "all";
      quickFilter = "all";
      manualView = "auto";
      updateQuickFiltersUI();
      renderRotaPage();
    });
  }

  window.addEventListener("resize", applyViewState);
}

function bindPageButtons() {
  document.addEventListener("click", (event) => {
    const link = event.target.closest("[data-page-open]");
    if (!link) return;
    event.preventDefault();

    const page = link.dataset.pageOpen;
    if (pageRoutes[page]) {
      window.location.href = pageRoutes[page];
    }
  });
}

function initWeekLabels() {
  ["weekLabelDashboard", "weekLabelRota"].forEach(id => {
    const el = getEl(id);
    if (el) el.textContent = weekLabel;
  });
}

function initApp() {
  renderShellInfo();
  initWeekLabels();
  updateQuickFiltersUI();
  renderDashboard();
  renderRotaPage();
  renderTeamPage();
  renderSwapsPage();
  renderTrainingPage();
  renderRewardsPage();
  renderProfilePage();
  bindRotaEvents();
  bindPageButtons();
}

document.addEventListener("DOMContentLoaded", initApp);