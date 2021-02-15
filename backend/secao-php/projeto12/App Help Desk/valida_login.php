<?php
    session_start();
    
    // Variável de autenticação
    $usuario_autenticado = false;
    $usuario_id = null;
    $usuario_perfil = null;

    $perfis = array(1 => 'ADM', 2=> 'USER');

    // Usuários do sistema
    $usuarios_app = array(
        array('id' => 1,'email' => 'adm@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
        array('id' => 2,'email' => 'user@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
        array('id' => 3,'email' => 'jose@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
        array('id' => 4,'email' => 'maria@teste.com.br', 'senha' => '1234', 'perfil_id' => 2)
    );

    foreach($usuarios_app as $user) {
        if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
            $usuario_autenticado = true;
            $usuario_id = $user['id'];
            $usuario_perfil = $user['perfil_id'];
        }
    }

    if($usuario_autenticado) {
        $_SESSION['autenticado'] = 'SIM';
        $_SESSION['id'] = $usuario_id;
        $_SESSION['perfil_id'] = $usuario_perfil;
        header('Location: home.php');
    }
    else {
        $_SESSION['autenticado'] = 'NÃO';
        header('Location: index.php?login=erro');
    }
?>