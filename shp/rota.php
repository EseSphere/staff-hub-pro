<?php
$pageTitle = 'Staff Hub Pro - Rota';
$activePage = 'rota';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-rota">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">My Company Rota</div>
        <p class="hero-subtitle">View your rota and staff rota entries for colleagues within your company only, while keeping the original layout, filters, reporting, and mobile-friendly card view.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Week commencing</div>
        <div class="fs-5 fw-bold mb-2" id="weekLabelRota">30 Mar 2026</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill" id="viewerPill">👤 Staff access</span>
          <span class="emergency-pill" id="companyPill">🏢 Company view</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
      <div class="summary-box red">
        <div class="small-label">Visible staff</div>
        <div class="summary-number" id="totalStaff">0</div>
        <div class="mt-2">Staff in your company view</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box orange">
        <div class="small-label">Assigned shifts</div>
        <div class="summary-number" id="assignedCount">0</div>
        <div class="mt-2">Allocated standard shifts</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box yellow">
        <div class="small-label">Pick-up shifts</div>
        <div class="summary-number" id="pickupCount">0</div>
        <div class="mt-2">Extra or picked-up cover</div>
      </div>
    </div>
    <div class="col-6 col-xl-3">
      <div class="summary-box dark">
        <div class="small-label">Exceptions</div>
        <div class="summary-number" id="exceptionCount">0</div>
        <div class="mt-2">Leave, sickness, training</div>
      </div>
    </div>
  </div>

  <div class="row g-3 mb-4">
    <div class="col-lg-8">
      <div class="panel h-100">
        <div class="row g-3 toolbar">
          <div class="col-md-6 col-lg-6">
            <label class="form-label fw-semibold">Search staff</label>
            <input id="searchInput" type="text" class="form-control" placeholder="Search name or role in your company">
          </div>
          <div class="col-md-6 col-lg-4">
            <label class="form-label fw-semibold">Shift type</label>
            <select id="typeFilter" class="form-select">
              <option value="all">All types</option>
              <option value="assigned">Assigned only</option>
              <option value="pickup">Pick-up only</option>
              <option value="leave">Leave only</option>
              <option value="training">Training only</option>
              <option value="sick">Sick only</option>
              <option value="night">Night shifts</option>
            </select>
          </div>
          <div class="col-md-6 col-lg-2 d-grid">
            <label class="form-label fw-semibold d-none d-lg-block">&nbsp;</label>
            <button id="resetBtn" class="btn btn-soft">Reset</button>
          </div>
        </div>

        <hr class="my-4">

        <div class="d-flex flex-column gap-3">
          <div>
            <div class="fw-bold mb-2">Quick filters</div>
            <div class="quick-filters" id="quickFilters">
              <button class="quick-chip active" data-filter="all">All staff</button>
              <button class="quick-chip" data-filter="over">Over contract</button>
              <button class="quick-chip" data-filter="under">Under contract</button>
              <button class="quick-chip" data-filter="night">Night staff</button>
              <button class="quick-chip" data-filter="exceptions">Exceptions</button>
              <button class="quick-chip" data-filter="mine">My rota</button>
            </div>
          </div>
          <div class="status-bar">
            <span class="status-pill" id="visibleCount">0 staff shown</span>
            <span class="status-pill" id="hoursCount">0 total scheduled hours</span>
            <span class="status-pill" id="nightCount">0 night shifts</span>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="info-card h-100">
        <div class="fw-bold fs-5 mb-3">Legend & guidance</div>
        <div class="legend-grid mb-3">
          <div class="legend-item"><span class="legend-badge" style="background: rgba(220,53,69,.16); border:1px solid rgba(220,53,69,.2);"></span>Assigned</div>
          <div class="legend-item"><span class="legend-badge" style="background: rgba(253,126,20,.18); border:1px solid rgba(253,126,20,.25);"></span>Pick-up</div>
          <div class="legend-item"><span class="legend-badge" style="background: rgba(255,193,7,.22); border:1px solid rgba(255,193,7,.28);"></span>Leave</div>
          <div class="legend-item"><span class="legend-badge" style="background: #ffe8c8; border:1px solid #ffd399;"></span>Training</div>
          <div class="legend-item"><span class="legend-badge" style="background: #ffd8dd; border:1px solid #f7b8c0;"></span>Sick</div>
          <div class="legend-item"><span class="legend-badge" style="background: #fff; border:1px solid #4a1d12;"></span>Night shift</div>
        </div>
        <div class="footer-note mb-3">This version is restricted so staff can only view rota entries for colleagues in the same company as themselves.</div>
        <div class="mini-stat">
          <div class="small-label text-dark">Access rule</div>
          <div class="mt-2 small text-secondary">The company is taken from the logged-in staff member. Staff from other companies are automatically hidden from both table and card view.</div>
        </div>
      </div>
    </div>
  </div>

  <div class="table-card mb-4">
    <div class="d-flex flex-column flex-lg-row justify-content-between gap-3 align-items-lg-center mb-3">
      <div>
        <h2 class="h5 mb-1">Weekly rota view</h2>
        <div class="footer-note">Desktop shows the full company grid. Mobile users can switch to card view for a faster staff-friendly layout.</div>
      </div>
      <div class="view-toggle">
        <button class="btn active" id="tableViewBtn" type="button">Table view</button>
        <button class="btn" id="cardViewBtn" type="button">Card view</button>
      </div>
    </div>

    <div class="desktop-only" id="desktopTableWrap">
      <div class="table-responsive">
        <table class="table table-bordered align-middle rota-table mb-0" id="rotaTable">
          <thead>
            <tr>
              <th class="sticky-col">Staff</th>
              <th class="sticky-col-2">Role / Company</th>
              <th>Mon</th>
              <th>Tue</th>
              <th>Wed</th>
              <th>Thu</th>
              <th>Fri</th>
              <th>Sat</th>
              <th>Sun</th>
              <th>Contract</th>
              <th>Total</th>
              <th>Variance</th>
            </tr>
          </thead>
          <tbody id="rotaBody"></tbody>
        </table>
      </div>
    </div>

    <div class="mobile-list mobile-only" id="mobileList"></div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>