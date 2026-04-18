<?php
$pageTitle = 'Staff Hub Pro - Profile';
$activePage = 'profile';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-profile">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">My Profile</div>
        <p class="hero-subtitle">A personal staff space for rota summary, training, recognition, and company presence.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Profile status</div>
        <div class="fs-5 fw-bold mb-2">Active staff member</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill">👤 Personal view</span>
          <span class="emergency-pill">📈 Weekly snapshot</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-4">
      <div class="profile-card h-100" id="profileMainCard"></div>
    </div>

    <div class="col-lg-8">
      <div class="row g-3">
        <div class="col-md-6">
          <div class="notice-card h-100" id="profileWeeklyCard"></div>
        </div>
        <div class="col-md-6">
          <div class="notice-card h-100" id="profileAchievementCard"></div>
        </div>
        <div class="col-12">
          <div class="notice-card" id="profileChecklistCard"></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>