<?php 

include_once("config.php");
include_once("err_handler.php");
include_once("db_connect.php");
include_once("functions.php");

include_once("find_token.php");

if(!isset($_GET['type'])) {
    echo ajax_echo(
        "Ошибка!", // Заголовок ответа
        "Вы не указали GET параметр type", // Описание ответа
        true, // Наличие ошибка
        "ERROR", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}


////////// ВЫВОД ЗАПИСЕЙ
/// список товаров - №1
if(preg_match_all("/^(list_product)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `name`, `desc`, `price` FROM `products`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список продукции", // Заголовок ответа
        "Вывод списка продуктов", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

/// список пользователей - №2
else if(preg_match_all("/^(list_users)$/ui", $_GET['type'])){
    $query = "SELECT `id`, `login` FROM `users`";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список пользователей", // Заголовок ответа
        "Вывод списка пользователей", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

/// список номеров телефона пользователя по id - №3
else if(preg_match_all("/^(list_phones)$/ui", $_GET['type'])){
    if(!isset($_GET['user'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "SELECT * FROM `users_phones` WHERE `user_id` = '" . $_GET['user'] . "'";

    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список номеров телефона пользователя", // Заголовок ответа
        "Вывод списка номеров телефона пользователя", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

/// список комментариев пользователя по id - №4
else if(preg_match_all("/^(list_comments)$/ui", $_GET['type'])){
    if(!isset($_GET['user'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    //$query = "SELECT `product_id`, `user_id`, `comment` FROM `comments`"; //все комментарии
    $query = "SELECT * FROM `comments` WHERE `user_id` = '" . $_GET['user'] . "'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список комментариев", // Заголовок ответа
        "Вывод списка комментариев", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

/// список желаемого(favourite) пользователя по id - №5
else if(preg_match_all("/^(list_favourite)$/ui", $_GET['type'])){
    if(!isset($_GET['user'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    //$query = "SELECT `product_id`, `user_id`, `comment` FROM `comments`";
    $query = "SELECT * FROM `favourite_products` WHERE `user_id` = '" . $_GET['user'] . "'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Список желаемого", // Заголовок ответа
        "Вывод списка желаемого пользователя", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}


/// содержимое заказа по id - №6
else if(preg_match_all("/^(order)$/ui", $_GET['type'])){
    //$query = "SELECT `product_id`, `user_id`, `comment` FROM `comments`";
    $query = "SELECT * FROM `order_products` WHERE `order_id` = '" . $_GET['order_id'] . "'";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    $arr_list = array();
    $rows = mysqli_num_rows($res_query);

    for ($i=0; $i < $rows; $i++) { 
        $row = mysqli_fetch_assoc($res_query);
        array_push($arr_list, $row);
    }

    
    echo ajax_echo(
        "Содержимое заказа", // Заголовок ответа
        "Вывод содержимого заказа", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        $arr_list // Дополнительные данные для ответа
    );

    exit();
}

////////// ДОБАВЛЕНИЕ
/// добавление товара - №1
else if(preg_match_all("/^(add_product)$/ui", $_GET['type'])){
    if(!isset($_GET['name'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр name", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['desc'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр desc", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['price'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр price", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "INSERT INTO `products`(`name`, `desc`, `price`) VALUES ('" . $_GET['name'] . "', '". $_GET['desc'] ."', '". $_GET['price'] ."')";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Новый товар был добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

/// добавление пользователя - №2
else if(preg_match_all("/^(add_user)$/ui", $_GET['type'])){
    if(!isset($_GET['login'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр login", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['password'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр password", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['email'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр email", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "INSERT INTO `users`(`login`, `password`, `email`) VALUES ('" . $_GET['login'] . "', '". $_GET['password'] ."', '". $_GET['email'] ."')";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Новый пользователь был добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

/// добавление номера телефона пользователя - №3
else if(preg_match_all("/^(add_phone)$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['phone'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр phone", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $query = "INSERT INTO `users_phones`(`user_id`, `phone`) VALUES ('" . $_GET['user_id'] . "', '". $_GET['phone'] ."')";
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Новый номер телефона был добавлен в базу данных", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

////////// РЕДАКТИРОВАНИЕ
/// редактирование цены товара по id - №1
else if(preg_match_all("/^(update_price)$/ui", $_GET['type'])){
    if(!isset($_GET['product_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр product_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['price'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр price", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $price = $_GET['price'];
    $query = "UPDATE `products` SET `price` = $price WHERE `id` = '" . $_GET['product_id'] . "'";
    
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Цена товара была обновлена", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

/// редактирование пароля пользователя по id - №2
else if(preg_match_all("/^(update_password)$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['password'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр password", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $password = $_GET['password'];
    $query = "UPDATE `users` SET `password` = $password WHERE `id` = '" . $_GET['user_id'] . "'";
    
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Пароль пользователя был обновлен", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

/// редактирование логина пользователя по id - №3
else if(preg_match_all("/^(update_login)$/ui", $_GET['type'])){
    if(!isset($_GET['user_id'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр user_id", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    if(!isset($_GET['login'])) {
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Вы не указали GET параметр login", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }
    $login = $_GET['login'];
    $query = "UPDATE `users` SET `login` = $login WHERE `id` = '" . $_GET['user_id'] . "'";
    
    $res_query = mysqli_query($connection, $query);

    if(!$res_query){
        echo ajax_echo(
            "Ошибка!", // Заголовок ответа
            "Ошибка в запросе.", // Описание ответа
            true, // Наличие ошибка
            "ERROR", // Результат ответа
            null // Дополнительные данные для ответа
        );
        exit();
    }

    echo ajax_echo(
        "Успех", // Заголовок ответа
        "Логин пользователя был обновлен", // Описание ответа
        false, // Наличие ошибка
        "SUCCESS", // Результат ответа
        null // Дополнительные данные для ответа
    );
    exit();
}

