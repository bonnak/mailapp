$(function(){
	$('#mail-list-modal #btn-choose-mail-list').on('click', function(){

		var mail_modal = $(this).parents('#mail-list-modal'),
			mailing_list = $('#mail-list-modal').find('#mailing-list').val(),
			txt_send_to = $('#frm-send-mail').find('#txt-send-to'),

			str_mail_list = '';

		// Concate mailing lists into a string.
		$.each(mailing_list, function (key, value) {			
			str_mail_list +=  ';' + value 
		});

		// Remove semicolon between string.
		str_mail_list = str_mail_list.replace(/^;+|;+$/gm,'');

		// Set email list string into the send-to input box.
		$(txt_send_to).val(str_mail_list);

		// Close dialogue box.
		$(mail_modal).modal('hide');
	});

	/****
	 * Remove inform box after show message up.
	 */
	$('.inform-box').on('animationend', function(){ $(this).remove(); });
	$('.inform-box').on('webkitAnimationEnd', function(){ $(this).remove(); });

});