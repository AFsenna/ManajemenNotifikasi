<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
        <tr>
            <td align="center" bgcolor="#00afb9" style="padding: 40px 0 30px 0;color: #FFFFFF; font-family: Arial, sans-serif; font-size: 24px;">
                <?php if ($type == 'verify') : ?>
                    <b>Account Verification</b>
                <?php elseif ($type == 'forgot') : ?>
                    <b>Reset Password</b>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <td bgcolor="#fdfcdc" style="padding: 40px 30px 40px 30px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" style="padding: 20px 0 30px 0;color: #293241; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                            <?php if ($type == 'verify') : ?>
                                Terima kasih telah bergabung dengan website Notifbell.</br>
                                <p>Silahkan klik tombol dibawah ini untuk mengaktifkan akun anda</p>
                                <a href="<?= base_url('Auth/verify?email=' . $email . '&token=' . $token) ?>" type="button" style="border-radius: 4px;background-color: #0081a7;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Activate</a>
                            <?php elseif ($type == 'forgot') : ?>
                                <p>Silahkan klik tombol dibawah ini untuk reset password anda!</p>
                                <a href="<?= base_url('Auth/changePassword?email=' . $email . '&token=' . $token) ?>" type="button" style="border-radius: 4px;background-color: #0081a7;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;">Reset</a>
                            <?php endif; ?>
                            <p><em style="color:#f07167;">*aktivasi ini hanya berlaku 24jam</em></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f07167" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" align="right">
                <p>Copyright ©Notifbell 2021 </p>
            </td>
        </tr>
    </table>
</body>

</html>