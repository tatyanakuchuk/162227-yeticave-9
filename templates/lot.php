<?= $nav; ?>
<section class="lot-item container">
    <h2><?= $lot['title']; ?></h2>
    <div class="lot-item__content">
        <div class="lot-item__left">
            <div class="lot-item__image">
                <img src="<?= $lot['img_path']; ?>" width="730" height="548" alt="Сноуборд">
            </div>
            <p class="lot-item__category">Категория: <span><?= $lot['name']; ?></span></p>
            <p class="lot-item__description"><?= $lot['description']; ?></p>
        </div>
        <div class="lot-item__right">
            <?php if (isset($_SESSION['user'])): ?>
                <?= isset($add_bet) ? $add_bet : ''; ?>
            <?php endif; ?>
            <div class="history">
                <h3>История ставок (<span><?= count($bets); ?></span>)</h3>
                <table class="history__list">
                    <?php foreach ($bets as $bet): ?>
                    <tr class="history__item">
                        <td class="history__name"><?= $bet['name']; ?></td>
                        <td class="history__price"><?= $bet['sum']; ?> р</td>
                        <td class="history__time"><?= $bet['dt_add']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</section>
