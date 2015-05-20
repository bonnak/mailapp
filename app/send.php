<?php

use Mailgun\Mailgun;
use Mailgun\Connection\Exceptions as MailgunExceptions;

// Instantiate the client.
$mgClient = new Mailgun(MAILGUN_KEY);
$mgValidate = new Mailgun(MAILGUN_PUBKEY);

// Get mail list.
$list = $mgClient->get('lists')->http_response_body;

// echo '<pre>', print_r($list->items), '</pre>';

if(isset($_POST['mail-to'], $_POST['subject'], $_POST['message']))
{
	$addressList = $_POST['mail-to'];
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	// Validate email address.
	$r_validation = $mgValidate->get("address/parse", array('addresses' => $addressList));

	if(!empty($r_validation->http_response_body->unparseable))
	{
		$unparseables = $r_validation->http_response_body->unparseable;
		$error_str = '';

		foreach ($unparseables as $invalid_mail) 
		{
			$error_str .= $invalid_mail . ', ';
		}

		$error_str = "<b>Invalid email address :</b> \t\t" . trim($error_str, ', ');

	}
	else
	{		
		$addressList = explode(',', $addressList);

		try
		{
			foreach ($addressList as $mail_address) 
			{
				$mgClient->sendMessage(MAILGUN_DOMAIN, array(
				    'from'    => 'info@itscholar.org',
				    'to'      => trim($mail_address),
				    'subject' => $subject,
				    'text'    => $message
				));
			}

			$success_sent = true;
		}
		catch(Exception $ex)
		{
		}
	}	
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<!-- Bootstrap -->
    <link href="asset/bootstrap-3.3.4/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="asset/css/base.css">
    <link rel="stylesheet" type="text/css" href="asset/css/layout.css">
    <link rel="stylesheet" type="text/css" href="asset/css/module.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script type="text/javascript" src="asset/bootstrap-3.3.4/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="asset/js/global.js"></script>
</head>
<body>
	<?php if(isset($success_sent)): ?>
		<div class="inform-box alert-success">
			<span><b>Message sent successfully</b></span>
		</div>
	<?php elseif(isset($error_str)): ?>
		<div class="inform-box alert-danger">
			<span><?php echo $error_str ?></span>
		</div>
	<?php endif ?>
	<div class="container box-shadow">
		<form method="post" id="frm-send-mail">
			<div class="form-group">
		    	<label for="txt-send-to">To</label>
	    		<div class="input-group">
	    			<input type="text" class="form-control" id="txt-send-to" name="mail-to">
	    			<span class="input-group-btn">
	    				<button type="button" class="btn btn-default" id="btn-list" data-toggle="modal" data-target="#mail-list-modal">...</button>
	    			</span>
	    		</div>
		 	</div>
		 	<div class="form-group">
		    	<label for="txt-subject">Subject</label>
		    	<input type="text" class="form-control" id="txt-subject" name="subject">
		 	</div>
		 	<div class="form-group">
		    	<label for="txt-msg">Message</label>
		    	<textarea class="form-control" id="txt-msg" name="message"></textarea>
		 	</div>
		 	<div class="clearfix">
			 	<center><button type="submit" class="btn btn-primary" id="btn-send">Send</button></center>
		 	</div>
		</form>
	</div>
	<!-- Modal -->
	<div class="modal fade" id="mail-list-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="border: none; padding-bottom: 5px;">
				 	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>				 	
					<label>Email list</label>
				</div>
				<div class="modal-body" style="padding-top: 0;">
        			<select id="mailing-list" class="form-control" multiple>
        				<?php foreach ($list->items as $item) : ?>
        					<option value="<?php echo $item->address ?>"><?php echo $item->name ?></option>
        				<?php endforeach ?>
        			</select>
        			<div class="clearfix" style="margin-top: 10px;">
	        			<button type="button" id="btn-choose-mail-list" class="btn btn-primary pull-right" style="padding: 6px 27px;">OK</button>
	        		</div>
      			</div>	      			
			</div>
		</div>
	</div>
	<script>
		$('#mail-list-modal').on('shown.bs.modal', function () {
			$('#myInput').focus();
		});
	</script>
</body>
</html>