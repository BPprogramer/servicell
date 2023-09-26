<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}


function pagina_actual($path):bool{
    return str_contains($_SERVER['PATH_INFO'], $path)? true :false;
}

function is_cliente():bool{
   
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    } 
   

    return isset($_SESSION['cliente']) && !empty($_SESSION['cliente']);
}

function is_vendedor(): bool{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    } 
    return isset($_SESSION['vendedor']) && !empty($_SESSION) ;

}

function is_admin():bool{
    if (session_status() != PHP_SESSION_ACTIVE) {
        session_start();
    } 
    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

