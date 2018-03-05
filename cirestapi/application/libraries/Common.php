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

  
   
   

    
    
 
    
    
    /////////////////////// form Detail to pixopa from contact us page/////////////////////////////
    
    function getMailBodyTemplatecontactusform($formData,$additional_data) {
    	//echo "<pre>".print_r($formData)."<br>";
    	//echo $job_title= $formData['custom_fields']['leads']['2'];
    	//die;
    	//get mail body
    	$country= $formData['country'];
    	$country_name = get_country_name($country);
    	 
    	$name= $formData['name'];
    	//$address= $formData['address'];
    	$email_id= $formData['email'];
    	$company= $formData['company'];
    	//$city= $formData['city'];
    
    	//$zip= $formData['zip'];
    	$phone_no= $formData['phonenumber'];
    	//$job_title= $formData['custom_fields']['leads']['2'];
    	$skype_id= $additional_data['skype_id'];
    	$website_url= $additional_data['website_url'];
    	//$project_for_client_own= $formData['custom_fields']['leads']['7'];
    	$solution_interested= $additional_data['solution_interested'];
    	$working_website= $additional_data['working_ecomm_site'];
    	$selected_platform= $additional_data['ecomm_platform'];
    	$revenue= $additional_data['annual_revenue'];
    	$type_of_product_want_to_sell= $additional_data['products_want_to_sell'];
    	$comment= $additional_data['comment'];
    	//$subscription_plan= $formData['custom_fields']['leads']['14'];
    	$role = $additional_data['describe_role'];
    	$own_developer=$additional_data['developer_for_maintenance'];
    	if($solution_interested=="Design Tool"){
    		$dolplatform =$formData['designtool_platform'];
    	}else{
    		$dolplatform ="-";
    	}
    	
    
    
    	$mailbody_Title = "New Contact Us Inquiry";
    	$mailbody_username = "Hi Pixopa ,";
    	$mailbody_client_name = "Client Name : $name";
    	// $mailbody_pass_name = "Passanger Name : $pass_name,";
    	$mailbody_description = " New Contact Us Inquiry ";
    	$mailbody_person = "Email ID : <a href=\"mailto:$email_id?subject=Your Pixopa Inquiry\">$email_id</a>" . "<br>" . "Company : $company "."<br>" . "Phone No : $phone_no ";
    	$mailbody_stay = "Country : $country_name ";
    	$mailbody_social = " Skype ID : $skype_id "."<br>"."Website URL : <a href=\"$website_url\">$website_url</a>";;
    	$mailbody_developer_or_not = " Do you have your own website developer/team for website maintenance and integration?  : $own_developer ";
    	$mailbody_solutn_interested = " Solution interested in : $solution_interested ";
    	if($solution_interested=="Design Tool"){
    		$mailbody_dol_plaform = " Platform are you looking to run Design Tool on :  $dolplatform";
    	}else{
    		$mailbody_dol_plaform = " Platform are you looking to run Design Tool on :  -";
    	}
    	
    	
    	$mailbody_working_website = " Do you have a working ecommerce website? : $working_website";
    	if($working_website=="Yes"){
    		$mailbody_selected_platform = " Select Platform : $selected_platform";
    	}else{
    		$mailbody_selected_platform = " Select Platform : -";
    	}
    	
    	$mailbody_revenue = " Approximate monthly revenue in USD : $revenue";
    	$mailbody_prd_want_to_sell = " What types of products do you plan to sell : $type_of_product_want_to_sell";
    	$mailbody_comment = " Comment : $comment";
    	$mailbody_role = " Describe Your Role: $role";
    
    
    
    
    
    	$mailbodytext1 = '<table class="table_width_100" style="max-width: 680px; min-width: 300px;margin:0 auto; border:1px solid #dddddd;" border="0" cellpadding="0" cellspacing="0" width="100%">
<!--header -->
<tbody>
<tr>
<td align="center" bgcolor="#fff">
<!-- padding -->
<div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody>
<tr>
<td align="center">
    
<div class="mob_center_bl" >
<table class="mob_center" style="border-collapse: collapse;" align="center" border="0" cellpadding="0" cellspacing="0" width="0">
<tbody>
<tr>
<td align="center" valign="middle">
    
<!--<div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
<table border="0" cellpadding="0" cellspacing="0" width="115">-->
    
<tbody>
<tr>
<td class="mob_center" align="center" valign="top">
    
<img src="' . APP_BASE_URL . 'assets/images/pixopa_logo_new-1.png" class="img-responsive">
    
<!--<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 13px;">
<font face="Arial, Helvetica, sans-seri; font-size: 13px;" color="#596167" size="3">
<img src="' . APP_BASE_URL . 'assets/images/pixopa_logo_new-1.png" alt="Arabian Connection" style="display: block;" border="0" width="115"></font></a>
</td></tr>
</tbody></table>
</td></tr>-->
</tbody></table></div><!-- Item END--><!--[if gte mso 10]>
</td>
<!--<td align="right">
<![endif]--><!-- Item -->
<div class="mob_center_bl" style="float: right; display: none; width: 88px;">
<table style="border-collapse: collapse;" align="right" border="0" cellpadding="0" cellspacing="0" width="88">
<tbody><tr><td align="right" valign="middle">
<!-- padding --><div style="height: 20px; line-height: 20px; font-size: 10px;">&nbsp;</div>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="right">
<!--social -->
<div class="mob_center_bl" style="width: 88px;">
<table border="0" cellpadding="0" cellspacing="0">
<tbody><tr><td style="line-height: 19px;" align="center" width="30">&nbsp;
<!--<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<font face="Arial, Helvetica, sans-serif" color="#596167" size="2">
<img src="http://artloglab.com/metromail2/images/facebook.gif" alt="Facebook" style="display: block;" height="19" border="0" width="10"></font></a>-->
</td><td style="line-height: 19px;" align="center" width="39">&nbsp;
<!--<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<font face="Arial, Helvetica, sans-serif" color="#596167" size="2">
<img src="http://artloglab.com/metromail2/images/twitter.gif" alt="Twitter" style="display: block;" height="16" border="0" width="19"></font></a>-->
</td><td style="line-height: 19px;" align="right" width="29">&nbsp;
<!--<a href="#" target="_blank" style="color: #596167; font-family: Arial, Helvetica, sans-serif; font-size: 12px;">
<font face="Arial, Helvetica, sans-serif" color="#596167" size="2">
<img src="http://artloglab.com/metromail2/images/dribbble.gif" alt="Dribbble" style="display: block;" height="19" border="0" width="19"></font></a>-->
</td></tr>
</tbody></table>
</div>
<!--social END-->
</td></tr>
</tbody></table>
</td></tr>
</tbody></table></div><!-- Item END--></td>
</tr>
</tbody></table>
<!-- padding --><div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
</td></tr>
<!--header END-->
    
<!--content 1 -->
<tr><td align="center" bgcolor="#f9fafc">
<table border="0" cellpadding="0" cellspacing="0" width="100%" border="0">
<tbody>
<tr><td align="center">
<div style="line-height: 10px;">
<font style="font-size: 17px;" face="Arial, Helvetica, sans-serif" color="#4db3a4" size="5">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 17px; color: #4db3a4;">
' . $mailbody_client_name . '
</span></font>
</div>
<!-- padding --><div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
</td></tr>
<!--<tr><td align="center">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="center">
<div style="line-height: 24px;">
<font style="font-size: 17px;" face="Arial, Helvetica, sans-serif" color="#4db3a4" size="5">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 17px; color: #4db3a4; padding-bottom:6px;">' .
    $mailbody_description . '
</span></font>
</div>
</td></tr>-->
    		
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;padding:25px;background:#f1f1f1;margin-top:15px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_person . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left" style="border-top:1px solid #ccc;padding:25px;margin:10px;background:#f7f7f7;">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_stay . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_social . '
</span></font>
</div>
</td></tr>
    		
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_role . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_developer_or_not . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_solutn_interested . '
</span></font>
</div>
</td></tr>'.
    	

	
	'<tr><td align="left">
	<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
	<tbody><tr><td align="left">
	<div style="line-height: 24px;">
	<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
	<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_dol_plaform . '
	    </span></font>
	    </div>
	    </td></tr>'.
  		    		
   		
    
'<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_working_website . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_selected_platform . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_revenue . '
</span></font>
</div>
</td></tr>
    
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_prd_want_to_sell . '
</span></font>
</div>
</td></tr>
    
<tr><td align="left">
<table align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="line-height: 24px;">
<font style="font-size: 16px;" face="Arial, Helvetica, sans-serif" color="#57697e" size="4">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 15px; color: #57697e;">' .
    $mailbody_comment . '
</span></font>
</div>
</td></tr>
    
</tbody></table>
<div style="height: 45px; line-height: 45px; font-size: 10px;">&nbsp;</div>
</td></tr>
<tr><td align="center">
<div style="height: 100px; line-height: 100px; font-size: 10px;">&nbsp;</div>
</td></tr>
</tbody></table>
</td></tr>
<!--content 1 END-->
    
<!--links -->
<!--<tr><td align="left" bgcolor="#f7f7f7">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="left">
<div style="height: 30px; line-height: 30px; font-size: 10px;">&nbsp;</div>
    
</td></tr>
<tr><td><div style="height: 30px; line-height: 30px; font-size: 10px;">&nbsp;</div></td></tr>
</tbody></table>
</td></tr>-->
    
<!--links END-->
<!--footer -->
<tr><td class="iage_footer" align="center" bgcolor="#444">
<!-- padding --><div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
    
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td align="center">
<font style="font-size: 13px;" face="Arial, Helvetica, sans-serif" color="#fff" size="3">
<span style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #fff;">
2017 &#169; Pixopa Web-to-Print Solutions. All Rights Reserved.
</span></font>
</td></tr>
</tbody></table>
    
<!-- padding --><div style="height: 10px; line-height: 10px; font-size: 10px;">&nbsp;</div>
</td></tr>
<!--footer END-->
</tbody></table>';
    	return $mailbodytext1;
    }
    
    
 
    
    
    
   
    
   

}

