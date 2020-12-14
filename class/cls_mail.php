<?php
if (is_file('../PHPMailer/PHPMailerAutoload.php')) {
    require_once '../PHPMailer/PHPMailerAutoload.php';
} else {
    require_once 'PHPMailer/PHPMailerAutoload.php';
}
class ngs_mail {
    var $subject = "";
    var $body = "";
    var $obj_mail;
    var $address = array();
    var $names = array();
    var $attachment_url;
    var $flag;
//    var $atachment_url = '';
    var $fromName = 'Healthcare Doctors';
//    var $string_attachement = "";
//    var $string_attachement_name = "";
    function sendmail() {
        $mail = new PHPMailer;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        //$mail->Port = 587;
//        $mail->Host = 'mail.thoshimedicals.com.au';
        $mail->Port = 465;
        $mail->SMTPAuth = true;
        //$mail->Username = 'systemadmin@thoshimedicals.com.au';
        //$mail->Password = '[GUCmQjW^Q}V';
        $mail->Username = 'healthcaredoctors2020@gmail.com';
        $mail->Password = 'MafACa&!2020$';
        
        $mail->SMTPSecure = 'ssl';
        //$mail->SMTPSecure = 'tls';
        //$mail->Mailer   = "smtp";
         //$mail->SMTPDebug = 3;         
//         $mail->addStringAttachment(file_get_contents('http://127.0.0.1/c2m_MedicalCenter/ajax/' . $this->attachment_url), $this->attachment_url);
        if($this->flag == 'm') {
            $mail->addAttachment('../ajax/' . $this->attachment_url, $this->attachment_url);
        }        
//        $mail->addEmbeddedImage(dirname(__DIR__)."/img/logo.png", 'logo', 'logo.png');  
        //$mail->SMTPSecure = 'tls';
        $mail->From = 'healthcaredoctors2020@gmail.com';
        $mail->FromName = $this->fromName;
        $mail->addReplyTo('healthcaredoctors2020@gmail.com', 'Healthcare Doctors');
        $mail->WordWrap = 50;
        $mail->isHTML(true);
        $mail->Subject = $this->subject;
        $mail->Body = $this->body;
        $i = 0;
        foreach ($this->address as $email) {
            $mail->addAddress($email, $this->names[$i]);
            $i++;
        }
        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
}
?>
