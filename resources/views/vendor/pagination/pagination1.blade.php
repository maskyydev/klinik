<nav aria-label="Page navigation">
    <ul class="pagination flex justify-center items-center space-x-1">
        <!-- Previous Page -->
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Previous</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link" aria-label="Previous">
                    <span aria-hidden="true">&laquo; Previous</span>
                </span>
            </li>
        <?php endif; ?>

        <!-- Page Numbers -->
        <?php
        $pagerLinks = $pager->links();
        $totalPages = count($pagerLinks);
        $currentPage = $pager->getCurrentPageNumber(); // Metode yang benar untuk mendapatkan halaman saat ini

        $startPage = max(1, $currentPage - 5);
        $endPage = min($totalPages, $currentPage + 4);

        // Batasi jumlah halaman yang ditampilkan hingga 10
        $startPage = max(1, min($startPage, $totalPages - 9));
        $endPage = min($totalPages, $startPage + 9);

        $visibleLinks = array_slice($pagerLinks, $startPage - 1, 10);
        ?>

        <?php foreach ($visibleLinks as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach; ?>

        <!-- Next Page -->
        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </a>
            </li>
        <?php else: ?>
            <li class="page-item disabled">
                <span class="page-link" aria-label="Next">
                    <span aria-hidden="true">Next &raquo;</span>
                </span>
            </li>
        <?php endif; ?>
    </ul>
</nav>
