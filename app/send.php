<?php

use Mailgun\Mailgun;

// Instantiate the client.
$mgClient = new Mailgun(MAILGUN_KEY);
$mgValidate = new Mailgun(MAILGUN_PUBKEY);

$list = $mgClient->get('lists')->http_response_body;

// echo '<pre>', print_r($list->items), '</pre>';

if(isset($_POST['subject'], $_POST['message']))
{
	$subject = $_POST['subject'];
	$message = $_POST['message'];

	// Make the call to the client.
	$mgClient->sendMessage(MAILGUN_DOMAIN, array(
	    'from'    => 'noreply@mailgun.org',
	    'to'      => MAILGUN_LIST,
	    'subject' => $subject,
	    'text'    => $message
	));
}

?>
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
</head>
<body>
	<div class="container box-shadow">
		<form method="post">
			<div class="form-group">
		    	<label for="txt-send-to">To</label>
	    		<div class="input-group">
	    			<input type="text" class="form-control" id="txt-send-to">
	    			<span class="input-group-btn">
	    				<button type="button" class="btn btn-default" id="btn-list" data-toggle="modal" data-target="#myModal">...</button>
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
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="border: none; padding-bottom: 5px;">
				 	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>				 	
					<label>Email list</label>
				</div>
				<div class="modal-body" style="padding-top: 0;">
        			<select id="mailing-list" class="form-control" multiple>
        				<?php foreach ($list->items as $item) : ?>
        						<option><?php echo $item->name ?></option>
        				<?php endforeach ?>
        			</select>
        			<div class="clearfix" style="margin-top: 10px;">
	        			<button type="button" class="btn btn-primary pull-right" style="padding: 6px 27px;">OK</button>
	        		</div>
      			</div>	      			
			</div>
		</div>
	</div>
	<script>
		$('#myModal').on('shown.bs.modal', function () {
			$('#myInput').focus();
		})
	</script>
</body>
</html>