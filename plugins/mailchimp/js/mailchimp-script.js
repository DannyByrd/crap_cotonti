		var testMod;
		var not_to_send = false;
		var mi_error_mess = [];
		var mi_success_mess = [];

	function mi_show_error(){
		var classDdeterminant = '.mi-alert';

			var $el = $(classDdeterminant);
			var err_mess = '';
			var html_errs = '';
			for(i in mi_error_mess){
				html_errs += '<li>' + mi_error_mess[i] + '</li>'
			}
	
			var html = '<h4>Ошибка</h4>';
			html += '<ul>';
			html += html_errs;
			html += '</ul>';
			$el
			  .addClass('alert alert-error')
			  .html(html);
			
	}

	function mi_init(){

		$('.mi-form').each(function(){
			var $mi_form = $(this);

			if($('.mi-submit', $mi_form).length && $('.mi-email', $mi_form).length){
				if(testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' +'Submit button and email field was founded');

				var r = /^[\w\.\d-_]+@[\w\.\d-_]+\.\w{2,4}$/i;
				var $mi_email = $('.mi-email', $mi_form);		
				var $mi_submit = $('.mi-submit', $mi_form);

				if($('.mi-phone', $mi_form)){
					$mi_phone = $('.mi-phone', $mi_form);
				}

				$mi_submit.click(function(){

					if(testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' + 'Validating email ' + $mi_email.val()) + '...';

					if (!r.test($mi_email.val())){
						mi_error_mess.push(Mi.l.error_no_valid_email);
						if(testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' + 'Not falid email ' + $mi_email.val());
						not_to_send = true;
					}

					var mi_fname = '';
					var mi_phone = '';

					send_data = Mi.options.xg  + '&' + 'email=' + $mi_email.val();
					if(mi_fname = $('.mi-fname', $mi_form).val()){
						send_data += '&' + 'fname=' + $('.mi-fname', $mi_form).val();
					}

					if(mi_phone = $('.mi-phone', $mi_form).val()){
						send_data += '&' + 'phone=' + $('.mi-phone', $mi_form).val();
					}

					if(!not_to_send && testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' + 'Sending data to mailchimp account...');

					mi_show_error();

					!not_to_send &&
					 $.ajax({
						type: "POST",
						url : 'index.php?e=mailchimp',
						data : send_data,
						success : function(mess){
							if($mi_form.hasClass('mi-auto-clear')){
								$mi_email.val('');
								$('.mi-fname', $mi_form).val('');
								$('.mi-phone', $mi_form).val('');

								// if(testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' + 'Success!');
								if(testMod) console.info('[form ' +  $mi_form.attr('name') + ']: ' + 'Ajax message: ' + mess);
							}
						}
					});
					
					if($mi_form.hasClass('mi-no-submit')){
						$mi_email.focus();
						return false;
					}
				});

			} else {
				if(testMod) console.error('[form ' +  $mi_form.attr('name') + ']: ' +'not found submit button and email field');
			}

		});





	}				

$(function(){
		testMod = Mi.options.test_mode == "1" ? true : false;

				$.ajax({
					type: "POST",
					url : 'index.php?e=mailchimp',
					data : Mi.options.xg  + '&mi_action=getErrors',
					success : function(mi_error_mess){
						mi_error_mess = $.trim(mi_error_mess);
						if(mi_error_mess){
							console.error('[plugin mailchimp]: ' + mi_error_mess);
							return;
						} else {
							mi_init();
						}
					}
				});
});
