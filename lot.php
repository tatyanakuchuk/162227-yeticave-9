<?php
session_start();

$is404error = false;

require_once('functions.php');
require_once ('data.php');

//проверка подключения
if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    if (isset($_GET['id'])) {
        $lot_id = $_GET['id'];
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
        if(empty($lot)) {
            header('Location: /error.php');
            http_response_code(404);
            $is404error = true;
        }
    } else {
        //получаем текст последней ошибки
        $error = mysqli_error($connect);
        print($error);
    }

//    //запрос для получения списка категорий;
    $sql = 'SELECT * FROM categories';
    $res_cat = mysqli_query($connect, $sql);
    if ($res_cat) {
        $categories = mysqli_fetch_all($res_cat, MYSQLI_ASSOC);
    } else {
        $error = mysqli_error($connect);
        print($error);
    }
}


$nav = include_template('nav.php', [
    'categories' => $categories
]);

if ($is404error) {
    $content = $content = include_template('error.php', [
        'categories' => $categories,
        'nav' => $nav
    ]);
} else {
    $content = include_template('lot.php', [
        'categories' => $categories,
        'nav' => $nav,
        'lot' => $lot[0],
        $is_lot_page = true
    ]);
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['name'];
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'is_auth' => $is_auth,
        'username' =>  $username,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Лот',
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'is_auth' => $is_auth,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Лот',
        'isMainPage' => false
    ]);
}

print($layout_content);


