<?php if ($pages_count > 1): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev">
        <!--Пагинация на странице поиска-->
        <?php if (isset($isSearchPage)): ?>
            <a <?php if ($current_page > 1): ?>
                href="/search.php?page=<?= $current_page - 1; ?>&search=<?= $_GET['search']; ?>&find=<?=$_GET['find'];?>"
            <?php endif; ?>>Назад</a>
        </li>
        <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?php if ($page == $current_page): ?> pagination-item-active <?php endif; ?>">
            <a href="/search.php?page=<?=$page;?>&search=<?=$_GET['search'];?>&find=<?=$_GET['find'];?>"><?= $page; ?></a>
        </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
            <a <?php if ($current_page < count($pages)): ?>
                    href="/search.php?page=<?= $current_page + 1; ?>&search=<?= $_GET['search']; ?>&find=<?=$_GET['find'];?>"
            <?php endif; ?>>Вперед</a>
        <!-- end Пагинация на странице поиска-->

        <!--Пагинация лотов по категориям-->
        <?php elseif (isset($isCategoriesPage)): ?>
            <a <?php if ($current_page > 1): ?>
                href="/all-lots.php?page=<?= $current_page - 1; ?>&category=<?= $_GET['category']; ?>"
            <?php endif; ?>>Назад</a>
        </li>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?php if ($page == $current_page): ?> pagination-item-active <?php endif; ?>">
                <a href="/all-lots.php?page=<?=$page;?>&category=<?= $_GET['category'] ;?>"><?= $page; ?></a>
            </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
            <a <?php if ($current_page < count($pages)): ?>
                href="/all-lots.php?page=<?= $current_page + 1; ?>&category=<?= $_GET['category']; ?>"
            <?php endif; ?>>Вперед</a>
        <!-- end Пагинация лотов по категориям-->

        <!--Пагинация всех лотов-->
        <?php else: ?>
            <a <?php if ($current_page > 1): ?>
                href="/index.php?page=<?= $current_page - 1; ?>"
            <?php endif; ?>>Назад</a>
        </li>
        <?php foreach ($pages as $page): ?>
            <li class="pagination-item <?php if ($page == $current_page): ?> pagination-item-active <?php endif; ?>">
                <a href="/index.php?page=<?=$page;?>"><?= $page; ?></a>
            </li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next">
            <a <?php if ($current_page < count($pages)): ?>
                href="/index.php?page=<?= $current_page + 1; ?>"
            <?php endif; ?>>Вперед</a>
        <!--end Пагинация всех лотов-->
        <?php endif; ?>
        </li>
    </ul>
<?php endif; ?>