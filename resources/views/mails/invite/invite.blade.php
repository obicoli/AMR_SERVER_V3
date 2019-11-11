
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Internal_email-29</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <style type="text/css">
        * {
            -ms-text-size-adjust:100%;
            -webkit-text-size-adjust:none;
            -webkit-text-resize:100%;
            text-resize:100%;
        }
        a{
            outline:none;
            color:#40aceb;
            text-decoration:underline;
        }
        a:hover{text-decoration:none !important;}
        .nav a:hover{text-decoration:underline !important;}
        .title a:hover{text-decoration:underline !important;}
        .title-2 a:hover{text-decoration:underline !important;}
        .btn:hover{opacity:0.8;}
        .btn a:hover{text-decoration:none !important;}
        .btn{
            -webkit-transition:all 0.3s ease;
            -moz-transition:all 0.3s ease;
            -ms-transition:all 0.3s ease;
            transition:all 0.3s ease;
        }
        table td {border-collapse: collapse !important;}
        .ExternalClass, .ExternalClass a, .ExternalClass span, .ExternalClass b, .ExternalClass br, .ExternalClass p, .ExternalClass div{line-height:inherit;}
        @media only screen and (max-width:500px) {
            table[class="flexible"]{width:100% !important;}
            table[class="center"]{
                float:none !important;
                margin:0 auto !important;
            }
            *[class="hide"]{
                display:none !important;
                width:0 !important;
                height:0 !important;
                padding:0 !important;
                font-size:0 !important;
                line-height:0 !important;
            }
            td[class="img-flex"] img{
                width:100% !important;
                height:auto !important;
            }
            td[class="aligncenter"]{text-align:center !important;}
            th[class="flex"]{
                display:block !important;
                width:100% !important;
            }
            td[class="wrapper"]{padding:0 !important;}
            td[class="holder"]{padding:30px 15px 20px !important;}
            td[class="nav"]{
                padding:20px 0 0 !important;
                text-align:center !important;
            }
            td[class="h-auto"]{height:auto !important;}
            td[class="description"]{padding:30px 20px !important;}
            td[class="i-120"] img{
                width:120px !important;
                height:auto !important;
            }
            td[class="footer"]{padding:5px 20px 20px !important;}
            td[class="footer"] td[class="aligncenter"]{
                line-height:25px !important;
                padding:20px 0 0 !important;
            }
            tr[class="table-holder"]{
                display:table !important;
                width:100% !important;
            }
            th[class="thead"]{display:table-header-group !important; width:100% !important;}
            th[class="tfoot"]{display:table-footer-group !important; width:100% !important;}
        }
        .txt-para{
            font-weight: 400;
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color:#888;
            font-size: 14px;
            padding:0 0 23px;
            line-height: 1.4;
        }
        .ctm-title{
            color:#292c34;
            padding:0 0 24px;
            font-size: 20px;
            font-weight: 600;
            font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
        }

        .button_link {
            display: inline-block;
            font-weight: 400;
            line-height: 1.25;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            user-select: none;
            border: 1px solid transparent;
            padding: .5rem 1rem;
            font-size: 1rem;
            border-radius: .25rem;
            transition: all .2s ease-in-out;
            font-size: 14px!important;
            background-color: #d34336;
            color: #fff!important;
        }
    </style>
</head>
<body style="margin:0; padding:0;" bgcolor="#eaeced">
<table style="min-width:320px;" width="100%" cellspacing="0" cellpadding="0" bgcolor="#eaeced">
    <!-- fix for gmail -->
    <tr>
        <td class="hide">
            <table width="600" cellpadding="0" cellspacing="0" style="width:600px !important;">
                <tr>
                    <td style="min-width:600px; font-size:0; line-height:0;">&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="wrapper" style="padding:0 10px;">

            <!-- module 2 -->
            <table data-module="module-2" data-thumb="thumbnails/02.png" width="100%" style="margin-top: 20px" cellpadding="0" cellspacing="0">
                <tr>
                    <td data-bgcolor="bg-module" bgcolor="#eaeced">
                        <table class="flexible" width="600" align="center" style="margin:0 auto;" cellpadding="0" cellspacing="0">

                            <tr>
                                <td data-bgcolor="bg-block" class="holder" style="padding:58px 60px 52px;" bgcolor="#f9f9f9">
                                    <table width="100%" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td data-color="title" data-size="size title" data-min="25" data-max="45" data-link-color="link title color" data-link-style="text-decoration:none; color:#292c34;" class="title ctm-title" align="left">
                                                Hi {{$other_data['send_to']}},
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;" align="left" class="txt-para">
                                            <!-- You are receiving this email because we received a password reset request for your account. If you did not request a password reset, no further action is required. -->
                                                <p style="margin: 0;"> <strong style="text-transform: uppercase;">{{$other_data['name']}}</strong> has invited you to join <b style="text-transform: uppercase;">{{ config('settings.application.name') }}</b></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;" align="left" class="txt-para">
                                                <p style="margin: 0;">Click the "ACCEPT INVITATION" button below to accept invitation</p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td data-color="text" data-size="size text" data-min="10" data-max="26" data-link-color="link text color" data-link-style="font-weight:bold; text-decoration:underline; color:#40aceb;" align="left" class="txt-para">
                                                <a href="{{url(\Illuminate\Support\Facades\Config::get('settings.application.client').'/invitation/accept/'.$user->uuid.'/'.$other_data['uuid'])}}" class="button_link">
                                                    ACCEPT INVITATION
                                                </a>
                                            </td>
                                        </tr>

                                    </table>
                                </td>
                            </tr>
                            <tr><td height="28"></td></tr>
                        </table>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <!-- fix for gmail -->
    <tr>
        <td style="line-height:0;"><div style="display:none; white-space:nowrap; font:15px/1px courier;">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</div></td>
    </tr>
</table>
</body>
</html>