<?php
class Zsurforce_Utils_Mailer
{
    static function enviarCorreo( $to, $subject, $message, $from="admin@localhost", $conCopia="", $conCopiaOculta="")
    {
        $to .= "\r\n";
        $subject .= "\r\n";
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=utf-8\r\n";
        $headers .= "To: $to\r\n";
        $headers .= "From: $from\r\n";

        if ($conCopia!="") $headers .= "Cc: $conCopia\r\n";

        if($conCopiaOculta!="") $headers .= "Bcc: $conCopiaOculta\r\n";

        $message = stripslashes( $message );

        if (!mail ( $to, $subject, $message, $headers )) {
            throw new Exception("No se pudo enviar el correo");
        }
    }
}
?>
