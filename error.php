<?php

require_once('functions.php');

$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

if($connect == false) {

    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
//    $error_code = http_response_code(404);
    print_r($error_code);
    //запрос для получения списка категорий;
    $sql = 'SELECT * FROM categories';
    $res_cat = mysqli_query($connect, $sql);
    if ($res_cat) {
        $categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connect);
        print('Ошибка MySQL: ' . $error);
    }
}

$is_auth = rand(0, 1);

$user_name = 'Татьяна';

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$content = include_template('error.php', [
    'nav' => $nav
]);

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



