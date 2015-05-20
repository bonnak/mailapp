$(function(){
	$('#mail-list-modal #btn-choose-mail-list').on('click', function(){

		var mail_modal = $(this).parents('#mail-list-modal'),
			cbo_mailing_list = $('#mail-list-modal').find('#mailing-list'),
			txt_send_to = $('#frm-send-mail').find('#txt-send-to'),

			mailing_list = $(cbo_mailing_list).val(),
			str_mail_list = $(txt_send_to).val();

		// Concate mailing lists into a string.
		$.each(mailing_list, function (key, value) {			
			str_mail_list +=  ',' + value 
		});

		// Remove semicolon between string.
		str_mail_list = str_mail_list.replace(/^,+|,+$/gm,'');

		// Set email list string into the send-to input box.
		$(txt_send_to).val(str_mail_list);

		// Close dialogue box.
		$(mail_modal).modal('hide');

		// Clear selected value.
		$(cbo_mailing_list).val('');
	});

	/****
	 * Remove inform box after show message up.
	 */
	$('.inform-box').on('animationend', function(){ $(this).remove(); });
	$('.inform-box').on('webkitAnimationEnd', function(){ $(this).remove(); });


	/****
	 * 
	 */
	$('#frm-send-mail #btn-send').on('click', function(e){
		var form = $(this).parents('form'),
			log = {
				input_mail	: $(form).find('#txt-send-to').val(),
				input_sub	: $(form).find('#txt-subject').val(),
				input_msg	: $(form).find('#txt-msg').val()
			},
			error_string = '';

		// Prevent automatic submitting form.
		e.preventDefault();

		// Get error string.
		error_string += log.input_mail.trim() === '' ? 'Email cannot be empty\n' : '';
		error_string += log.input_sub.trim() === '' ? 'Subject cannot be empty\n' : '';
		error_string += log.input_msg.trim() === '' ? 'Message cannot be empty\n' : '';

		// Check if there are error, then alert error.
		if(error_string !== ''){
			alert(error_string);
			return;
		};

		// If nothing error, it will submit form and start sending mail.
		$(form).submit();
	});

});