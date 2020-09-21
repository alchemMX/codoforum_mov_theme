{*
/*
* @CODOLICENSE
*/
*}
{* Smarty *}
{extends file='layout.tpl'}

{block name=body}

    <style type="text/css">

        .container {
        margin-top: 60px;
        }
    </style>


    <div class="container">

        <div class="row">

            <div id='codo_new_password_resp' class='codo_notification' style="display: none"></div>

            {"block_forgot_form_before"|load_block}  
            <div class="codo_block col-md-12">

                {"block_forgot_form_start"|load_block}  
                <div class="row">

                    <div class="col-md-6">            
                        <input class="codo_input" type="text" id="name" maxlength="60" placeholder="{_t('username or e-mail address')}" required="">
                    </div>

                </div>

                <div class='row'>

                    <div class='col-md-6'>

                        <button id='req_pass' class='codo_btn codo_btn_primary'>{_t('E-mail reset token')}</button>
                        <img id="codo_sending_mail" style="display: none" src="{$smarty.const.CURR_THEME}img/ajax-loader.gif" />
                    </div>
                </div>
                {"block_forgot_form_end"|load_block}                  
            </div>
            {"block_forgot_form_after"|load_block}  

        </div>
    </div>
    <script type="text/javascript">

        function on_codo_loaded() {

            jQuery('document').ready(function ($) {

                //keep initial focus
                $('#name').focus();

                $('input').bind('keypress', function (e) {

                    var code = e.keyCode || e.which;
                    if (code === 13) { //Enter keycode

                        $('#req_pass').trigger('click');
                    }
                });


                $('#req_pass').on('click', function () {

                    $('#codo_sending_mail').show();
                    $.getJSON(
                            codo_defs.url + 'Ajax/user/login/req_pass',
                            {
                                ident: $.trim($('#name').val()),
                                token: codo_defs.token
                            },
                    function (response) {

                        $('#codo_sending_mail').hide();
                        CODOF.util.update_response_status(response, $('#codo_new_password_resp'), true);
                    }
                    );

                });


            });
        }
    </script>

{/block}