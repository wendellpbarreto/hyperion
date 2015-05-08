<?PHP

include ('core/init.php');
include ('core/loadenv.php');

require_once(SERVDIR.'/skins/'.$config_skin.'.skin.php');

// plugin tells us: he is fork, stop
if ( hook('fork_register', false) ) return;

// Check if CuteNews is not installed
$fp = fopen(SERVDIR."/cdata/users.db.php", 'r'); fgets($fp); $user = trim(fgets($fp)); fclose($fp);

if ($user == false)
{
    if ( !file_exists(SERVDIR."/inc/install.php"))
        die_stat(false, '<h2>Error!</h2>CuteNews detected that you do not have users in your users.db.php file and wants to run the install module.<br>However, the install module (<b>./inc/install.php</b>) can not be located, please reupload this file and make sure you set the proper permissions so the installation can continue.');

    require (SERVDIR."/inc/install.php");
    die();
}

$register_level = $config_registration_level;
$user_arr       = user_search($user);

// sanitize
if ($action == "doregister")
{

    if ($config_allow_registration != "yes")     msg("error", lang('Error!'), "User registration is Disabled", '#GOBACK');
    if (!$regusername)                           msg("error", lang('Error!'), "Username can not be blank", '#GOBACK');
    if (!$regpassword)                           msg("error", lang('Error!'), "Password can not be blank", '#GOBACK');
    if (!$regemail)                              msg("error", lang('Error!'), "Email can not be blank", '#GOBACK');
    if ($confirm != $regpassword)                msg("error", lang('Error!'), "Confirm password don't match", '#GOBACK');
    if (!$captcha || $captcha != $_SESS['CSW'])  msg("error", lang('Error!'), "Captcha code not valid", '#GOBACK');

    $_SESS['CSW'] = mt_rand().mt_rand();

    $regusername    = preg_replace( '/[\|<>\s]/', '', $regusername);
    $regnickname    = preg_replace( '/[\|<>\s]/', '', $regnickname);
    $regemail       = preg_replace( '/[\|<>\s]/', '', $regemail);
    $regpassword    = preg_replace( '/[\|<>\s]/', '', $regpassword);

    // ----------------------------------------
    if ($user_arr)
        msg("error", lang('Error!'), lang("This username is already taken"), '#GOBACK');

    if (!preg_match('/^[\.A-z0-9_\-]{1,15}$/i', $regusername))
        msg("error", lang('Error!'), $regusername." ".lang("Your username must only contain valid characters, numbers and the symbol '_'"), '#GOBACK');

    elseif($regnickname && !preg_match('/^[\.A-z0-9_\-]{1,15}$/i', $regnickname))
        msg("error", lang('Error!'), lang("Your nickname must only contain valid characters, numbers and the symbol '_'"), '#GOBACK');

    elseif(!preg_match('/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/', $regemail))
        msg("error", lang('Error!'), lang("Not valid Email"), '#GOBACK');

    elseif(!preg_match('/^[\.A-z0-9_\-]{1,15}$/i', $regpassword))
        msg("error", lang('Error!'), lang("Your password must contain only valid characters and numbers"), '#GOBACK');

    $add_time = time() + $config_date_adjust*60;

    // select best method
    $hmet = hash_generate($regpassword);
    $regpassword = $hmet[ count($hmet)-1 ];

    // add to database
    user_add( array(UDB_ID => $add_time, $register_level, $regusername, $regpassword, $regnickname, $regemail, 0, 0 ));

    // send email
    if ($config_notify_registration == "yes" and $config_notify_status == "active")
        send_mail(  $config_notify_email,
                    lang("CuteNews - New User Registered"),
                    "New user ($regusername) has just registered:\nUsername: $regusername\nNickname: $regnickname\nEmail: $regemail\n ");

    add_to_log ($regusername, lang('Register user'));
    msg("user", lang("User Added"), lang("You were successfully added to users database.<br>You can now login <a href=index.php>here</a>"));
}
elseif($action == "lostpass")
{

    echoheader("user", lang("Lost Password"));
    echo proc_tpl('register/lost');
    echofooter();

}
elseif ($action == "validate")
{
    if (!$user || empty($email))
        msg("error", lang('Error!'), lang("All the fields are required"), '#GOBACK');

    // Check user and correct email
    if ($user_arr && $user_arr[UDB_EMAIL] == $email)
    {
        // Do Send Password
        $confirm_url = $config_http_script_dir."/register.php?a=dsp&s=".urlencode($sstring);
        $message = lang("Hi,\n Someone requested your password to be changed, if this is the desired action and you want to change your password please follow this link").": $confirm_url .";
        send_mail($email, lang("Confirmation ( New Password for CuteNews )"), $message);
        msg('info', lang('Confirmation Email'), lang("A confirmation email was sent, please check your inbox for further details."), '#GOBACK');
    }
    else
    {
        msg("error", lang('Error!'), lang("The username/email you enter did not match in our users database"), '#GOBACK');
    }
}
elseif ($a == "dsp")
{
    if ($s == false) msg("error", lang('Error!'), "All fields are required", '#GOBACK');
    list($user) = explode('@', xxtea_decrypt( base64_decode($s), CRYPT_SALT ));

    if (!$user)
    {
        msg("error", lang('Error!'), lang("invalid string"), '#GOBACK');
    }
    else
    {
        srand((double)microtime()*1000000);
        $salt = "abcdefghjkmnpqrstuvwxyz0123456789_-ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        for($i = 0; $i < 9; $i++) $new_pass .= $salt[rand(0, strlen($salt)-1)];

        // Save new password
        $hmet               = hash_generate($new_pass);
        $user_arr[UDB_PASS] = $hmet[ count($hmet)-1 ];
        user_update($user, $user_arr);
        
        $message = str_replace(array('%1','%2'), array($user, $new_pass), lang("Hi %1,\n Your new password for CuteNews is %2, please after you login change this password."));
        send_mail($user_arr[5], lang("Your New Password for CuteNews"), $message);

        add_to_log ($user, lang('New password received'));
        msg("info", lang("Password Sent"), str_replace('%1', $user, lang("The new password for <b>%1</b> was sent to the email.")), '#GOBACK');
    }
}
else
{
    if ($config_allow_registration != "yes")
        msg("error", lang('Error!'), lang("User registration is Disabled"), '#GOBACK');

    echoheader("user", lang("User Registration"));
    echo proc_tpl('register/reg', array('result' => $result));
    echofooter();
}

exec_time();
?>