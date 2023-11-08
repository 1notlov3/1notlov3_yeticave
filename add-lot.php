<?php
require_once('core/helpers.php');
require_once('core/init.php');

if(!$is_auth){
    header("HTTP/1.1 403 Forbidden");
    echo "403 Forbidden: Access is denied.";

    exit;
}

/**
 * @var PDO $con
 */

$page_title = "Добавление лота";


$required_fields = ['title', 'category_id', 'description', 'photo', 'price', 'step', 'date_end'];
$errors = [];


$cats_ids = array_column($categories, 'id');
$post = $_POST;


$rules = [
    'category_id' => function($value) use ($cats_ids) {
        return validateCategory($value, $cats_ids);
    },
    'title' => function() {
        return validateFilled('title');
    },
    'description' => function() {
        return validateFilled('description');
    },
    'date_end' => function() {
        return validateDateEnd('date_end');
    },
    'step' => function() {
        return validateStep('step');
    },
    'price' => function() {
        return validatePrice('price');
    }
];


$file_rule = function () {
    return validateImage() ? null : "Загрузите картинку в формате jpg, jpeg или png";
};


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($post as $key => $value) {
        $rule = $rules[$key] ?? null;
        $errors[$key] = $rule ? $rule($value) : null;
    }
    $errors['photo'] = $file_rule();

    $errors = array_filter($errors);
//    var_dump($errors);
//    die;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)){
    $file_name = $_FILES['photo']['name'];
    $uniq_url = uniqid();
    $post['img_url'] = 'uploads/' . $uniq_url . $file_name;
    $post['user_id'] = 1;
    move_uploaded_file($_FILES['photo']['tmp_name'], $post['img_url']);

    $stmt = $con->prepare('INSERT INTO lots SET title=:title, author_id=:user_id, category_id=:category_id,
 description=:description, img_url=:img_url, price=:price, step=:step, date_end=:date_end,
 date_create=NOW()');

    $stmt->execute($post);
    header("Location: lot.php?id=" . $con->lastInsertId());
}

$content = include_template('add-lot-template.php', [
    'categories' => $categories,
    'user_name' => $user_name,
    'errors' => $errors,
]);

$page = include_template('layout.php', [
    'content' => $content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'errors' => $errors,
    'categories' => $categories,
    'page_title' => $page_title
]);

print($page);
