<?php require_once "validador_acesso.php" ?>

<?php 
  //Esse algoritmo abre o arquivo onde estão armazenados os chamados e armazena todos os chamados em um vetor de chamados
  $arquivo = fopen('arquivo.txt', 'r');

  $chamados = array();
  //Enquanto houverem chamados no arquivo, o looping ira se repetir
  while(!feof($arquivo)) {
    $chamados[] = fgets($arquivo);
  }

  //fecha o arquivo
  fclose($arquivo);
?>

<html>
  <head>
    <meta charset="utf-8" />
    <title>App Help Desk</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <style>
      .card-consultar-chamado {
        padding: 30px 0 0 0;
        width: 100%;
        margin: 0 auto;
      }
    </style>
  </head>

  <body>
    <?php include_once "navbar.php" ?>

    <div class="container">    
      <div class="row">

        <div class="card-consultar-chamado">
          <div class="card">
            <div class="card-header">
              Consulta de chamado
            </div>
            
            <div class="card-body">

              <?php foreach($chamados as $chamado) { ?> <!-- Percorre todos os chamados -->

                <?php
                  $chamado_dados = explode('#', $chamado); //Reorganiza os dados em 3 posições diferentes no vetor $chamado_dados, retirando o caractere "#"
                  
                  if($_SESSION['perfil_id'] == 2) { // Esse bloco verifica se o login atual é um usuário(2) ou administrador(1)

                    if($_SESSION['id'] != $chamado_dados[0]) { // Se for usuário, mas não for o usuário (verificado pelo ID) que abriu o chamado atual do vetor $chamado_dados, o chamado não é mostrado
                      continue;
                    }

                  } //Se for um administrador, todos os chamados são mostrados
                  
                  if(count($chamado_dados) < 3) { //Verifica se há qualquer informação faltando nos chamados, se tiver, não aparece na consulta.
                    continue; 
                  } 
                  
                ?>
              
                <div class="card mb-3 bg-light">
                  <div class="card-body">
                    <h5 class="card-title"><?= $chamado_dados[1] ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $chamado_dados[2] ?></h6>
                    <p class="card-text"><?= $chamado_dados[3] ?></p>

                  </div>
                </div>

              <?php } ?>

              <div class="row mt-5">
                <div class="col-6">
                  <a class="btn btn-lg btn-warning btn-block" href="home.php">Voltar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
