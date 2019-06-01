<?php
session_start();

require_once('functions.php');
require_once ('data.php');

//проверка подключения
if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    //запрос для получения списка категорий;
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

    //запрос для получения списка ставок пользователя
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];

        $sql_bets = 'SELECT l.id, title, b.dt_add, b.user_id, l.dt_remove, img_path, title, sum, ' .
            '(SELECT u.contact FROM users u WHERE u.id = l.user_id) AS user_contact, ' .
            '(SELECT b.user_id FROM bets b WHERE b.lot_id = l.id ORDER BY b.dt_add DESC LIMIT 1) AS last_bet_user_id, ' .
            '(SELECT name FROM categories WHERE id = l.category_id) AS category_name ' .
            'FROM bets b JOIN lots l ON b.lot_id = l.id  ' .
            'WHERE b.user_id = ' . $user_id .
            ' ORDER BY b.dt_add DESC LIMIT 7';
        $res = mysqli_query($connect, $sql_bets);
        if ($res) {
            $bets = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $content = include_template('bets.php', [
                'categories' => $categories,
                'nav' => $nav,
                'title' => 'Мои ставки',
                'bets' => $bets,
                'user_id' => $user_id
            ]);
        } else {
            $error = mysqli_error($connect);
            print('Ошибка MySQL: ' . $error);
        }
    }
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['name'];
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'username' =>  $username,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Мои ставки',
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Мои ставки',
        'isMainPage' => false
    ]);
}

print($layout_content);



