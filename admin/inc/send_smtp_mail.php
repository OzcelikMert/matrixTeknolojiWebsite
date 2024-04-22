<?php
// Send email message (SMTP MAİL)
function sendMail_smtp($host, $username, $password, $title, $who, $name, $subject, $msg){
  // Send Message

  // File Location Control
  if(file_exists("./inc/class.phpmailer.php")){
      require_once("./inc/class.phpmailer.php");
  }else if(file_exists("../admin/inc/class.phpmailer.php")){
    require_once("../admin/inc/class.phpmailer.php");
  }
  // end File Location Control

  $mail = new PHPMailer();
  $mail->IsSMTP();
  $mail->SetLanguage("tr", "phpmailer/language");
  $mail->SMTPAuth = true;
  $mail->Host = $host;
  $mail->Port = 465;
  $mail->SMTPKeepAlive = true;
  $mail->SMTPDebug = 1;
  $mail->IsHTML(true);
  $mail->SMTPSecure = 'ssl';
  $mail->Subject = $subject;
  $mail->Username = $username;
  $mail->Password = $password;
  $mail->SetFrom($mail->Username, $title);
  $mail->AddAddress($who, $name);
  $mail->CharSet = 'UTF-8';
  $mail->MsgHTML($msg);
  if($mail->Send()) {
      return true;
  } else {
      return false;
  }
  // end Send Message
}
// end Send email message (SMTP MAİL)

// Mail Design
function HTMLDesignMail($msg_title, $msg_content, $msg_link_1_text, $msg_privacy_link_text, $msg_unfollow_link_text, $url_1, $url_2){
  // Message in items
  $title = "Matrix Teknoloji";

  $msg_header_img = '
  <img src="https:///wp-1.ozceliksoftware.com/admin/inc/email_sample/images/email_header.png" alt="Matrix Teknoloji" title="Matrix Teknoloji" width="500" height="200" style="display: block;" />';

  $msg_link_1 = '
  <a href="'.$url_1.'" style="background-color: #00000042;padding: 8px;border-radius: 10px;text-decoration: none;font-size: larger;color: #001eb2;">
    '.$msg_link_1_text.'
  </a>';

  $msg_privacy_link = '
  <a href="#" style="float: left;text-decoration: none;color: blue;font-size: 17px;">
    '.$msg_privacy_link_text.'
  </a>';

  $msg_unfollow_link = '
  <a href="'.$url_2.'" style="float: right;text-decoration: none;color: blue;font-size: 17px;">
    '.$msg_unfollow_link_text.'
  </a>';

  $msg_social_link_1 = '
  <a href="https://www.twitter.com/" style="color: #ffffff;">
    <img src="https:///wp-1.ozceliksoftware.com/admin/inc/email_sample/images/social/twtr.png" alt="Twitter" title="Twitter/Matrix-Teknoloji" width="38" height="38" style="display: block;" border="0" />
  </a>';

  $msg_social_link_2 = '
  <a href="https://www.facebook.com/" style="color: #ffffff;">
    <img src="https:///wp-1.ozceliksoftware.com/admin/inc/email_sample/images/social/fcbk.png" alt="Facebook" title="Facebook/Matrix-Teknoloji" width="38" height="38" style="display: block;" border="0" />
  </a>';
  // end Message in items
  /*
  =========================================
   HTML DESIGN MAIL
  =========================================
  */
  return '
  <html>
  <head>
    <title>'.$title.'</title>
  </head>
  <body style="margin: 0; padding: 0;">
      <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
          <tr>
              <td style="padding: 10px 0 30px 0;">
                  <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                      <tr>
                          <td align="center" style="background-color: #150a7fcf; padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            '.$msg_header_img.'
                          </td>
                      </tr>
                      <tr>
                          <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                      <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                          <b>'.$msg_title.'</b>
                                      </td>
                                  </tr>
                                  <tr>
                                      <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        '.$msg_content.'
                                      </td>
                                  </tr>
                                  <tr>
                                    '.$msg_link_1.'
                                  </tr>
                                  <tr>
                                      <td>
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td width="260" valign="top">
                                                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                          <tr>
                                                              <td>
                                                                '.$msg_privacy_link.'
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                                  <td style="font-size: 0; line-height: 0;" width="20">
                                                      &nbsp;
                                                  </td>
                                                  <td width="260" valign="top">
                                                      <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                          <tr>
                                                              <td>
                                                                '.$msg_unfollow_link.'
                                                              </td>
                                                          </tr>
                                                      </table>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                      <tr>
                          <td style="background-color: black;padding: 30px 30px 30px 30px;">
                              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                  <tr>
                                      <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;" width="75%">
                                          © <?php echo date("Y"); ?> Copyright Matrix Teknoloji | All Rights Reserved<br/>
                                      </td>
                                      <td align="right" width="25%">
                                          <table border="0" cellpadding="0" cellspacing="0">
                                              <tr>
                                                  <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                      '.$msg_social_link_1.'
                                                  </td>
                                                  <td style="font-size: 0; line-height: 0;background-color:transparent;" width="20"></td>
                                                  <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                      '.$msg_social_link_2.'
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </td>
                      </tr>
                  </table>
              </td>
          </tr>
      </table>
  </body>
  </html>
  ';
  /*
  =========================================
   end HTML DESIGN MAIL
  =========================================
  */
}
// end Mail Design
?>