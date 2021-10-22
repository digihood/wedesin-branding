<?php


if ( ! defined( 'ABSPATH' ) ) {

  exit;

}



if( ! class_exists( 'd1g1SendEmailBrand' ) )

{

    class d1g1SendEmailBrand
    {

      private $background;
      private $fontColorText;
      private $fontColorFooter;
      private $fontSize;
      private $lineHeight;
      private $fontFamily;
      private $buttonColor;
  
      public function __construct(){
        add_filter( 'wp_mail', [$this, 'change_headers'] );
        add_action( 'init', [$this,'email_test'] );
        $this->settings_css();
      }
      public function settings_css() {
        $this->background = ( get_option('_d1g1_D1G1BRAND_brand_emails_settings_footer_bg_color') ? get_option('_d1g1_D1G1BRAND_brand_emails_settings_footer_bg_color')  : '#414b55');
        $this->fontColorText = '#151B24';
        $this->fontColorLink = '#03acff';
        $this->fontColorFooter = ( get_option('_d1g1_D1G1BRAND_brand_emails_settings_footer_color') ? get_option('_d1g1_D1G1BRAND_brand_emails_settings_footer_color') : '#fff');
        $this->fontSize = '12px';
        $this->lineHeight = '16px';
        $this->fontFamily = 'Arial, sans-serif';
        $this->buttonColor = array('bg'=> '#B0EA91!important', 'color'=>'#151B24', 'hover'=> '#ffffff!important');
      }
      public function default_font_style(){
        $css = 'font-size: '.$this->fontSize.'; 
        line-height: '.$this->lineHeight.'; 
        font-family: '.$this->fontFamily.'; 
        color: '.$this->fontColorText.';';
        return $css;
      }
      public function text_settings(){
     
        $text = array(
          'footer_copy'=> '© '. date('Y') .' <a href="https://wedesin.cz" target="_blank">WeDesIn</a>',
          'footer_text'=> 'Tento email byl odeslán z webu <a href="'. get_home_url().'">'. $this->url_without().'</a>');
        return $text;
      }
  
      public function url_without(){
        $http = substr(get_home_url(), 0, 5);
        if ($http == 'https'){
            return str_replace('https://','',''.get_home_url().'');
        }else {
            return str_replace('http://','',''.get_home_url().'');
        }
      }
      function change_headers($args) {
  
        $mailheader = "Reply-To: jan@wedesin.cz\r\n";
        $mailheader .= "MIME-Version: 1.0\r\n";
        $mailheader .= "Content-Type: text/html; charset=utf-8\r\n";
  
        $args['headers'] = $mailheader;
  
        return $args;
  
      }
  
      /*
      wraps email body into prestyled html content
      ==============================================================*/
  
      public function email_content(
        $title, 
        $body="",
        $footer=""
        ){
          $img_default = D1G1_BRANDURL . 'assets/img/d1g1-logo-cz.png';
          $img = (get_option('_d1g1_D1G1BRAND_brand_emails_settings_header_logo') ? get_option('_d1g1_D1G1BRAND_brand_emails_settings_header_logo') : $img_default);

          $return ='<!DOCTYPE html>
              <html lang="cs">
              <head>
              <title>'. $title .'</title>
              <meta charset="utf-8">
              <meta name="viewport" content="width=device-width">
              <style type="text/css">'.
              $this->mail_default_css().
              '</style>
              </head>
              <body style="margin: 0; padding: 0; background: #f6f6f6;">
              <table  border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                      <td>
                          <div align="center" style="padding: 15px 15px 0px 15px;">
                              <table style="background: #ffffff;" border="0" cellpadding="0" cellspacing="0" width="600" class="wrapper">
                                  <tr>
                                      <td style="padding: 30px;" class="logo">
                                          <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                              <tr>
                                                  <td bgcolor="" width="600" align="center">
                                                    <a href="'.home_url().'"><img src="'.$img .'" width="300" height="auto" style="width: 300px; height:auto;"></a>
                                                  </td>
                                              </tr>
                                          </table>
                                      </td>
                                  </tr>
                              </table>
                          </div>
                      </td>
                  </tr>
              </table>
              <table border="0" cellpadding="0" cellspacing="0" width="100%">
                  <tr>
                      <td align="center" class="section-padding">
                          <table border="0" cellpadding="0" cellspacing="0" width="600" class="responsive-table">
                              <tr>
                                  <td bgcolor="#ffffff" style="padding: 10px ; font-size: '.$this->fontSize.'; line-height: '.$this->lineHeight.'; font-family:'.$this->fontFamily.'; color: '.$this->fontColorText.';">
                                  <div style="padding: 10px;">
                                      <table  width="100%" border="0" cellspacing="0" cellpadding="0">';
                                          if (!empty($title) ) {
                                            $return .= '<tr><td align="left" style="font-size: 40px; line-height: 48px; font-family: Georgia, Arial, sans-serif; color: '.$this->fontColorText.'; padding:20px 5%" class="padding-copy">' .$title. '</td></tr>';
                                          }
  
                                        if ( $body ) { 
                                          foreach ($body as $paragraph) {
  
                                            $return .= '<tr><td align="left" style="'.$this->default_font_style().' padding: 0 5% 20px 5%;" class="padding-copy">' .$paragraph. '</td></tr>';
  
                                          }
                                        }
                                          $return .= '<tr>
                                              <td align="left" style="padding: 15px 5% 20px 5%; font-size: 12px; line-height: 25px; font-family: '.$this->fontFamily.'; color: '.$this->fontColorText.';" class="padding-copy">'.$footer.'                                            
                                              </td>
                                          </tr>                                      
                                      </table>
                                  </div>
                                              
                                  </td>
                              </tr>
                          </table>
                      </td>
                  </tr>
              </table>'
              .$this->render_mail_footer().'
              </body>
              </html>';
  
              // echo $return;
              // die();
  
              return $return;
  
      }
      public function render_mail_footer() {
        $text = $this->text_settings();
        $return = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
          <tr>
            <td align="center">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" id="footer-email">
                    <tr>
                        <td style="padding: 0px 0px 20px 0px;">
                            <table style="background: '.$this->background.'; color:'.$this->fontColorFooter.';" width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="responsive-table">';
                                $return .='<tr>
                                    <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 15px 5px 0px 5px;">
                                    '. $text['footer_copy'].'
                                    </td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 0 5px;">
                                    '.$text['footer_text'].'
                                  </td>
                                </tr>
                                <tr>
                                  <td align="center" valign="middle" style="font-size: '.$this->fontSize .'; line-height: '. $this->lineHeight.'; font-family: '.$this->fontFamily.'; padding: 15px 5px 15px 5px;">
                                    <a href="'.home_url().'" target="_blank" style="color: '.$this->fontColorFooter.'; text-decoration: underline;">'.home_url().'</a>
                                  </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
          </tr>
        </table>';
        return $return;
      }
  
      /* Add default styles to email 
      ========================================================*/
      public function mail_default_css(){
        $css = '#outlook a{padding:0;}
        .ReadMsgBody{width:100%;} .ExternalClass{width:100%;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
        body, table, td, a{-webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;}
        table, td{mso-table-lspace:0pt; mso-table-rspace:0pt;}
        img{-ms-interpolation-mode:bicubic;}
        body{margin:0; padding:0;}
        img{border:0; height:auto; line-height:100%; outline:none; text-decoration:none;}
        table{border-collapse:collapse !important;}
        body{height:100% !important; margin:0; padding:0; width:100% !important;}
        .appleBody a {color:#666666; text-decoration: none;}
        .appleFooter a {color:#666666; text-decoration: none;}
        a {
          color: #2199e8;
        }
        a.button:hover {
            text-decoration: none !important;
            color: '.$this->buttonColor['hover'].';
            background :'.$this->buttonColor['bg'].';
            border-color: '.$this->buttonColor['bg'].';
        }
        @media screen and (max-width: 525px) {
            table[class="wrapper"]{
              width:100% !important;
            }
            td[class="logo"]{
              text-align: left;
              padding: 20px 0 20px 0 !important;
            }
            td[class="logo"] img{
              margin:0 auto!important;
            }
            td[class="mobile-hide"]{
              display:none;
            }
            img[class="mobile-hide"]{
              display: none !important;
            }
            img[class="img-max"]{
              max-width: 100% !important;
              height:auto !important;
            }
            table[class="responsive-table"]{
              width:100%!important;
            }
            td[class="padding"]{
              padding: 10px 5% 15px 5% !important;
            }
            td[class="padding-copy-to-center"]{
              padding: 10px 5% 10px 5% !important;
              text-align: center;
            }
            td[class="padding-copy"]{
              padding: 10px 5% 10px 5% !important;
            }
            td[class="padding-meta"]{
              padding: 30px 5% 0px 5% !important;
              text-align: center;
            }
            td[class="no-pad"]{
              padding: 0 0 20px 0 !important;
            }
            td[class="no-padding"]{
              padding: 0 !important;
            }
            td[class="section-padding"]{
              padding: 30px 15px 30px 15px !important;
            }
            td[class="section-padding-bottom-image"]{
              padding: 30px 15px 0 15px !important;
            }
            td[class="mobile-wrapper"]{
                padding: 10px 5% 15px 5% !important;
            }
            table[class="mobile-button-container"]{
                margin:0 auto;
                width:100% !important;
            }
            a[class="mobile-button"]{
                width:80% !important;
                padding: 15px !important;
                border: 0 !important;
                font-size: 12px !important;
            }
        }';
        return $css;
      }
  
      /* Send admin email
      ========================================================*/
  
      public  function send_admin_email( $subject, $message ) {
          $headers = array( 'Content-Type: text/html; charset=UTF-8 ' );
          $to = get_field( 'admin_email', 'options');
          //submit admin email
          if ( $to && $subject && $message ) {
            wp_mail( $to, $subject, $message, $headers );
          }
      } 
  
      /* Create email to send to the user
      ========================================================*/
  
      public function send_client_emails( $mail, $subject, $message ){ 
  
        $headers = array( 'Content-Type: text/html; charset=UTF-8 ');
  
        if ( $mail && $subject && $message ) {
          wp_mail(  $mail, $subject, $message, $headers );
          return true;
        }  
  
        return false;
      }
  
      /* Test mailů
      ========================================================*/
      public function email_test() {
        if ( isset($_GET['showmail']) &&$_GET['showmail']==1 ) {
          echo $this->email_content( 'title', 'subtitle',array('test', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Nullam sapien sem, ornare ac, nonummy non, lobortis a enim. Etiam egestas wisi a erat. Vivamus ac leo pretium faucibus. Maecenas sollicitudin. Morbi leo mi, nonummy eget tristique non, rhoncus non leo. Vivamus luctus egestas leo. Suspendisse sagittis ultrices augue. Etiam dui sem, fermentum vitae, sagittis id, malesuada in, quam. Nullam justo enim, consectetuer nec, ullamcorper ac, vestibulum in, elit. Aliquam ante. Aliquam erat volutpat. In convallis.'),
          'footer', 'https://wedesin.cz', 'ahoj' );
          die('semtu');
        }
      }
    }
}
