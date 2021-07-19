<?php 
    session_start();
    // A lógica deste algoritmo se baseia em recuperar as informações do formulário de cadastramento de chamado, armazenar as informações em sua variável específica, substituindo qualquer ocorrência do caractere "#" por "-", pois "#" será o caractere que separa cada uma das informações quando forem concatenadas e armazenadas na variável "$texto". Após isso, abre o arquivo, armazena o conteúdo de "$texto" dentro dele, e fecha o arquivo.

    $titulo = str_replace('#', '-', $_POST['titulo']);
    $categoria = str_replace('#', '-', $_POST['categoria']);
    $descricao = str_replace('#', '-', $_POST['descricao']);

    $texto = $_SESSION['id'] . '#' . $titulo . '#' . $categoria . '#' . $descricao . PHP_EOL; // PHP_EOL adiciona uma quebra de linha no arquivo

    //abre o arquivo
    $arquivo = fopen('arquivo.txt', 'a');

    //armazena o conteúdo de texto no arquivo
    fwrite($arquivo, $texto);

    //fecha o arquivo
    fclose($arquivo);

    //volta para a página de abrir chamado
    header('Location: abrir_chamado.php');
?>