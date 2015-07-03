function updateCartMini(xk){
	$.ajax({
			url: 'index.php?r=simpleorders&x=' + xk,
			type: 'post',
			data: 'action=cartmini.update',
			dataType: 'json',
			success : function(json) {
				var cart_total = parseInt(json.total);
				$('.simpleorders-mini-text').text('Корзина (' +cart_total + ')');
			}
	});
}

function showCartPopup(xk){
	if(!xk) return;

	$.ajax({
			url: 'index.php?r=simpleorders&x=' + xk,
			type: 'post',
			data: 'action=cartpopup.show',
			dataType: 'json',
			success : function(json) {
				$("body").append(json['html']);
				$('#modalCart')
					.on('hide.bs.modal', function (e) {
						saveCartPopup($('#cart-form').serialize(), xk);
					})
					.on('hidden.bs.modal', function (e) {
						$('#modalCart').remove();
						updateCartMini(xk);
					})
					.on('show.bs.modal', function (e) {
						$('#btn-add-order').click(function(){
							$('#modalCart').modal('hide');
							showOrderPopup(xk);
						});
					})
					.modal('show');
			}
	});
}

function deleteOrder(id){
	if(!id) return;

	url = 'simpleorders/?a=adminorderdel';
	$.getJSON('/' + url, {userId: id},function(data){

		$("body").append(data['html']);
		$('#modalDelOrder').modal('show');
		// установить собыите на кнопку удалить, замутить удаление и т.п.
	});

}

function saveCartPopup(cartSerilasedData, xk){
	$.ajax({
			url: 'index.php?r=simpleorders&x=' + '03c4eb8551e8ff2c',
			type: 'post',
			data: 'action=cartpopup.save&' + cartSerilasedData,
	});
}

function deleteRow(numb){
	$('#cart-row-' + numb).remove();
}


function showOrderPopup(xk){
	if(!xk) return;

	$.ajax({
			url: 'index.php?r=simpleorders&x=' + xk,
			type: 'post',
			data: 'action=orderpopup.show',
			dataType: 'json',
			success : function(json) {

				$("body").append(json['html']);
				$('#modalAddOrder')
					.on('hidden.bs.modal', function (e) {
						$('#modalAddOrder').remove();
					})
					.on('shown.bs.modal', function (e) {
						//var $addOorderForm = $('#add-order-form');

						// $('#btn-add-order').click(function(){
						// 	validateOrderPopupForm(xk); 
						// 	$addOorderForm.submit();
						// 	return false;
						// });
						// $addOorderForm.submit(function(){
						//     validateOrderPopupForm(xk); 
						// 	return false;
						// });
						
						$('button[name=btn-order]').click(function(){
							 var srz = $("#add-order-form").serialize();
      						//sendOrder2(str,xk)
      						
							$.ajax({
								url: 'index.php?r=simpleorders&x=' + xk,
								type: 'post',
								data: 'action=orderpopup.check&' + srz,
								dataType: 'json',
								success : function(json) {
									
									validate = 	true;						
									for (var key in json) {
																		
										if(json[key] != 0){
										  	validate = false;							  
										    $('input[name="formData['+key+']"]').closest('.control-group').removeClass('success').addClass('error');
										    $('#input-'+key+'-error').html(json[key]);

										}else{
											$('input[name="formData['+key+']"]').closest('.control-group').removeClass('error').addClass('success');
											 $('#input-'+key+'-error').html();
										}
										
									}//for

									if(validate){
										sendOrder2(srz,xk);
										$('#modalAddOrder').modal('hide');
									}
						
								}//success :
							});// ajax		
						});
						
					})
					.modal('show');
			}

	});
}

function validateOrderPopupForm(xk){
	$.validator.setDefaults({
		submitHandler: function() {
			var serializedData = $('#add-order-form').serialize();
			sendOrder2(serializedData, xk);
			$('#modalAddOrder').modal('hide');
			
		}
	});
	$('#add-order-form').validate({

	  	highlight: function(element) {
	  		console.log(element);
	    	$(element).closest('.control-group').removeClass('success').addClass('error');
	  	},

	  	success: function(element) {

		    element.closest('.control-group').removeClass('error').addClass('success');
		},



 	});

 	
}

function sendOrder2(serializedData, xk){

	if(!xk) return;


	$.ajax({
			url: 'index.php?r=simpleorders&x=' + xk,
			type: 'post',
			data: 'action=orderpopup.send&' + serializedData,
			dataType: 'json',
			success : function(json) {
				$("body").append(json['html']);
				$('#modalSuccess')
					.on('hidden.bs.modal', function (e) {
						$('#modalSuccess').remove();
					})
					.modal('show');
				updateCartMini(xk);
			}
	});


}

			

$(function(){
	$('form.ajax_form').submit(function(){
		$this_form = $(this);
		$.ajax({
			url: $(this).attr('action'),
			type: $(this).attr('method'),
			data: $(this).serialize(),
			dataType: 'json',
			success: function(json){
				if(json.success){
					$('.simpleorders-form-success', $this_form).html(json.success);
				}
				if(json.total){
					updateCartMini($('input[name=x]', $this_form).val());
				}
			}
		});
		return false;
	});
});


