<?php
require_once("core/helpers.php");
require_once("core/init.php");
$page_title = "Магазин етикаве";
/**
 * @var PDO $con
 * @var Array $categories
 *
 */

$lotsObject = $con->query('SELECT p.id, p.title, p.price, p.img_url, p.date_end, c.title as category FROM lots p JOIN categories c ON p.category_id = c.id WHERE p.date_end > NOW() ORDER BY p.date_create DESC LIMIT 10');
$open_lots = $lotsObject->fetchAll();

$mainContent = include_template("main.php", [
            'is_auth' => $is_auth,
            "categories" => $categories,
            "open_lots" => $open_lots,
        ]);

$page = include_template("layout.php", [
            'is_auth' => $is_auth,
            "categories" => $categories,
            "content" => $mainContent,
            "page_title" => $page_title,
            "user_name" => $user_name


        ]);

print($page);





