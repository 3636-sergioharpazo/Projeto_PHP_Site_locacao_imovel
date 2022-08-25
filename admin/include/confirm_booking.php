<?php
// PHP Hotel Booking
// http://www.netartmedia.net/php-hotel-booking
// Copyright (c) All Rights Reserved NetArt Media
// Find out more about our products and services on:
// http://www.netartmedia.net
// Released under the MIT license
?><?php
if(!defined('IN_SCRIPT')) die("");
require('class.phpmailer.php');

if(!isset($_REQUEST["id"])||!is_numeric($_REQUEST["id"]))
{
	die("The booking ID is not set!");
}

$id=intval($_REQUEST["id"]);

$xml = simplexml_load_file($this->booking_file);
$booking=$xml->booking[$id];

if(!isset($booking->code)) die("No booking found with this code!");
?>

<div class="header-line">
		  <div class="container">
		  
			<a href="index.php" style="margin-top:17px" class="btn btn-default pull-right"><?php echo $this->texts["go_back"];?></a>
			
			<h3><?php echo $this->texts["confirm_booking"];?> <strong><?php echo $booking->code;?></strong></h3>
		  </div>
	</div>
	

	<div class="container main-content">
<?php
if(isset($_POST["proceed_confirm"]))
{
	$xml->booking[$id]->status=1;
	$xml->asXML($this->booking_file); 
	
	$message_text=$this->texts["booking_confirmation_message"];
	$message_text=str_replace("{NAME}",$booking->name,$message_text);
	
	$number_nights=(intval($booking->end_time)-intval($booking->start_time))/86400;
	$booking_details=$number_nights." ".$this->texts["nights"]." (".
	date($this->settings["website"]["date_format"],intval($booking->start_time))." ".
	" - ".date($this->settings["website"]["date_format"],intval($booking->end_time)).") ";
	
	$message_text=str_replace("{BOOKING_DETAILS}",$booking_details,$message_text);
	$message_text=str_replace("{BOOKING_CODE}",$booking->code,$message_text);
	



	$msg1 = $message_text;
?>
<script>

	document.location.href="https://api.whatsapp.com/send?phone=5588988423386&text=$msg1"
	
</script>
<?php


	$nome = "Cliente";
	$email =$this->settings["website"]["admin_email"];
	$msg1 = $_POST["message"];
	$assunto = $_POST["subject"];
   
   
   $faleconosco="faleconosco@seusucesso.farce.com.br";
   $subject = $assunto ;
   $messageBody = "<div class='container' style='background:url(http://www.gestorescolar.farce.com.br/fundo_div.png);border-radius:12px; padding:10px;margin:10px;'><fieldset><legend><h1><b>Informativo SEUSUCESSO.COM !</b></h1></legend><div class='rows' style='background-color:white;border-radius:12px; border-width: 6px; border-style: dashed; border-color: #f00;'><br>Olá estimado(a) <b>$nome,</b> tudo bem? <br> <br>$msg1<br><br></fieldset><br>Atenciosamente,<br>SEUSUCESSO.COM<br><a href='https://seusucesso.farce.com.br/anuncios/'>https://www.seusucesso.com</a><br> <img style='border-radius:15px;width:200px;height:200px;'src='https://seusucesso.farce.com.br/anuncios/logo_sem_fundo.png' alt='logo'></div>";
   $mail = new PHPMailer();
   $mail->SetFrom($faleconosco,utf8_decode("SEUSUCESSO.COM - SUA AGÊNCIA DIGITAL "));
   $mail->Subject=(utf8_decode($subject));
   $mail->MsgHTML(utf8_decode($messageBody));	
   $mail->AddAddress($email); 
   
   //$mail->addStringAttachment($pdfdoc, 'certificado.pdf');
   $mail->Send();
   

	


	$xml->booking[$id]->status=1;
	$xml->asXML($this->booking_file); 
	echo "<br/><h3>".$this->texts["booking_status_confirmed"]."</h3>";

	$headers  = "From: \"".strip_tags(stripslashes($this->settings["website"]["admin_email"]))."\"<".strip_tags(stripslashes($this->settings["website"]["admin_email"])).">\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Date: ".date("r")."\r\n";
	$headers .= "Message-ID: <".time()."@booking>\r\n";
	$headers .= "Content-Type: text/plain; charset=utf-8\r\n";
	
	if(mail
	(
		$booking->email,
		stripslashes($_POST["subject"]),
		stripslashes($_POST["message"]),
		$headers
	))
	{
		?>
		<h3><?php echo $this->texts["message_sent_success"];?></h3>
	
		<?php
	}
	else
	{
		?>
		<h3 class="red-font"><?php echo $this->texts["error_while_sending"];?></h3>
	
		<?php	
	}
}
else
{
?>
	

			<br/>
			<?php

			
			
			?>
			
			<div class="row">
				<div class="col-md-8">
				
					<br/>
				
				
					<form id="main" action="index.php" method="post"   enctype="multipart/form-data">
					<input type="hidden" name="page" value="confirm_booking"/>
					<input type="hidden" name="proceed_confirm" value="1"/>
					<input type="hidden" name="id" value="<?php echo $_REQUEST["id"];?>"/>
					
						<fieldset>
							<legend><?php echo $this->texts["message_customer"];?></legend>
							<ol>
								<li>
									<label><?php echo $this->texts["send_message"];?>:</label>
									<select name="send_message">
										<option value="1"><?php echo $this->texts["yes_word"];?></option>
										<option value="0"><?php echo $this->texts["no_word"];?></option>
									</select>
								</li>
										
								<li>
									<label><?php echo $this->texts["subject"];?>:</label>
									
					
									<input type="text" name="subject" value="<?php echo $this->texts["booking_has_confirmed"];?>"/>
								</li>
								
								<li>
									<label><?php echo $this->texts["message"];?>:</label>
<?php


$message_text=$this->texts["booking_confirmation_message"];
$message_text=str_replace("{NAME}",$booking->name,$message_text);

$number_nights=(intval($booking->end_time)-intval($booking->start_time))/86400;
$booking_details=$number_nights." ".$this->texts["nights"]." (".
date($this->settings["website"]["date_format"],intval($booking->start_time))." ".
" - ".date($this->settings["website"]["date_format"],intval($booking->end_time)).") ";

$message_text=str_replace("{BOOKING_DETAILS}",$booking_details,$message_text);
$message_text=str_replace("{BOOKING_CODE}",$booking->code,$message_text);

?>								
<textarea name="message" cols="40" rows="10"><?php echo $message_text;?></textarea>
								</li>
						
								
							<ol>
						</fieldset>
						
						
						
						<div class="clearfix"></div>
						<br/>
						<button type="submit" class="btn btn-primary pull-right"> <?php echo $this->texts["confirm"];?> </button>
						
						<div class="clearfix"></div>
						<br/>
					</form>
				
				</div>
				
			</div>

	
<?php
}
?>
</div>