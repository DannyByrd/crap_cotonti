$(function(){


   
  var mc_url =  'http://palmirastudio-com/mailchimp/list-PalmiraStudio.php'

    if($('.mc-form').length){
        $('.mc-form').each(function(index, this_form){

            var $this_form = $(this_form);
            var $this_submit = $('.mc-submit',$this_form);

            if($this_submit.length){
                $this_submit.click(function(){
                    
                    var $this_email = $('.mc-email',$this_form);
                    var mc_email = $this_email.val();
                    
                    if(mc_email){
                       
                        var mc_fname = $('.mc-fname',$this_form).val() || '';
                        var mc_lname = $('.mc-lname',$this_form).val() || '';
                       
                        $.ajax({
                          type: "POST",
                          url: mc_url,
                          data: 'email=' + mc_email + '&fname=' + mc_fname + '&lname=' + mc_lname,
                         // cache: false,
                          dataType: 'json',
                          success: function(data){
                          
                          res = data.success;
                          if(res){
                           
                            $('#responseAjax').html('Ваш email успешно добавлен');
                          }else{

                            res = data.error;
                            // шаблон
                            var regV = /portion of the email address is invalid/gi;     
                            var result = res.match(regV);
                            
                          

                            if(result){
                              $('#responseAjax').html('Ошибка! '+'Не корректно введеный email');
                            }
                             else if(res =='An email address must contain a single @'){
                               $('#responseAjax').html('Ошибка! '+ 'email адресс должен содержать символ @ и доменное имя');
                             }
                       
                             else if(res.indexOf('There is no record of the email address')+1){
                               $('#responseAjax').html('Ошибка! '+'Нету записи адреса электронной почты в вашем аккаунте');
                             }
                             else{
                              $('#responseAjax').html('Ошибка на стороне сервера ');
                             }

                            
                          }

                          }
                          
                        });
                    }
                    return false;
                });
            }
        });
    }
    
});
