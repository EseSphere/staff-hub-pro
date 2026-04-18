<?php
$pageTitle = 'Staff Hub Pro - Team';
$activePage = 'team';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-team">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">My Team</div>
        <p class="hero-subtitle">A cleaner same-company team view with quick role awareness, night cover visibility, and colleague-friendly cards.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Company directory</div>
        <div class="fs-5 fw-bold mb-2" id="teamCompanyTitle">Care Home A</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill">🤝 Same-company staff only</span>
          <span class="emergency-pill">💬 Easy visibility</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="panel h-100">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
          <div>
            <div class="page-heading h4 mb-1">Team directory</div>
            <div class="footer-note">People you work with in your company.</div>
          </div>
          <div class="status-pill" id="teamCountPill">0 team members</div>
        </div>
        <div class="team-list" id="teamList"></div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="notice-card h-100">
        <div class="page-heading h4 mb-1">Helpful team info</div>
        <div class="footer-note mb-3">Useful details that make the app feel alive and practical.</div>

        <div class="highlight-card mb-3">
          <div class="small-label text-dark">Most active shift type</div>
          <div class="fs-4 fw-bold" id="teamTopShiftType">Assigned</div>
          <div class="muted small">Based on current visible company rota.</div>
        </div>

        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Night cover visibility</div>
            <div class="small text-secondary">Quickly spot colleagues on nights this week.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Role awareness</div>
            <div class="small text-secondary">See who is support, senior, relief, or waking night.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Personal marker</div>
            <div class="small text-secondary">Your own staff card is clearly highlighted.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>