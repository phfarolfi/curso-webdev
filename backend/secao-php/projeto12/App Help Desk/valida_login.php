<?php
    session_start(); //essencial para manipular a superglobal $_SESSION
    
    // Variável de autenticação
    $usuario_autenticado = false;
    $usuario_id = null;
    $usuario_perfil = null;

    $perfis = array(1 => 'ADM', 2=> 'USER'); //array que representa quando o login na aplicação é de um usuário ou administrador

    // Usuários do sistema - MÉTODO NÃO RECOMENDADO! EXIBE DADOS SIGILOSOS DENTRO DO DIRETÓRIO PÚBLICO DA APLICAÇÃO, ASSIM COMO O ARQUIVO.TXT QUE ARMAZENA OS CHAMADOS. É RECOMENDÁVEL COLOCAR SCRIPTS QUE EXIBEM DADOS FORA DO DIRETÓRIO PÚBLICO DA APLICAÇÃO E REQUISITÁ-LOS POR REQUIRE/INCLUDE OU AJUSTANDO A HIERARQUIA DO DIRETÓRIO NAS ABERTURAS DE ARQUIVO DENTRO DOS SCRIPTS.
    $usuarios_app = array(
        array('id' => 1,'email' => 'adm@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
        array('id' => 2,'email' => 'user@teste.com.br', 'senha' => '1234', 'perfil_id' => 1),
        array('id' => 3,'email' => 'jose@teste.com.br', 'senha' => '1234', 'perfil_id' => 2),
        array('id' => 4,'email' => 'maria@teste.com.br', 'senha' => '1234', 'perfil_id' => 2)
    );

    foreach($usuarios_app as $user) { //verifica todos os usuários para ver se quem estar tentando fazer login na aplicação possui cadastro
        if($user['email'] == $_POST['email'] && $user['senha'] == $_POST['senha']) {
            $usuario_autenticado = true; //usuário cadastrado
            $usuario_id = $user['id']; //id do usuário, utilizado para saber quais chamados serão exibidos na consulta de chamado
            $usuario_perfil = $user['perfil_id']; //id do perfil, para identificar um usuário ou administrador
        }
    }

    if($usuario_autenticado) { //se o usuário é autenticado, o script continua para home.php, com os dados de id do usuário sendo compartilhados entre os scripts por meio da superglobal $_SESSION
        $_SESSION['autenticado'] = 'SIM';
        $_SESSION['id'] = $usuario_id;
        $_SESSION['perfil_id'] = $usuario_perfil;
        header('Location: home.php');
    }
    else { //se o usuário não foi autenticado, retorna para index.php com mensagem de erro
        $_SESSION['autenticado'] = 'NÃO';
        header('Location: index.php?login=erro');
    }
?>