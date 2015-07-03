function sendEmail(id){

	var userId = $("#whatpay_"+id+" #whatpay_userid_"+id+"").html();
	var userEmail = $("#whatpay_"+id+" #whatpay_useremail_"+id+"").html();
	var userDate = $("#whatpay_"+id+" #whatpay_userdate_"+id+"").html();
	var userDesc = $("#whatpay_"+id+" #whatpay_userdesc_"+id+"").html();
	var userComm = $("#whatpay_"+id+" #whatpay_usercomm_"+id+"").val();
	var userPrice = $("#whatpay_"+id+" #whatpay_userprice_"+id+"").html();
	var c_url = $('#c_url').html();

	url = 'whatpay/?a=sendemail';
	$.get('/' + url, {pay_id:userId,email:userEmail,date:userDate,desc: userDesc,
		comm:userComm, price: userPrice},function(data){
	
		alert(data);
	});

	
	
}

$( "form" ).submit(function( event ) {
	
 	var code = $('#userCode').val();
 	url = 'whatpay/?a=getcode';
	$.get('/' + url, {userCode: code},function(data){
	
		var obj = jQuery.parseJSON(data);
		if(obj.wpay_comment == 0){
			text = 'Не верно введен код';
		}else if(obj.wpay_comment == 'false'){

			text = 'Поле код не может быть пустым';
		}else{
			text = obj.wpay_comment;
		}
		$('#admin_comment').show();
		$('#admin_comment').val(text);
		
	});


	
 	return false;
});



