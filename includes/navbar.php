<?php
if (!isset($activePage)) {
    $activePage = 'dashboard';
}

function isActive($page, $activePage) {
    return $page === $activePage ? 'active' : '';
}
?>

<div class="top-nav">
  <nav class="navbar navbar-expand-lg glass-nav">
    <div class="container-fluid px-1">
      <a class="navbar-brand" href="dashboard.php">
        <span class="brand-badge">S</span>
        <span>Staff Hub Pro</span>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#staffNavbar" aria-controls="staffNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="staffNavbar">
        <ul class="navbar-nav mx-auto mb-3 mb-lg-0 gap-lg-1">
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('dashboard', $activePage) ?>" href="dashboard.php">Home</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('rota', $activePage) ?>" href="rota.php">Rota</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('team', $activePage) ?>" href="team.php">Team</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('swaps', $activePage) ?>" href="swaps.php">Shift Board</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('training', $activePage) ?>" href="training.php">Training</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('rewards', $activePage) ?>" href="rewards.php">Rewards</a></li>
          <li class="nav-item"><a class="nav-link staff-link <?= isActive('profile', $activePage) ?>" href="profile.php">Profile</a></li>
        </ul>

        <div class="d-flex flex-column flex-lg-row gap-2 align-items-lg-center">
          <div class="nav-pill" id="navUserPill">👤 Staff</div>
          <div class="nav-pill" id="navCompanyPill">🏢 Company</div>
        </div>
      </div>
    </div>
  </nav>
</div>