<?php
session_start();

require_once('functions.php');
require_once ('data.php');

if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    $sql = 'SELECT * FROM categories';
    $res_cat = mysqli_query($connect, $sql);
    if ($res_cat) {
        $categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
        $nav = include_template('nav.php', [
            'categories' => $categories
        ]);
    } else {
        $error = mysqli_error($connect);
        print('Ошибка MySQL: ' . $error);
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $login = $_POST;
        $required = ['email', 'password'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                if ($key == 'email') {
                    $errors[$key] = 'Введите e-mail';
                }
                if ($key == 'password') {
                    $errors[$key] = 'Введите пароль';
                }
            }
        }

        if (!empty($login['email'])) {
            if (!filter_var($login['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email должен быть корректным';
            }
        }

        $sql = 'SELECT * FROM users WHERE email = "' . $login['email'] . '"';
        $res_pass = mysqli_query($connect, $sql);
        $user = $res_pass ? mysqli_fetch_all($res_pass, MYSQLI_ASSOC) : null;
        if ($user) {
            if (password_verify($login['password'], $user[0]['password'])) {
                $_SESSION['user'] = $user[0];
            } else {
                $errors['password'] = 'Вы ввели неверный пароль';
            }
        }

        if (count($errors)) {
            $content = include_template('login.php', [
                'nav' => $nav,
                'title' => 'Вход',
                'login' => $login,
                'errors' => $errors
            ]);
        } else {
            header('Location: /');
            exit();
        }
    } else {
        if (isset($_SESSION['user'])) {
            $content = include_template('login.php', [
                'nav' => $nav,
                'title' => 'Вход',
            ]);
        }
        else {
            $content = include_template('login.php', [
                'nav' => $nav,
                'title' => 'Вход'
            ]);
        }
    }
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['name'];
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Вход',
        'username' => $username,
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Вход',
        'isMainPage' => false
    ]);
}

print($layout_content);

