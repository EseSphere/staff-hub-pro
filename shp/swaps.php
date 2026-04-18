<?php
$pageTitle = 'Staff Hub Pro - Shift Board';
$activePage = 'swaps';
include 'includes/head.php';
include 'includes/navbar.php';
?>

<section id="page-swaps">
  <div class="hero-card mb-4">
    <div class="d-flex flex-column flex-xl-row justify-content-between gap-3 align-items-xl-center">
      <div class="hero-meta">
        <div class="hero-title">Shift Board</div>
        <p class="hero-subtitle">A staff-engaging board for swap requests, extra cover, and open opportunities within your company.</p>
      </div>
      <div class="hero-meta text-xl-end">
        <div class="small-label text-white-50">Live board</div>
        <div class="fs-5 fw-bold mb-2">Open opportunities</div>
        <div class="d-flex flex-column flex-sm-row gap-2 justify-content-xl-end">
          <span class="emergency-pill">📌 Same-company board</span>
          <span class="emergency-pill">⚡ Quick claims</span>
        </div>
      </div>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-7">
      <div class="panel h-100">
        <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
          <div>
            <div class="page-heading h4 mb-1">Available shifts & swaps</div>
            <div class="footer-note">Use this page to make the app more useful beyond only checking rota.</div>
          </div>
          <button class="btn btn-accent">Request a swap</button>
        </div>
        <div class="swap-list" id="swapList"></div>
      </div>
    </div>

    <div class="col-lg-5">
      <div class="notice-card h-100">
        <div class="page-heading h4 mb-1">How it helps staff</div>
        <div class="footer-note mb-3">This is the kind of feature that makes people revisit the app.</div>

        <div class="highlight-card mb-3">
          <div class="small-label text-dark">Suggested behaviour</div>
          <div class="mt-2 small text-secondary">Let staff offer shifts, browse extra cover, and express interest. Even a simple board massively increases daily usage.</div>
        </div>

        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Find extra hours</div>
            <div class="small text-secondary">Great for staff under contract hours.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Reduce admin calls</div>
            <div class="small text-secondary">Staff can spot open shifts before contacting managers.</div>
          </div>
        </div>
        <div class="check-row">
          <span class="check-dot"></span>
          <div>
            <div class="fw-semibold">Feels useful daily</div>
            <div class="small text-secondary">Not just once-a-week rota checking anymore.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>