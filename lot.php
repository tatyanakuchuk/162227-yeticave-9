<?php
session_start();
require_once('functions.php');
require_once ('data.php');
$isLotOfCurrentUser = false;

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
        print($error);
    }

    if (isset($_GET['id'])) {
        $lot_id = $_GET['id'];

        $sql_lot = 'SELECT l.id, l.user_id, title, description, img_path, sum_start, bet_step, c.name, dt_remove FROM lots l ' .
            'JOIN categories c ON l.category_id = c.id ' .
            'WHERE l.id = ' . $lot_id;
        $res_lot = mysqli_query($connect, $sql_lot);
        if ($res_lot) {
            $lot = mysqli_fetch_all($res_lot, MYSQLI_ASSOC);
            if (empty($lot)) {
                header('Location: /error.php');
                http_response_code(404);
                $content = include_template('error.php', [
                    'categories' => $categories,
                    'nav' => $nav
                ]);
            } else {
                $add_bet = include_template('add-bet.php', [
                    'lot' => $lot[0],
                    'lot_id' => $lot_id
                ]);
                $content = include_template('lot.php', [
                    'categories' => $categories,
                    'nav' => $nav,
                    'add_bet' => $add_bet,
                    'lot' => $lot[0]
                ]);
            }
        } else {
            $error = mysqli_error($connect);
            print($error);
        }
    }

    //добавление ставки
    if (isset($_SESSION['user'])) {
        $user_id = $_SESSION['user']['id'];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $bet = $_POST;

            $lot_id = $bet['lot-id'];
            $sql_lot = 'SELECT l.id, l.user_id, title, description, img_path, sum_start, bet_step, c.name, dt_remove FROM lots l ' .
                'JOIN categories c ON l.category_id = c.id ' .
                'WHERE l.id = ' . $lot_id;
            $res_lot = mysqli_query($connect, $sql_lot);
            if ($res_lot) {
                $lot = mysqli_fetch_all($res_lot, MYSQLI_ASSOC);
            } else {
                $error = mysqli_error($connect);
                print($error);
            }

            $required = [
                'cost'
            ];
            $errors = [];

            foreach ($required as $key) {
                if (empty($bet[$key])) {
                    if ($key == 'cost') {
                        $errors[$key] = 'Введите сумму ставки';
                    }
                }
            }

            if (!empty($bet['cost'])) {
                if (!ctype_digit($bet['cost'])) {
                    $errors['cost'] = 'Ставка должна быть целым числом';
                }
                elseif ($bet['cost'] < $lot[0]['sum_start'] + $lot[0]['bet_step']) {
                    $errors['cost'] = 'Сумма должно быть больше минимальной ставки';
                }
            }

            if (count($errors)) {
                $add_bet = include_template('add-bet.php', [
                    'lot' => $lot[0],
                    'lot_id' => $lot_id,
                    'errors' => $errors,
                    'bet' => $bet
                ]);
                $content = include_template('lot.php', [
                    'categories' => $categories,
                    'nav' => $nav,
                    'add_bet' => $add_bet,
                    'lot' => $lot[0]
                ]);
            } else {
                $sql = 'INSERT INTO bets (dt_add, lot_id, user_id, sum) VALUES (NOW(), ?, ?, ?)';
                $stmt = db_get_prepare_stmt($connect, $sql, [$lot_id, $user_id, $_POST['cost']]);
                $res = mysqli_stmt_execute($stmt);
                if ($res) {
                    $content = include_template('lot.php', [
                        'categories' => $categories,
                        'nav' => $nav,
                        'lot' => $lot[0],
                        'lot_id' => $lot_id
                    ]);
                } else {
                    $error = mysqli_error($connect);
                    print($error);
                }
            }
        }

    }//end добавление ставки

    //список ставок лота
    $sql_bets = 'SELECT b.id, b.lot_id, b.dt_add, b.user_id, sum, u.name  FROM bets b JOIN users u ON b.user_id = u.id WHERE b.lot_id = ' .
        $lot_id . ' ORDER BY b.dt_add DESC LIMIT 10' ;
    $res_bets = mysqli_query($connect, $sql_bets);
    if ($res_bets) {
        $bets = mysqli_fetch_all($res_bets, MYSQLI_ASSOC);

        if (!empty($bets)) {
            $bet_user_id = $bets[0]['user_id'];
        } else {
            $bet_user_id = null;
        }

        $lot_user_id = $lot[0]['user_id'];
        if (isset($user_id)) {
            if ($bet_user_id == $user_id || $lot_user_id == $user_id) {
                $content = include_template('lot.php', [
                    'categories' => $categories,
                    'nav' => $nav,
                    'lot' => $lot[0],
                    'lot_id' => $lot_id,
                    'bets' => $bets
                ]);
            }
            else {
                $content = include_template('lot.php', [
                    'categories' => $categories,
                    'nav' => $nav,
                    'lot' => $lot[0],
                    'lot_id' => $lot_id,
                    'add_bet' => $add_bet,
                    'bets' => $bets
                ]);
            }
        }
        else {
            $content = include_template('lot.php', [
                'categories' => $categories,
                'nav' => $nav,
                'lot' => $lot[0],
                'lot_id' => $lot_id,
                'bets' => $bets
            ]);
        }

    } else {
        $error = mysqli_error($connect);
        print($error);
    }//end список ставок лота
}

if (isset($_SESSION['user'])) {
    $username = $_SESSION['user']['name'];
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'username' =>  $username,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Лот',
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Лот',
        'isMainPage' => false
    ]);
}

print($layout_content);


