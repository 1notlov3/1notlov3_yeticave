<?php

require_once('core/init.php');
require_once('core/helpers.php');
/**
 * @var PDO $con
 * @var Array $categories
 *
 */
$page_title = "Вход";
$errors = [];
$user = $_POST;
$rules = [
    'email' => function(){
        return validateEmail('email');
    },
    'password' => function() {
        return validateFilled('password');
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

    $stmt = $con->prepare('SELECT * FROM users WHERE email=:email');
    $stmt->execute(['email' => $user['email']]);

    if ($stmt->rowCount() == 0) {
        $errors['email'] = 'Пользователь с этим email не зарегестрирован';
    } else {
        $dbUser = $stmt->fetch();
        if (password_verify($user['password'], $dbUser['password'])) {
            $_SESSION['user_id'] = $dbUser['id'];
            $_SESSION['user_name'] = $dbUser['name'];
            header("Location: index.php");
        } else {
            $errors['password'] = "Неверный пароль";
        }
    }
}

$loginContent = include_template('login-template.php', [
    'errors' => $errors
]);

$page = include_template('layout.php', [
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'categories' => $categories,
    "page_title" => $page_title,
    'content' => $loginContent
]);

print($page);

