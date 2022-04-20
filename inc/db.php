<?php

try {

    $db = new PDO('mysql:host=localhost;dbname=php_final;charset=UTF8', 'root', '');

} catch ( Exception $exception ) {

    die('Prolbme avec la base de donnee : ' . $exception->getMessage());

}