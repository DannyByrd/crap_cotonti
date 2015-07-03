

$( document ).ready(function() {
   

 

   $('#addField').live("click",function(){

 	//var object = $('.newscat').last().clone().prependTo("p");
 	 $('input[name="header"]').clone().prependTo("p");
	 $("b").clone().prependTo("p");

   	return false;
   
   });


});
