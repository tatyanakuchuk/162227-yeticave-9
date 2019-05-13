<?php

require_once('functions.php');
require_once ('data.php');

//проверка подключения
if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    //создаем запрос для получения списка новых лотов
    $sql_lots = 'SELECT l.id, title, img_path, sum_start, bet_step, c.name, dt_remove FROM lots l ' .
                'JOIN categories c ON l.category_id = c.id  ' .
                'WHERE dt_remove > NOW() ORDER BY dt_add DESC LIMIT 6';
    //отправляем запрос и получаем результат
    $res_lots = mysqli_query($connect, $sql_lots);
    //запрос выполнен успешно
    if($res_lots) {
        //получаем лоты в виде двумерного массива
        $lots = mysqli_fetch_all($res_lots, MYSQLI_ASSOC);
    } else {
        //получаем текст последней ошибки
        $error = mysqli_error($connect);
        print('Ошибка MySQL: ' . $error);
    }

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

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $content,
    'categories' => $categories,
    'title' => 'Главная',
    'isMainPage' => true
]);

print($layout_content);



