<?php

require_once('functions.php');

//подключение к MySQL
$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

//проверка подключения
if($connect == false) {
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    //создаем запрос для получения списка новых лотов
    $sql_lots = 'SELECT l.id, title, img_path, sum_start, bet_step, c.name FROM lots l ' .
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
    if($res_cat) {
        $categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connect);
        print('Ошибка MySQL: ' . $error);
    }
}

$is_auth = rand(0, 1);

$user_name = 'Татьяна';
//
//$categories = [
//    'Доски и лыжи', 'Крепления', 'Ботинки', 'Одежда', 'Инструменты', 'Разное'
//];

//$lots = [
//    [
//        'name' => '2014 Rossignol District Snowboard',
//        'category' => 'Доски и лыжи',
//        'price' => 10999,
//        'img' => 'img/lot-1.jpg'
//    ],
//    [
//        'name' => 'DC Ply Mens 2016/2017 Snowboard',
//        'category' => 'Доски и лыжи',
//        'price' => 159999,
//        'img' => 'img/lot-2.jpg'
//    ],
//    [
//        'name' => 'Крепления Union Contact Pro 2015 года размер L/XL',
//        'category' => 'Крепления',
//        'price' => 8000,
//        'img' => 'img/lot-3.jpg'
//    ],
//    [
//        'name' => 'Ботинки для сноуборда DC Mutiny Charocal',
//        'category' => 'Ботинки',
//        'price' => 10999,
//        'img' => 'img/lot-4.jpg'
//    ],
//    [
//        'name' => 'Куртка для сноуборда DC Mutiny Charocal',
//        'category' => 'Одежда',
//        'price' => 7500,
//        'img' => 'img/lot-5.jpg'
//    ],
//    [
//        'name' => 'Маска Oakley Canopy',
//        'category' => 'Разное',
//        'price' => 5400,
//        'img' => 'img/lot-6.jpg'
//    ]
//];

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

$page_content = include_template('index.php', [
    'categories' => $categories,
    'lots' => $lots
]);

$layout_content = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $page_content,
    'categories' => $categories,
    'title' => 'Главная'
]);

print($layout_content);


