<?php

require '../vendor/autoload.php';

/**
 * Redirige vers l'erreur 404
 */
function e404 () {
    require '../public/404.php';
    exit();
}

/**
 * Fonction de débug
 * @param mixed ...$vars
 */
function dd(...$vars)
{
    foreach ($vars as $var)
    {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    }
}

/**
 * Connexion à la BDD
 * @return PDO
 */
function get_pdo(): \PDO{
    return $pdo = new \PDO('mysql:host=localhost;port=3306;dbname=tutocalendar','root', 'root',
            [
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
            ]);
}

/**
 * Permet d'échapper les caractères avec htmlentites
 * @param null|string $value
 * @return string
 */
function h(?string $value): string{
    if($value === null){
      return '';
    }
    return htmlentities($value);
}

function render(string $view, $parameters = []){
    extract($parameters);
    include "../views/{$view}.php";
}

