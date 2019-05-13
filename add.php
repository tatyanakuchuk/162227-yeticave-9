<?php

require_once('functions.php');
require_once ('data.php');

//подключение к MySQL
$connect = mysqli_connect("localhost", "root", "", "yeticave");
mysqli_set_charset($connect, "utf8");

//проверка подключения
if($connect == false) {
    $error = mysqli_connect_error();
    print('Ошибка подключения: ' . mysqli_connect_error());
} else {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST;
//        print_r($lot);

        $required = ['lot-name', 'message', 'category', 'file', 'lot-rate', 'lot-step', 'lot-date'];
        $dict = ['lot-name' => 'Наименование', 'message' => 'Описание', 'category' => 'Категория',
                'file' => 'Изображение', 'lot-rate' => 'Начальная цена', 'lot-step' => 'Шаг ставки',
                'lot-date' => 'Дата окончания торгов'];

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
                if (count($errors)) {
                    $errors[$key] = 'Пожалуйста, исправьте ошибки в форме.';
                }
            }
        }

        if (isset($_FILES['lot_img']['name'])) {
            $tmp_name = $_FILES['lot_img']['tmp_name'];
            $path = $_FILES['lot_img']['name'];

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_type = finfo_file($finfo, $tmp_name);
            if ($file_type !== 'image/png' || $file_type !== 'image/jpeg') {
                $errors['file'] = 'Загрузите картинку в форматах jpg, jpeg или png';
            } else {
                move_uploaded_file($tmp_name, 'uploads/' . $path);
                $lot['path'] = $path;
            }
        } else {
            $errors['file'] = 'Вы не загрузили файл';
        }
        if (count($errors)) {
            $content = include_template('add.php', ['lot' => $lot, 'errors' => $errors, 'dict' => $dict]);
        } else {
            $content = include_template('view.php', ['lot' => $lot]);
        }
    } else {
        $content = include_template('add.php', []);
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

$content = include_template('add.php', [
    'nav' => $nav,
    'categories' => $categories
]);

$layout_content = include_template('layout.php', [
    'nav' => $nav,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'content' => $content,
    'categories' => $categories,
    'title' => 'Добавление лота',
    'isMainPage' => false
]);

print($layout_content);



