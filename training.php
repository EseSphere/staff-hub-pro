<?php
$pageTitle = 'Staff Hub Pro - Training';
$activePage = 'training';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-training">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">Training & Compliance</div>
        <p class="hero-subtitle">Give staff a reason to return for progress tracking, reminders, badges, and learning milestones.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Learning streak</div>
        <div class="fs-5 fw-bold mb-2" id="learningStreak">5 days</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill">🎓 Mandatory modules</span>
          <span class="emergency-pill">✅ Progress tracking</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-8">
      <div class="training-card h-100">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <div>
            <div class="page-heading h4 mb-1">Training progress</div>
            <div class="footer-note">Turn mandatory learning into a visible staff habit.</div>
          </div>
          <span class="streak-badge">🔥 Streak active</span>
        </div>
        <div class="training-list" id="trainingList"></div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="notice-card h-100">
        <div class="page-heading h4 mb-1">Why staff will revisit</div>
        <div class="footer-note mb-3">Visible progress makes compliance feel more personal.</div>

        <div class="highlight-card mb-3">
          <div class="small-label text-dark">Completion rate</div>
          <div class="fs-4 fw-bold" id="trainingCompletionRate">0%</div>
          <div class="muted small">Across current modules shown below.</div>
        </div>

        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Badges and streaks</div>
            <div class="small text-secondary">Gamifies completion without changing your design style.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Expiry reminders</div>
            <div class="small text-secondary">Useful and practical for both staff and management.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Micro progress</div>
            <div class="small text-secondary">Staff like seeing visible progress bars.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>