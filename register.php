<?php

require_once ('core/helpers.php');
require_once ('core/init.php');
/**
 * @var PDO $con
 * @var Array $categories
 *
 */
$page_title = "Добавление лота";
$errors = [];
$user = $_POST;
$rules = [
    'name' => function() {
        return validateFilled('name');
    },
    'email' => function() {
        return validateEmail('email');
    },
    'password' => function() {
        return validateFilled('password');
    },
    'message' => function() {
        return validateFilled('message');
    }
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($user as $key => $value) {
        if (isset($rules[$key])) {
            $rule = $rules[$key];
            $errors[$key] = $rule();
        }
    }
}

$errors = array_filter($errors);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($errors)) {

    $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);

    //выполняется запрос на получение пользователя с указанным email
    $stmt = $con->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute(['email' => $user['email']]);


    if ($stmt->rowCount() != 0) {
        $errors['email'] = 'Пользователь с этим email уже зарегестрирован';
    } else {
        $stmt = $con->prepare('INSERT INTO users SET name=:name, email=:email, password=:password, contacts=:message');
        $stmt->execute($user);
        header('Location: login.php');
    }
}


$registerContent= include_template('register-template.php', [
    'errors' => $errors
]);

$page = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    "page_title" => $page_title,
    'content' => $registerContent
]);

print($page);

