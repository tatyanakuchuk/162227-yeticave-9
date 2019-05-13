<?php
//подключение к MySQL
$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

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

function timer($lot_time, $isMainPage = false) {
    $current_date = date_create("now");
    $finish_date = date_create("$lot_time");
    $diff = date_diff($current_date, $finish_date);
    $time_left = date_interval_format($diff, "%H:%i");
    $time_left_sec = (strtotime("$lot_time") - strtotime("now"));
    $lot_expiry_sec = 3600;
    $timer_class = ($isMainPage) ? 'lot__timer' : 'lot-item__timer';
    if ($time_left_sec <= $lot_expiry_sec) {
        return '<div class="' . $timer_class . ' timer timer--finishing">' . $time_left . '</div>';
    } else {
        return '<div class="' . $timer_class . ' timer">' . $time_left . '</div>';
    }
}