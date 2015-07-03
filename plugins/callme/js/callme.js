 $(function() {
 
    $callmeModal = $('#callmeModal');

    $('input[name=plg_callme_link_page]').val(window.location.href);

    function onShowModal_v3x(){
        $callmeModal.on('shown.bs.modal', function (e) {
            $(".bn-submit", $callmeModal).click(function(){
                var form_data = $('form#callme-form').serialize();
                form_data += '&plg_callme_page_link=' + encodeURIComponent(window.location.href);
                $.ajax({
                    type: "POST",
                    url: Callme.options.url,
                    data: form_data,
                    success: function(msg){
                            $(".modal-body", $callmeModal).html(msg);
                    },
                    error: function(){
                        alert("failure");
                    }
                });
            });
         });
    }

    function onShowModal_v2x_recursivFnc(){
            $(".bn-submit", $callmeModal).click(function(){
            var form_data = $('form#callme-form').serialize();
            form_data += '&plg_callme_page_link=' + encodeURIComponent(window.location.href);
            $.ajax({
                type: "POST",
                url: Callme.options.url,
                data: form_data,
                success: function(msg){
                        $(".modal-content", $callmeModal).html(msg);
                        onShowModal_v2x_recursivFnc();
                },
                error: function(){
                    alert("failure");
                }
            });
        });
    }

    function onShowModal_v2x(){
        $callmeModal.on('shown.bs.modal', function (e) {
            onShowModal_v2x_recursivFnc();
         });
    }
    

    switch(Callme.options.bootstrap_version_support){
        case '2.x' : onShowModal_v2x();
         break;

        default: onShowModal_v3x();
         break;
    }
});