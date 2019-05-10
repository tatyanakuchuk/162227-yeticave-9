<?php

require_once('functions.php');

//подключение к MySQL
$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

//проверка подключения
if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {

    if (isset($_GET['id'])) {
        $lot = $_GET;
        $lot_id = $_GET['id'];
        $lot_desc = $_GET['description'];

        $script_name = pathinfo(__FILE__, PATHINFO_BASENAME);
        $query = http_build_query($lot);
        $url = '/' . $script_name . '?' . $query;

//        print_r($url);
    }
    //создаем запрос для получения данных лота
    $sql_lot = 'SELECT l.id, title, description, img_path, sum_start, bet_step, c.name, dt_remove FROM lots l ' .
                'JOIN categories c ON l.category_id = c.id ' .
                'WHERE l.id = ' . $lot_id;
    //отправляем запрос и получаем результат
    $res_lot = mysqli_query($connect, $sql_lot);
    //запрос выполнен успешно
    if($res_lot) {
        //получаем данные лота в виде двумерного массива
        $lot = mysqli_fetch_all($res_lot, MYSQLI_ASSOC);
//        print_r($lot);
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

$is_auth = rand(0, 1);

$user_name = 'Татьяна';

function price_format($numb) {
    $decimals = 0;
    $dec_point = ".";
    $thousands_sep = " ";
    $price_formated = number_format(
        ceil($numb),
        $decimals,
        $dec_point,
        $thousands_sep
    );
    return $price_formated . '<b class="rub">₽</b>';
}

function timer($lot_time) {
    $current_date = date_create("now");
    $finish_date = date_create("$lot_time");
    $diff = date_diff($current_date, $finish_date);
    $time_left = date_interval_format($diff, "%H:%i");
    $time_left_sec = (strtotime("$lot_time") - strtotime("now"));
    $lot_expiry_sec = 3600;
    if ($time_left_sec <= $lot_expiry_sec) {
        return '<div class="lot__timer timer timer--finishing">' . $time_left . '</div>';
    } else {
        return '<div class="lot__timer timer">' . $time_left . '</div>';
    }
}

$nav = include_template('nav.php', [
    'categories' => $categories
]);

$content = include_template('lot.php', [
    'categories' => $categories,
    'nav' => $nav,
    'lot' => $lot
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


