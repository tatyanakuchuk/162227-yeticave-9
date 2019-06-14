<div class="lot-item__state">
    <?= timer($lot['dt_remove']); ?>
    <div class="lot-item__cost-state">
        <div class="lot-item__rate">
            <span class="lot-item__amount">Текущая цена</span>
            <span class="lot-item__cost"><?= $lot['sum_start']; ?></span>
        </div>
        <div class="lot-item__min-cost">
            Мин. ставка <span><?= $lot['bet_step'] ? $lot['sum_start'] + $lot['bet_step'] : $lot['sum_start']; ?></span>
        </div>
    </div>
    <?php $classname = isset($errors['cost']) ? "form__item--invalid" : "";
    $value = isset($bet['cost']) ? $bet['cost'] : ""; ?>
    <form class="lot-item__form <?= $classname; ?>" action="../lot.php" method="post" autocomplete="off">
        <p class="lot-item__form-item form__item ">
            <label for="cost">Ваша ставка</label>
            <input id="cost" type="text" name="cost" placeholder="12 000" value="<?= $value; ?>">
            <input type="hidden" name="lot-id" value="<?= isset($lot_id) ? $lot_id : ''; ?>">
            <span class="form__error"><?= isset($errors['cost']) ? $errors['cost'] : ''; ?></span>
        </p>
        <button type="submit" class="button">Сделать ставку</button>
    </form>
</div>