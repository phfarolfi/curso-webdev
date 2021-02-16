<?php
    session_start();

    if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] != 'SIM') { //verifica se tentaram fazer login no sistema antes de acessar páginas restritas
        header('Location: index.php?login=erro2');
    }
?>