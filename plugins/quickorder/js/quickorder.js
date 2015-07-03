function sendOrder(url, data, type){
	

	if(typeof url == "undefined" || typeof data == "undefined") return false;
	$.ajax({
	  type: "POST",
	  url: url,
	  data: data+"&type="+type,
	  success: function(sdata){
	  	$('#quickorderModal .modal-body').html(sdata);
	  },
	  // dataType: dataType
	});
}

function getFormPopup(url){

	
	$.get('/' + url, function(data){
		$('#quickorderModal').remove();
		$('body').append(data);
		$('#quickorderModal')
			.on('show.bs.modal', function(){
				
				var $quickorderModal = $(this);
				$('.bn-submit', $quickorderModal).on('click', function(){
					var $bn_submit = $(this);
					var $form = $bn_submit.parent().siblings('.modal-body').find('form');
					var orderUrl =  $form.attr('action');
					
					sendOrder(orderUrl, $form.serialize(),url);
				});
		}).modal('show');
	});
}