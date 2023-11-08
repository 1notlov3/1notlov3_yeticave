<?php
require_once ('core/helpers.php');
require_once ('core/init.php');
/**
 * @var PDO $con
 * @var Array $categories
 *
 */
$page_title = "Просмотр лота";
$lotId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$stmt = $con->prepare('SELECT p.id,p.title, p.price, p.img_url, p.date_end,p.description, c.title as category FROM lots p JOIN categories c ON p.category_id = c.id WHERE p.id=:id');
$stmt->execute(['id' => $lotId]);
$lot = $stmt->fetch();

if ($lot) {

    $content = include_template('lot-template.php', [
        'lot' => $lot,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
    ]);

    $page = include_template('layout.php', [
        'content' => $content,
        'is_auth' => $is_auth,
        'user_name' => $user_name,
        'categories' => $categories,
        "page_title" => $page_title
    ]);

    print($page);

}
else {
    header("Location: pages/404.html");
}