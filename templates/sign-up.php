<?= $nav; ?>
<?php $classname = !empty($errors) ? "form--invalid" : ""; ?>
<form class="form container <?= $classname; ?>" action="../sign-up.php" method="post" autocomplete="off">
    <h2>Регистрация нового аккаунта</h2>
    <?php $classname = isset($errors['email']) ? "form__item--invalid" : "";
    $value = isset($sign_up['email']) ? $sign_up['email'] : ""; ?>
    <div class="form__item  <?= $classname; ?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $value; ?>">
        <span class="form__error"><?= $errors['email']; ?></span>
    </div>
    <?php $classname = isset($errors['password']) ? "form__item--invalid" : "";
    $value = isset($sign_up['password']) ? $sign_up['password'] : ""; ?>
        <div class="form__item  <?= $classname; ?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?= $value; ?>">
        <span class="form__error"><?= $errors['password']; ?></span>
    </div>
    <?php $classname = isset($errors['name']) ? "form__item--invalid" : "";
    $value = isset($sign_up['name']) ? $sign_up['name'] : ""; ?>
    <div class="form__item  <?= $classname; ?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="name" placeholder="Введите имя" value="<?= $value; ?>">
        <span class="form__error"><?= $errors['name']; ?></span>
    </div>
    <?php $classname = isset($errors['message']) ? "form__item--invalid" : "";
    $value = isset($sign_up['message']) ? $sign_up['message'] : ""; ?>
    <div class="form__item  <?= $classname; ?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="message" placeholder="Напишите как с вами связаться"><?= $value; ?></textarea>
        <span class="form__error"><?= $errors['message']; ?></span>
    </div>
    <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
    <button type="submit" class="button">Зарегистрироваться</button>
    <a class="text-link" href="#">Уже есть аккаунт</a>
</form>