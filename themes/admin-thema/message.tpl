<!-- BEGIN: MAIN -->
<div class="container" style="margin-top:100px;text-align:center;">
    <div class="alert alert-danger" role="alert">
        <div class="block">
            <h2>{MESSAGE_TITLE}</h2>
            <div class="error">
                {MESSAGE_BODY}
                <!-- BEGIN: MESSAGE_CONFIRM -->
                <table class="inline" style="width:80%">
                    <tr>
                        <td><a id="confirmYes" href="{MESSAGE_CONFIRM_YES}" class="confirmButton">{PHP.L.Yes}</a></td>
                        <td><a id="confirmNo" href="{MESSAGE_CONFIRM_NO}" class="confirmButton">{PHP.L.No}</a></td>
                    </tr>
                </table>
                <!-- END: MESSAGE_CONFIRM -->
            </div>
        </div>
    </div>
</div>

<!-- END: MAIN -->