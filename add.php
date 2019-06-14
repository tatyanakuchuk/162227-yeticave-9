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
    $sql = 'SELECT id, name FROM categories';
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST;
        $required = [
            'lot-name',
            'message',
            'category',
            'file',
            'lot-rate',
            'lot-step',
            'lot-date'
        ];

        $errors = [];
        foreach ($required as $key) {
            if (empty($_POST[$key])) {
                if ($key == 'lot-name') {
                    $errors[$key] = 'Введите наименование лота';
                }
                if ($key == 'category') {
                    $errors[$key] = 'Выберите категорию';
                }
                if ($key == 'message') {
                    $errors[$key] = 'Напишите описание лота';
                }
                if ($key == 'lot-rate') {
                    $errors[$key] = 'Введите начальную цену';
                }
                if ($key == 'lot-step') {
                    $errors[$key] = 'Введите шаг ставки';
                }
                if ($key == 'lot-date') {
                    $errors[$key] = 'Введите дату завершения торгов';
                }
            }
        }

        $lot_rate = $lot['lot-rate'];
        $lot_step = $lot['lot-step'];
        if (!empty($lot_rate)) {
            if (!is_numeric($lot_rate)) {
                $errors['lot-rate'] = 'Введите число';
            }
            if ($lot_rate != round($lot_rate)) {
                $errors['lot-rate'] = 'Введите целое число';
            }
        }
        if (!empty($lot_step)) {
            if (!is_numeric($lot_step)) {
                $errors['lot-step'] = 'Введите число';
            }
            if ($lot_step != round($lot_step)) {
                $errors['lot_step'] = 'Введите целое число';
            }
        }

        if (!empty($lot['lot-date']) && strtotime($lot['lot-date']) <= strtotime('now') ) {
            $errors[$key] = 'Введите корректную дату';
        }

        if (isset($_FILES['file']['name'])) {
            if (empty($_FILES['file']['name'])) {
                $errors['file'] = 'Вы не загрузили файл';
            } else {
                $tmp_name = $_FILES['file']['tmp_name'];
                $file = $_FILES['file']['name'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);

                // Получаем расширение загруженного файла
                $extension = strtolower(substr(strrchr($file, '.'), 1));
                //Генерируем новое имя файла
                $file = uniqid() . '.' .  $extension;
                //Папка назначения
                $dest = 'uploads/';
                if ($file_type == 'image/png' OR $file_type == 'image/jpeg') {
                    move_uploaded_file($tmp_name, $dest . $file);
                    $lot['file'] = $dest . $file;
                    $content = include_template('add.php', [
                        'categories' => $categories,
                        'nav' => $nav
                    ]);
                } else {
                    $errors['file'] = 'Загрузите файл в формате jpeg или png';
                }
            }
        }

        if (count($errors)) {
            $content = include_template('add.php', [
                'lot' => $lot,
                'nav' => $nav,
                'categories' => $categories,
                'errors' => $errors
            ]);
        } else {
            if (isset($_SESSION['user'])) {
                $user_id = $_SESSION['user']['id'];
                $sql = 'INSERT INTO lots (dt_add, dt_remove, category_id, user_id, title, description, img_path, sum_start, bet_step)' .
                    ' VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';
                $stmt = db_get_prepare_stmt($connect, $sql, [$lot['lot-date'], $lot['category'], $user_id,
                    $lot['lot-name'], $lot['message'], $lot['file'], $lot['lot-rate'],
                    $lot['lot-step']]);
                $res = mysqli_stmt_execute($stmt);
                if ($res) {
                    $lot_id = mysqli_insert_id($connect);
                    header('Location: /lot.php?id=' . $lot_id);
                }
            }
        }
    } else {
        if (!isset($_SESSION['user'])) {
            header("Location: /");
            http_response_code(403);
            exit();
        } else {
            $content = include_template('add.php', [
                'categories' => $categories,
                'nav' => $nav
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
        'title' => 'Добавление лота',
        'isMainPage' => false
    ]);
} else {
    $layout_content = include_template('layout.php', [
        'nav' => $nav,
        'content' => $content,
        'categories' => $categories,
        'title' => 'Добавление лота',
        'isMainPage' => false
    ]);
}

print($layout_content);



