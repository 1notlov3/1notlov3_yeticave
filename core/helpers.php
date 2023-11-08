<?php
/**
 * Проверяет переданную дату на соответствие формату 'ГГГГ-ММ-ДД'
 *
 * Примеры использования:
 * is_date_valid('2019-01-01'); // true
 * is_date_valid('2016-02-29'); // true
 * is_date_valid('2019-04-31'); // false
 * is_date_valid('10.10.2010'); // false
 * is_date_valid('10/10/2010'); // false
 *
 * @param string $date Дата в виде строки
 *
 * @return bool true при совпадении с форматом 'ГГГГ-ММ-ДД', иначе false
 */
function is_date_valid(string $date) : bool {
    $format_to_check = 'Y-m-d';
    $dateTimeObj = date_create_from_format($format_to_check, $date);

    return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

/**
 * Возвращает корректную форму множественного числа
 * Ограничения: только для целых чисел
 *
 * Пример использования:
 * $remaining_minutes = 5;
 * echo "Я поставил таймер на {$remaining_minutes} " .
 *     get_noun_plural_form(
 *         $remaining_minutes,
 *         'минута',
 *         'минуты',
 *         'минут'
 *     );
 * Результат: "Я поставил таймер на 5 минут"
 *
 * @param int $number Число, по которому вычисляем форму множественного числа
 * @param string $one Форма единственного числа: яблоко, час, минута
 * @param string $two Форма множественного числа для 2, 3, 4: яблока, часа, минуты
 * @param string $many Форма множественного числа для остальных чисел
 *
 * @return string Рассчитанная форма множественнго числа
 */
function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
    $number = (int) $number;
    $mod10 = $number % 10;
    $mod100 = $number % 100;

    switch (true) {
        case ($mod100 >= 11 && $mod100 <= 20):
            return $many;

        case ($mod10 > 5):
            return $many;

        case ($mod10 === 1):
            return $one;

        case ($mod10 >= 2 && $mod10 <= 4):
            return $two;

        default:
            return $many;
    }
}

/**
 * Подключает шаблон, передает туда данные и возвращает итоговый HTML контент
 * @param string $name Путь к файлу шаблона относительно папки templates
 * @param array $data Ассоциативный массив с данными для шаблона
 * @return string Итоговый HTML
 */
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}
//validate//
/**
 * Валидация.
 *
 * @param mixed $value Значение, подлежащее валидации
 * @param callable $condition Условие валидации в виде анонимной функции
 *
 * @return string|null Сообщение об ошибке, если условия не выполнены
 */
function validateFilled ($name) {
    if (empty($_POST[$name])) {
        return "Это поле должно быть заполнено";
    }
}
function validatePrice($price) {
    if (empty(validateFilled($price)) && $_POST[$price] < 1) {
        return "Необходимо увеличить начальную цену";
    }
}

function validateEmail($name) {
    if (!filter_input(INPUT_POST, $name, FILTER_VALIDATE_EMAIL)) {
        return "Введите корректный email";
    }
}
function validateDateEnd($date) {
    if (is_date_valid($_POST[$date]) && empty(validateFilled($date))) {
        if (new DateTime($_POST[$date]) <= new DateTime('+1 day')) {
            return "Эта дата слишком мала";
        }
    } else {
        return "Введите корректный формат даты (ГГГГ-ММ-ДД)";
    }
}

function validateStep($bid_step) {
    if (is_numeric($_POST[$bid_step]) && empty(validateFilled($bid_step))) {
        if ($_POST[$bid_step] < 1) {
            return "Необходимо увеличить шаг ставки";
        }
    } else {
        return "Шаг ставки должен быть целым числом";
    }
}
function validateImage(){
    if(!empty($_FILES['photo']['name'])){
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmp_name=$_FILES['photo']['tmp_name'];
        $file_type=finfo_file($finfo, $tmp_name);
        if($file_type !=="image/jpeg" && $file_type !=="image/png" && $file_type !=="image/jpg"){
            return false;
        }
        return true;
    } else{
        return false;
    }
}

function validateCategory(int $id, array $allowed_list) {
    if (!in_array($id, $allowed_list)) {
        return "Указана несуществующая категория";
    }
}

//others//

/**
 * Форматирование цены. Если цена менее 1000, возвращает округленное значение с символом валюты, иначе возвращает форматированное значение с пробелами.
 *
 * @param int $price Значение цены
 *
 * @return string Отформатированная цена
 */
function formatPrice($price) {
    if ($price < 1000) {
        return ceil($price) . ' ₽';
    } else {
        $formattedPrice = number_format($price, 0, '', ' ');
        return $formattedPrice . ' ₽';
    }
}

/**
 * Получение массива с оставшимся временем до указанной даты окончания.
 *
 * @param string $date_end_str Значение даты окончания
 *
 * @return array Массив с оставшимся временем [часы, минуты, секунды]
 */
function get_dt_range($date_end_str) {
    $now = time();
    $expiration = strtotime($date_end_str);
    $diff = $expiration - $now;
    if ($diff < 0) {
        return array(0, 0, 0);
    }
    $hours = floor($diff / 3600);
    $minutes = floor(($diff % 3600) / 60);
    $seconds = $diff % 60;
    return array($hours, $minutes, $seconds);
}

/**
 * Получение значения из массива POST по указанному имени.
 *
 * @param string $name Имя переменной в массиве POST
 *
 * @return mixed Значение из POST или пустая строка, если значение не существует
 */
function getPostVal($name) {
    return $_POST[$name] ?? "";
}

