<?php 
    //importando a biblioteca do PHPMailer
    require "./bibliotecas/PHPMAiler/Exception.php";
    require "./bibliotecas/PHPMAiler/OAuth.php";
    require "./bibliotecas/PHPMAiler/PHPMailer.php";
    require "./bibliotecas/PHPMAiler/POP3.php";
    require "./bibliotecas/PHPMAiler/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    //Classe responsável por receber os dados do formulário e enviar o e-mail
    class Mensagem {
        private $destino = null; //E-mail para o qual deseja enviar a mensagem
        private $assunto = null; //Assunto do e-mail 
        private $mensagem = null; //Mensagem do e-mail
        public $status = array( 'codigo_status' => null, 'descricao_status' => ''); //Array responsável por controlar se o e-mail foi enviado ou não, e dependendo do resultado, exibe uma mensagem diferente na tela

        function __construct($destino, $assunto, $mensagem) { //Função construtora da classe
            $this->destino = $destino;
            $this->assunto = $assunto;
            $this->mensagem = $mensagem;
        }

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->atributo = $valor;
        }

        public function enviarEmail() { //Função responsável por verificar se os dados do formulário foram preenchidos, e enviar o e-mail por meio do PHPMailer
            if(empty($this->destino) || empty($this->assunto) || empty($this->mensagem)){ //Verifica se todos os campos do formulário foram preenchidos, caso não tenham sido preenchidos, retorna para a página inicial com um erro
                header('Location: index.php?submit=erro');
            }

            $mail = new PHPMailer(true); //Cria o objeto responsável por administrar as informações necessárias para envio do e-mail

            try {
                //Server settings
                $mail->SMTPDebug = false;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP
                $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                $mail->Username   = 'example@example.com';                     // SMTP username
                $mail->Password   = '1111111';                               // SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

                //Recipients
                $mail->setFrom('ssceeph@gmail.com', 'Pedro Farolfi');
                $mail->addAddress($this->__get('destino'));     // Add a recipient
                //$mail->addAddress('ellen@example.com');               // Name is optional
                //$mail->addReplyTo('info@example.com', 'Information');
                //$mail->addCC('cc@example.com');
                //$mail->addBCC('bcc@example.com');

                // Attachments
                //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
                //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = $this->__get('assunto');
                $mail->Body    = $this->__get('mensagem');
                //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send(); //Envia o e-mail
                $this->status['codigo_status'] = 1; //Status da mensagem é alterado para 1, que vai servir para mostrar uma mensagem de sucesso na página
	            $this->status['descricao_status'] = 'E-mail enviado com sucesso';
            } catch (Exception $e) {
                $this->status['codigo_status'] = 2; //Status da mensagem é alterado para 2, que vai servir para mostrar uma mensagem de erro na página
	            $this->status['descricao_status'] = 'Não foi possível enviar este e-mail! Por favor tente novamente mais tarde. Detalhes do erro: ' . $mail->ErrorInfo; //Mostra o motivo do erro no envio do e-mail
            }
        }
    }

    $mensagem = new Mensagem($_POST['destino'], $_POST['assunto'], $_POST['mensagem']); //Cria o objeto da mensagem com os dados de formulário recebidos da página principal
    $mensagem->enviarEmail(); //Chama a função para enviar o e-mail com os dados resgatados acima
?>

<html> <!-- Página que mostra se o e-mail foi enviado ou não -->
	<head>
		<meta charset="utf-8" />
    	<title>App Mail Send</title>

    	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	</head>

	<body>
		<div class="container">
			<div class="py-3 text-center">
				<img class="d-block mx-auto mb-2" src="img/logo.png" alt="" width="72" height="72">
				<h2>Send Mail</h2>
				<p class="lead">Seu app de envio de e-mails particular!</p>
			</div>

			<div class="row">
				<div class="col-md-12">

					<?php if($mensagem->status['codigo_status'] == 1) { ?> <!-- Se o e-mail foi enviado, exibe a mensagem abaixo-->

						<div class="container text-center">
							<h1 class="display-4 text-success">Sucesso</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>

					<?php } ?>

					<?php if($mensagem->status['codigo_status'] == 2) { ?> <!-- Se o e-mail não foi enviado, exibe a mensagem abaixo-->

						<div class="container text-center">
							<h1 class="display-4 text-danger">Ocorreu um erro</h1>
							<p><?= $mensagem->status['descricao_status'] ?></p>
							<a href="index.php" class="btn btn-success btn-lg mt-5 text-white">Voltar</a>
						</div>

					<?php } ?>

				</div>
			</div>
		</div>
	</body>
</html>