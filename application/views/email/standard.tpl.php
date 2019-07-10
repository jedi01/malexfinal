<html>
    <body dir="<?php echo (lang("IS_RTL"))?"rtl":"ltr" ?>">
        <center>
        <table style="width:580px;font-family:'Roboto','Helvetica','Arial',sans-serif!important;color:#edf0f7;text-align:center;" border="0" cellpadding="0" cellspacing="0">
            <tr>
                <td style="margin:0;padding:15px;background:#111520;text-align: center;">
                    <img src="<?php echo base_url(COMPANY_LOGO) ?>" alt="<?php echo COMPANY_NAME ?>" style="height: 80px" />
                    <h4 style="font-weight:200;padding-top:15px;margin:0px;font-size: 24px;"><?php echo COMPANY_NAME ?></h4>
                </td>
            </tr>
            <tr>
                <td style="background:#fff;width:100%;color:#262e42;border-bottom: 1px solid gray;">
                    <div style="padding:50px 60px 60px 60px;font-size:16px;line-height:1.4em;">
                        <?php echo $email_content ?>
                    </div>
                </td>
            </tr>
            <?php if (isset($show_email_caution) || isset($show_automatic)): ?>
            <tr>
                <td>
                    <div style="padding:15px 13px;color:#262e42;">
                        <?php if (isset($show_email_caution)): ?>
                        <p style="font-size:14px;font-weight:300;line-height:1.4em;margin:0;padding:0;">
                            <?php echo lang("email_caution") ?>
                        </p>
                        <br />
                        <a style="text-decoration:none!important;font-weight:bold;" href="mailto:<?php echo COMPANY_EMAIL ?>" target="_blank"><?php echo COMPANY_EMAIL ?></a>
                        <hr style="background-color:#e8eaef;border:none;height:1px;margin:40px auto 10px;width:100%" />
                        <?php endif ?>
                        <p style="font-size:12px;font-weight:300;line-height:1.4em;margin:0;padding:0;">
                            <?php echo lang("email_automatic") ?>
                        </p>
                    </div>
                </td>
            </tr>
            <?php endif ?>
            <tr>
                <td style="margin:0;padding:10px 5px;background:#111520;font-size:10px;">
                    <?php echo sprintf(lang("email_copyright"), date("Y"), COMPANY_NAME) ?>
                </td>
            </tr>
        </table>
        </center>
    </body>
</html>
