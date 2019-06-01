<?php
//подключение к MySQL
$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

//$is_auth = rand(0, 1);
//$user_id = 3;
$avatar = 'Путь к картинке';
//$user_name = 'Татьяна';

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
    $finish_date = date_create($lot_time);
    $diff = date_diff($current_date, $finish_date);
    $time_left = date_interval_format($diff, "%H:%i:%s");
    $time_left_sec = (strtotime($lot_time) - strtotime("now"));
    $lot_expiry_sec = 3600;
    $timer_class = ($isMainPage) ? 'lot__timer' : 'lot-item__timer';
    if ($time_left_sec <= $lot_expiry_sec) {
        return '<div class="' . $timer_class . ' timer timer--finishing">' . $time_left . '</div>';
    } else {
        return '<div class="' . $timer_class . ' timer">' . $time_left . '</div>';
    }
}

function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

function bet_timer($bet_dt_add)
{
    $current_date = date_create("now");
    $yesterday_date = date_create("yesterday");
    $add_date = date_create($bet_dt_add);
    $diff = date_diff($current_date, $add_date);
    $remaining_hours = date_interval_format($diff, "%h");
    $remaining_minutes = date_interval_format($diff, "%i");

    if (date_format($current_date, "Y-m-d") == date_format($add_date, "Y-m-d"))
    {
        $get_hours = $remaining_hours . ' ' . get_noun_plural_form(
                $remaining_hours,
                'час',
                'часа',
                'часов'
            );
        $get_minutes = $remaining_minutes . ' ' . get_noun_plural_form(
                $remaining_minutes,
                'минута',
                'минуты',
                'минут'
            );
        if ($remaining_hours == 0 && $remaining_minutes != 0) {
            return $get_minutes . ' назад';
        } elseif ($remaining_hours == 1 && $remaining_minutes == 0) {
            return 'Час назад';
        } elseif ($remaining_hours != 0 && $remaining_minutes == 0) {
            return $get_hours . ' назад';
        } else {
            return $get_hours . ' ' . $get_minutes . ' назад';

        }
    }
    elseif (date_format($add_date, "Y-m-d") == date_format($yesterday_date, "Y-m-d")) {
        return 'Вчера, в ' . date_format($add_date, "H:i");
    }
    else {
        return date_format($add_date, "d.m.y") . ' в ' . date_format($add_date, "H:i");
    }
}