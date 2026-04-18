<?php
$pageTitle = 'Staff Hub Pro - Home';
$activePage = 'dashboard';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-dashboard">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">Welcome back, <span id="dashboardName">Staff</span></div>
        <p class="hero-subtitle">A staff-first workspace with your rota, same-company team visibility, updates, swaps, training progress, rewards, and personal profile — all in one place.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Week commencing</div>
        <div class="fs-5 fw-bold mb-2" id="weekLabelDashboard">30 Mar 2026</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill" id="dashboardViewerPill">👤 Staff access</span>
          <span class="emergency-pill" id="dashboardCompanyPill">🏢 Company access</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
      <div class="summary-box red">
        <div class="small-label">Visible staff</div>
        <div class="summary-number" id="dashVisibleStaff">0</div>
        <div class="mt-2">Colleagues in your company</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box orange">
        <div class="small-label">My hours</div>
        <div class="summary-number" id="dashMyHours">0</div>
        <div class="mt-2">Your scheduled hours this week</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box yellow">
        <div class="small-label">Training done</div>
        <div class="summary-number" id="dashTrainingDone">0%</div>
        <div class="mt-2">Current completion progress</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box dark">
        <div class="small-label">Rewards points</div>
        <div class="summary-number" id="dashRewardPoints">0</div>
        <div class="mt-2">Recognition and app activity</div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-lg-8">
      <div class="feed-card h-100">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div>
            <div class="page-heading h4 mb-1">Today’s staff feed</div>
            <div class="footer-note">Quick reasons for staff to come back daily.</div>
          </div>
          <button class="btn btn-soft" data-page-open="rota">Open rota</button>
        </div>

        <div class="feed-list" id="staffFeed"></div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="kudos-card h-100">
        <div class="page-heading h4 mb-1">Recognition</div>
        <div class="footer-note mb-3">Celebrate wins inside the team.</div>

        <div class="kudos-list" id="kudosList"></div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-md-6 col-xl-3">
      <div class="feature-card h-100">
        <div class="feature-icon">🗓️</div>
        <h5>Rota at a glance</h5>
        <p class="muted mb-3">See this week’s shifts, night duties, leave, training, and total hours instantly.</p>
        <button class="btn btn-accent w-100" data-page-open="rota">Go to rota</button>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="feature-card h-100">
        <div class="feature-icon">🤝</div>
        <h5>Shift board</h5>
        <p class="muted mb-3">Offer shifts, pick up extra cover, and keep staffing flexible inside your company.</p>
        <button class="btn btn-accent w-100" data-page-open="swaps">Open board</button>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="feature-card h-100">
        <div class="feature-icon">🎓</div>
        <h5>Training zone</h5>
        <p class="muted mb-3">Track certificates, deadlines, modules, and learning streaks in one place.</p>
        <button class="btn btn-accent w-100" data-page-open="training">View training</button>
      </div>
    </div>

    <div class="col-md-6 col-xl-3">
      <div class="feature-card h-100">
        <div class="feature-icon">🎁</div>
        <h5>Rewards & fun</h5>
        <p class="muted mb-3">Staff perks, recognition points, birthday shout-outs, and challenges that keep the app lively.</p>
        <button class="btn btn-accent w-100" data-page-open="rewards">See rewards</button>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>