<?php

interface Loader {
    
}

function __autoload($classe) {
    $pastas = array(
        __DIR__ . '/dao/' . $classe . '.class.php',
        __DIR__ . '/util/' . $classe . '.class.php',
        __DIR__ . '/modelo/' . $classe . '.class.php',
        __DIR__ . '/controle/' . $classe . '.class.php',
        __DIR__ . '/' . $classe . '.class.php',
        $classe . '.class.php',
    );
    foreach ($pastas as $arquivo) {
        if (file_exists($arquivo)) {
            require_once($arquivo);
            break;
        }
    }

    $classes =
            array(
                'beta/util/' . $classe . '.php',
    );

    foreach ($classes as $class) {
        if (file_exists($class)) {
            require_once $class;
            break;
        }
    }
}

?>