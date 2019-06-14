<?php
session_start();
$isSearchPage = true;
require_once('functions.php');
require_once ('data.php');

//проверка подключения
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

    //создаем запрос для получения списка лотов
    $lots = [];
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if ($search)
    {
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

        $res_count_lots = mysqli_query($connect, 'SELECT count(*) AS cnt FROM lots WHERE MATCH(title, description) AGAINST(' . '"'. $search . '"' .')');
        $items_count = mysqli_fetch_assoc($res_count_lots)['cnt'];

        $page_items = 9;
        $offset = ($current_page - 1) * $page_items;

        $pages_count = ceil($items_count / $page_items);
        $pages = range(1, $pages_count);

        $title = 'Результаты поиска по запросу «' . $search . '»';

        $sql_lots = 'SELECT l.id AS lot, count(b.id) AS count_bets, title, description, img_path, sum_start, c.name, dt_remove, ' .
            '(SELECT sum FROM bets b WHERE b.lot_id = lot ORDER BY b.dt_add DESC LIMIT 1) AS last_bet ' .
            'FROM lots l ' .
            'LEFT JOIN bets b ON b.lot_id = l.id ' .
            'JOIN categories c ON l.category_id = c.id ' .
            'WHERE MATCH(title, description) AGAINST(?) ' .
            'GROUP BY lot ORDER BY dt_remove DESC LIMIT ' . $page_items . ' OFFSET ' . $offset;

        $stmt = db_get_prepare_stmt($connect, $sql_lots, [
            $search
        ]);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($res) {
            $lots = mysqli_fetch_all($res, MYSQLI_ASSOC);
            $pagination = include_template('pagination.php', [
                'pages_count' => $pages_count,
                'pages' => $pages,
                'current_page' => $current_page,
                'isSearchPage' => $isSearchPage
            ]);

            $content = include_template('search.php', [
                'nav' => $nav,
                'categories' => $categories,
                'lots' => $lots,
                'title' => $title,
                'pagination' => $pagination
            ]);
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
        'title' => 'Результаты поиска',
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Результаты поиска',
        'isMainPage' => false
    ]);
}

print($layout_content);



