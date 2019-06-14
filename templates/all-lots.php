<?= $nav; ?>
<div class="container">
    <section class="lots">
        <h2>Все лоты в категории <span>«<?= $_GET['category']; ?>»</span></h2>
        <ul class="lots__list">
            <?php foreach ($lots as $lot): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $lot['img_path']; ?>" width="350" height="260" alt="Сноуборд">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $lot['name']; ?></span>
                        <h3 class="lot__title"><a class="text-link" href="/lot.php?id=<?= $lot['lot']; ?>"><?= esc($lot['title']); ?></a></h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <?php if (empty($lot['last_bet'])): ?>
                                    <span class="lot__amount">Стартовая цена</span>
                                    <span class="lot__cost"><?= price_format($lot['sum_start']); ?></span>
                                <?php else: ?>
                                    <span class="lot__amount"><?= get_plural_form_bets($lot['count_bets']); ?> </span>
                                    <span class="lot__cost"><?= price_format($lot['last_bet']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?= timer($lot['dt_remove']); ?>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?= $pagination; ?>
</div>