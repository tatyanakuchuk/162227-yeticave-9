<?php

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
        $sign_up = $_POST;
        $required = ['email', 'password', 'name', 'message'];
        $errors = [];

        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                if ($key == 'email') {
                    $errors[$key] = 'Введите e-mail';
                }
                if ($key == 'password') {
                    $errors[$key] = 'Введите пароль';
                }
                if ($key == 'name') {
                    $errors[$key] = 'Введите имя';
                }
                if ($key == 'message') {
                    $errors[$key] = 'Напишите как с вами связаться';
                }
            }
        }

        $email = $sign_up['email'];

        //проверка email на корректность
        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email должен быть корректным';
            }
        }

        // проверка на существование пользователя с таким же email
        if (!empty($email)) {
            $sql = 'SELECT id FROM users WHERE email = "' . $email . '"';
            $res_email = mysqli_query($connect, $sql);
            if($res_email) {
                $emails = mysqli_fetch_all($res_email, MYSQLI_ASSOC);
                if(!empty($emails)) {
                    $errors['email'] = 'Введённый вами email уже зарегистрирован. Введите другой email.';
                }
            }
        }

        if(count($errors)) {
            $content = include_template('sign-up.php', ['sign_up' => $sign_up, 'nav' => $nav, 'errors' => $errors]);
        } else {
            $sql = 'INSERT INTO users (dt_add, name, email, password, avatar, contact)' .
                ' VALUES (NOW(), ?, ?, ?, ?, ?)';
            $stmt = db_get_prepare_stmt($connect, $sql, [$sign_up['name'], $sign_up['email'], $sign_up['password'],
                                        $avatar, $sign_up['message']]);
            $res = mysqli_stmt_execute($stmt);
            if ($res) {
                $user_id = mysqli_insert_id($connect);
                header('Location: /');
            }
        }
    } else {
        $content = include_template('sign-up.php', ['nav' => $nav]);
    }
}

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $content,
    'categories' => $categories,
    'title' => 'Главная',
    'isMainPage' => false
]);

print($layout_content);



