<?php

namespace Goteo\Library {

	use Goteo\Core\Model,
        Goteo\Core\Exception,
        Goteo\Core\View;

    class Mail {

        public
            $from = GOTEO_MAIL_FROM,
            $fromName = GOTEO_MAIL_NAME,
            $to = GOTEO_MAIL_FROM,
            $toName = GOTEO_MAIL_NAME,
            $subject,
            $content,
            $cc = false,
            $bcc = false,
            $reply = false,
            $replyName,
            $attachments = array(),
            $html = true;

        /**
         * Constructor.
         */
        function __construct() {
            require_once PHPMAILER_CLASS;
            require_once PHPMAILER_SMTP;
            require_once PHPMAILER_POP3;

            // Inicializa la instancia PHPMailer.
            $mail = new \PHPMailer();

            // Define  el idioma para los mensajes de error.
            $mail->SetLanguage("es", PHPMAILER_LANGS);

            // Define la codificación de caracteres del mensaje.
            $mail->CharSet = "UTF-8";

            // Define el ajuste de texto a un número determinado de caracteres en el cuerpo del mensaje.
            $mail->WordWrap = 50;

            // Define el tipo de gestor de correo
            switch(GOTEO_MAIL_TYPE) {
                default:
                case "mail":
                    $mail->isMail(); // set mailer to use PHP mail() function.
                    break;
                case "sendmail":
                    $mail->IsSendmail(); // set mailer to use $Sendmail program.
                    break;
                case "qmail":
                    $mail->IsQmail(); // set mailer to use qmail MTA.
                    break;
                case "smtp":
                    $mail->IsSMTP(); // set mailer to use SMTP
                    $mail->SMTPAuth = GOTEO_MAIL_SMTP_AUTH; // enable SMTP authentication
                    $mail->SMTPSecure = GOTEO_MAIL_SMTP_SECURE; // sets the prefix to the servier
                    $mail->Host = GOTEO_MAIL_SMTP_HOST; // specify main and backup server
                    $mail->Port = GOTEO_MAIL_SMTP_PORT; // set the SMTP port
                    $mail->Username = GOTEO_MAIL_SMTP_USERNAME;  // SMTP username
                    $mail->Password = GOTEO_MAIL_SMTP_PASSWORD; // SMTP password
                    break;
            }
            $this->mail = $mail;
        }

        /**
         * Validar mensaje.
         * @param type array	$errors
         */
		public function validate(&$errors = array()) {
		    if(empty($this->content)) {
		        $errors['content'] = 'El mensaje no tiene contenido.';
		    }
            if(empty($this->subject)) {
                $errors['subject'] = 'El mensaje no tiene asunto.';
            }
            return empty($errors);
		}

		/**
		 * Enviar mensaje.
		 * @param type array	$errors
		 */
        public function send(&$errors = array()) {
            if($this->validate($errors)) {
                $mail = $this->mail;
                try {
                    // Construye el mensaje
                    $mail->From = $this->from;
                    $mail->FromName = $this->fromName;
                    
                    $mail->AddAddress($this->to, $this->toName);
                    // para verificacioens
                    $mail->AddAddress('goteomailcheck@gmail.com', 'Verifier');
                    if($this->cc) {
                        $mail->AddCC($this->cc);
                    }
                    if($this->bcc) {
                        $mail->AddBCC($this->bcc);
                    }
                    if($this->reply) {
                        $mail->AddReplyTo($this->reply, $this->replyName);
                    }
                    if (!empty($this->attachments)) {
                        foreach ($this->attachments as $attachment) {
                            if (!empty($attachment['filename'])) {
                                $mail->AddAttachment($attachment['filename'], $attachment['name'], $attachment['encoding'], $attachment['type']);
                            } else {
                                $mail->AddStringAttachment($attachment['string'], $attachment['name'], $attachment['encoding'], $attachment['type']);
                            }
                        }
                    }
                    $mail->Subject = $this->subject;
                    if($this->html) {
                        $mail->IsHTML(true);
                        $mail->Body    = $this->bodyHTML();
                        $mail->AltBody = $this->bodyText();

                        // incrustar el logo de goteo
                        $mail->AddEmbeddedImage(GOTEO_PATH . '/goteo_logo.png', 'logo', 'Goteo', 'base64', 'image/png');
                    }
                    else {
                        $mail->IsHTML(false);
                        $mail->Body    = $this->bodyText();
                    }

                    // Envía el mensaje
                    return $mail->Send();

            	} catch(\PDOException $e) {
                    $errors[] = "No se ha podido enviar el mensaje: " . $e->getMessage();
                    return false;
    			} catch(phpmailerException $e) {
    			    $errors[] = $e->getMessage();
    			    return false;
    			}
            }
            return false;
		}

        /**
         * Cuerpo del mensaje en texto plano para los clientes de correo sin formato.
         */
        private function bodyText() {
            return strip_tags($this->content);
        }

        /**
         * Cuerpo del texto en HTML para los clientes de correo con formato habilitado.
         *
         * Se mete el contenido alrededor del diseño de email de Diego
         *
         */
        private function bodyHTML() {

            $viewData = array('content' => $this->content);

            // grabamos el contenido en la tabla de envios
            $sql = "INSERT INTO mail (id, email, html) VALUES ('', :email, :html)";
            $values = array (
                ':email' => $this->to,
                ':html' => str_replace('cid:goteo', SITE_URL.'/goteo_logo.png', $this->content)
            );
            $query = Model::query($sql, $values);

            $sendId = Model::insertId();

            if (!empty($sendId)) {
                // token para el sinoves
                $token = md5(uniqid()) . '¬' . $this->to  . '¬' . $sendId;
                $viewData['sinoves'] = \SITE_URL . '/mail/' . base64_encode($token) . '/?email=' . $this->to;
            } else {
                $viewData['sinoves'] = \SITE_URL . '/contact';
            }

            $viewData['baja'] = \SITE_URL . '/user/leave/?email=' . $this->to;

            return new View ('view/email/goteo.html.php', $viewData);
        }

        /**
         *
         * Adjuntar archivo.
         * @param type string	$filename
         * @param type string	$name
         * @param type string	$encoding
         * @param type string	$type
         */
        private function attachFile($filename, $name = false, $encoding = 'base64', $type = 'application/pdf') {
            $this->attachments[] = array(
                'filename' => $filename,
                'name' => $name,
                'encoding' => $encoding,
                'type' => $name
            );
        }

        /**
         *
         * Adjuntar cadena como archivo.
         * @param type string	$string
         * @param type string	$name
         * @param type string	$encoding
         * @param type string	$type
         */
        private function attachString($string, $name = false, $encoding = 'base64', $type = 'application/pdf') {
            $this->attachments[] = array(
                'string' => $string,
                'name' => $name,
                'encoding' => $encoding,
                'type' => $name
            );
        }

	}

}