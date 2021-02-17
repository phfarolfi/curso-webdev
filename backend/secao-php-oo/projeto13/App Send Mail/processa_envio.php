<?php 
    require "./bibliotecas/PHPMAiler/Exception.php";
    require "./bibliotecas/PHPMAiler/OAuth.php";
    require "./bibliotecas/PHPMAiler/PHPMailer.php";
    require "./bibliotecas/PHPMAiler/POP3.php";
    require "./bibliotecas/PHPMAiler/SMTP.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    class Mensagem {
        private $destino = null;
        private $assunto = null;
        private $mensagem = null;

        function __construct($destino, $assunto, $mensagem) {
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

        public function mensagemValida() {
            if(empty($this->destino) || empty($this->assunto) || empty($this->mensagem)){
                return false;
            }

            return true;
        }
    }

    $mensagem = new Mensagem($_POST['destino'],$_POST['assunto'],$_POST['mensagem']);

    if(!$mensagem->mensagemValida()){
        echo 'Mensagem inválida.';
        die();
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.example.com';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'user@example.com';                     // SMTP username
        $mail->Password   = 'secret';                               // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
        $mail->setFrom('from@example.com', 'Mailer');
        $mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
        $mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        echo 'A mensagem foi enviada';
    } catch (Exception $e) {
        echo "A mensagem não pode ser enviada. Erro: {$mail->ErrorInfo}";
    }
?>