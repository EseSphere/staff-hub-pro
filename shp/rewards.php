<?php
$pageTitle = 'Staff Hub Pro - Rewards';
$activePage = 'rewards';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-rewards">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">Rewards, Perks & Fun</div>
        <p class="hero-subtitle">A light, positive space that makes the app feel rewarding, not just operational.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Your current points</div>
        <div class="fs-5 fw-bold mb-2" id="rewardPointsHeader">0 points</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill">🏅 Recognition</span>
          <span class="emergency-pill">🎉 Staff engagement</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="perk-card h-100">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <div>
            <div class="page-heading h4 mb-1">Perks & challenges</div>
            <div class="footer-note">Small entertaining features increase repeat visits.</div>
          </div>
          <button class="btn btn-soft">Redeem points</button>
        </div>
        <div class="perk-list" id="perkList"></div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="kudos-card h-100">
        <div class="page-heading h4 mb-1">Staff spotlight</div>
        <div class="footer-note mb-3">Recognition helps people feel seen.</div>
        <div id="spotlightCard"></div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>