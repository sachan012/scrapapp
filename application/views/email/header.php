<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="x-apple-disable-message-reformatting">
    <title></title>
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
    <style>
        .bg_white {
            background: #ffffff;
        }
        .navigation {
            padding: 0;
            padding: 1em 0;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
        }
        .section-footer {
            background-image: url(<?php echo base_url();?>assets/img/footer-bg.png);
            background-repeat: no-repeat;
            background-size: cover;
            background-position: right;
            width: 100%;
        }
        .section-footer p.copyright {
            color: #fff;
        }
        .section-footer p.copyright a {
            color: #fff;

        }
    </style>
</head>
<body style="margin:0; padding:0; background:#eee">
<center style="width: 100%;background-color: #f1f1f1;">
    <div style="max-width: 600px; margin: 0 auto;" class="email-container">
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%"
               style="margin: auto;">
            <tbody>
            <tr>
                <td valign="top" class="bg_white" style="padding: 1em 2.5em 0 2.5em;">
                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                        <tr>
                            <td class="logo" style="text-align: center;">
                                <!--<img src="<?php echo base_url(); ?>assets/uploads/logo/3e369c2d0d76c2365ced7af7e47fa014.png">-->
                                <div class="navigation"></div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td valign="middle" class="hero hero-2 bg_white" style="padding: 2em 0 4em 0;">
                    <table>
                        <tbody>
                        <tr>
                            <td>
                                <div class="text" style="padding: 0 2.5em; text-align: left;">
                                    <?php echo $msg_body; ?>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
        <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%" style="margin: auto;">
            <tbody>
            <tr class="section-footer">
                <td style="text-align:center">
                    <p class="copyright">©2021 All Right Reserved. <a href="javascript:void();">Privacy Policy
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</center>
</body>
</html>