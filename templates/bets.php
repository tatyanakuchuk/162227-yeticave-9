<nav class="nav">
    <ul class="nav__list container"><?= $nav; ?></ul>
</nav>
<section class="rates container">
    <h2><?= $title; ?></h2>
    <table class="rates__list">

        <?php foreach ($bets as $bet): ?>
        <?php if (date_create($bet['dt_remove']) <= date_create("now")) {
                if ($bet['last_bet_user_id'] == $user_id) {
                    $classname = "rates__item--win";
                    $rates_timer = '<div class="timer timer--win">Ставка выиграла</div>';
                } else {
                    $classname = "rates__item--end";
                    $rates_timer =  '<div class="timer timer--end">Торги окончены</div>';
                }
            } else {
                $classname = "";
                $rates_timer = timer($bet['dt_remove']);
            }
        ?>
        <tr class="rates__item <?= $classname; ?>">
            <td class="rates__info">
                <div class="rates__img">
                    <img src="<?= $bet['img_path']; ?>" width="54" height="40" alt="Сноуборд">
                </div>
                <?php if ((date_create($bet['dt_remove']) <= date_create("now")) && ($bet['last_bet_user_id'] == $user_id)): ?>
                <div>
                    <h3 class="rates__title"><a href="/lot.php?id=<?= $bet['id']; ?>"><?= $bet['title']; ?></a></h3>
                    <p><?= $bet['user_contact']; ?></p>
                </div>
                <?php else: ?>
                <h3 class="rates__title"><a href="/lot.php?id=<?= $bet['id']; ?>"><?= $bet['title']; ?></a></h3>
                <?php endif; ?>

            </td>
            <td class="rates__category">
                <?= $bet['category_name']; ?>
            </td>
            <td class="rates__timer">
                <?= $rates_timer; ?>
            </td>
            <td class="rates__price">
                <?= $bet['sum']; ?> р
            </td>
            <td class="rates__time">
                <?= bet_timer($bet['dt_add']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>