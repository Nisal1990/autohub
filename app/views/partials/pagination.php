<?php if (($pag['total_pages'] ?? 1) > 1): ?>
<nav class="mt-4" aria-label="Pagination">
  <ul class="pagination justify-content-center flex-wrap">
    <?php if ($pag['has_prev']): ?>
      <li class="page-item">
        <a class="page-link" href="?<?= buildQuery(array_merge($_GET, ['page' => $pag['prev']])) ?>">
          <i class="bi bi-chevron-left"></i>
        </a>
      </li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-left"></i></span></li>
    <?php endif; ?>

    <?php
    $start = max(1, $pag['current'] - 2);
    $end   = min($pag['total_pages'], $pag['current'] + 2);
    if ($start > 1): ?>
      <li class="page-item"><a class="page-link" href="?<?= buildQuery(array_merge($_GET, ['page' => 1])) ?>">1</a></li>
      <?php if ($start > 2): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
    <?php endif; ?>

    <?php for ($i = $start; $i <= $end; $i++): ?>
      <li class="page-item <?= $i === $pag['current'] ? 'active' : '' ?>">
        <a class="page-link" href="?<?= buildQuery(array_merge($_GET, ['page' => $i])) ?>"><?= $i ?></a>
      </li>
    <?php endfor; ?>

    <?php if ($end < $pag['total_pages']): ?>
      <?php if ($end < $pag['total_pages'] - 1): ?><li class="page-item disabled"><span class="page-link">…</span></li><?php endif; ?>
      <li class="page-item"><a class="page-link" href="?<?= buildQuery(array_merge($_GET, ['page' => $pag['total_pages']])) ?>"><?= $pag['total_pages'] ?></a></li>
    <?php endif; ?>

    <?php if ($pag['has_next']): ?>
      <li class="page-item">
        <a class="page-link" href="?<?= buildQuery(array_merge($_GET, ['page' => $pag['next']])) ?>">
          <i class="bi bi-chevron-right"></i>
        </a>
      </li>
    <?php else: ?>
      <li class="page-item disabled"><span class="page-link"><i class="bi bi-chevron-right"></i></span></li>
    <?php endif; ?>
  </ul>
  <p class="text-center text-muted small">
    Showing page <?= $pag['current'] ?> of <?= $pag['total_pages'] ?> (<?= number_format($pag['total']) ?> results)
  </p>
</nav>
<?php endif; ?>
