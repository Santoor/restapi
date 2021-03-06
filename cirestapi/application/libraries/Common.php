<?php

class Common {

    
    private $CI;

    public function __construct() {
        //$this->load->helper('string');
        $this->CI = & get_instance();

        //$this->load->library('encrypt');
    }

   

    

   

    public function get_mime_type($sfile) {
        $mime_types = array(
            "pdf" => "application/pdf"
            , "exe" => "application/octet-stream"
            , "zip" => "application/zip"
            , "docx" => "application/msword"
            , "doc" => "application/msword"
            , "xlsx" => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet"
            , "xls" => "application/vnd.ms-excel"
            , "ppt" => "application/vnd.ms-powerpoint"
            , "gif" => "image/gif"
            , "png" => "image/png"
            , "jpeg" => "image/jpg"
            , "jpg" => "image/jpg"
            , "mp3" => "audio/mpeg"
            , "wav" => "audio/x-wav"
            , "mpeg" => "video/mpeg"
            , "mpg" => "video/mpeg"
            , "mpe" => "video/mpeg"
            , "mov" => "video/quicktime"
            , "avi" => "video/x-msvideo"
            , "3gp" => "video/3gpp"
            , "css" => "text/css"
            , "jsc" => "application/javascript"
            , "js" => "application/javascript"
            , "php" => "text/html"
            , "htm" => "text/html"
            , "html" => "text/html"
            , "txt" => "text/plain"
            , "xml" => "application/xml"
            , "xsl" => "application/xml"
            , "tar" => "application/x-tar"
            , "swf" => "application/x-shockwave-flash"
            , "odt" => "application/vnd.oasis.opendocument.text"
            , "ods" => "application/vnd.oasis.opendocument.spreadsheet"
            , "odp" => "application/vnd.oasis.opendocument.presentation"
        );

        $extension = strtolower(pathinfo($sfile, PATHINFO_EXTENSION));
        return $mime_types[$extension];
    }

    

    public function getid($poPrefix) {
        date_default_timezone_set("Asia/Calcutta");
        $sCode = '';
        for ($i = 0; $i < 2; $i++) { /* Random String Generator */
            $aChars = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
            $iTotal = count($aChars) - 1;
            $iIndex = rand(0, $iTotal);
            $sCode .= $aChars[$iIndex];
            $sCode .= chr(rand(49, 57));
        }
        $time_component = substr(date("YmdHis", time()), 2);
        //$random_number_component = substr($sCode, 2);
        $random_number_component = substr($time_component . $sCode, 7);
        $cCode = $poPrefix . $random_number_component;
        return ($cCode);
    }

  

    

    function sendmail($senderID, $senderName, $receiverID, $subject, $messageBody, $attachfile, $addReplyTo = false) {
        $this->CI->load->library('email');
        

        
        
    $config = Array(
        'protocol' => 'smtp',
        'smtp_host' => 'ssl://smtp.googlemail.com',
        'smtp_port' => 465,
        'smtp_user' => '',
        'smtp_pass' => '',
        'mailtype'  => 'html', 
        'charset'   => 'UTF-8'
    );
    
    $config['useragent']    = "CodeIgniter";
    $config['mailpath']     = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
    $config['wordwrap']     = TRUE;
    $config['charset']      = 'UTF-8';
    $config['newline']      = "\r\n";
    $config['crlf']         = "\r\n";
      


        $this->CI->email->initialize($config);


        $this->CI->email->from($senderID, $senderName);
        $this->CI->email->to($receiverID);
        $this->CI->email->subject($subject);
        $this->CI->email->message($messageBody);
        
        if($addReplyTo){
        	$this->CI->email->reply_to($senderID);
        }
        
        if (!empty($attachfile)) {
            $this->CI->email->attach($attachfile);
        }

        // send email
        if (!$this->CI->email->send()) {
            // Generate error
            echo $this->CI->email->print_debugger();
            die;
            return false;
        } else {
            // Generate error
            //echo $this->CI->email->print_debugger();
            //die;
            return true;
        }
    }

  
   
   

    
    
 
    
    
    
    
 
    
    
    
   
    
   

}

