<?php
/***************************************************************************
 CuteNews CutePHP.com
 Copyright (с) 2012 Cutenews Team
****************************************************************************/
header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

include ('core/init.php');
include ('core/loadenv.php');

if ( $using_safe_skin )
     require_once(SERVDIR."/skins/base_skin/default.skin.php");
else require_once(SERVDIR."/skins/$config_skin.skin.php");

$PHP_SELF = "index.php";

// Deprecated functional checking
deprecated_check();

// Check if CuteNews is not installed
$fp = fopen(SERVDIR."/cdata/users.db.php", 'r'); fgets($fp); $user = trim(fgets($fp)); fclose($fp);
if ($user == false)
{
    if ( !file_exists(SERVDIR."/inc/install.php"))
        die_stat(false, '<h2>Error!</h2>CuteNews detected that you do not have users in your users.db.php file and wants to run the install module.<br>
                         However, the install module (<b>./inc/install.php</b>) can not be located, please reupload this file and make sure you set
                         the proper permissions so the installation can continue.');

    require (SERVDIR."/inc/install.php");
    die();
}

hook('index_init');

b64dck();
if ($action == "logout")
{
    add_to_log( $_SESS['user'], 'logout');

    $_SESS['user'] = $_SESS['pwd'] = false;
    send_cookie(true);

    msg("info", lang("Logout"), lang("You are now logged out").", <a href=\"$PHP_SELF\">".lang('login')."</a>");
}

// sanitize
$is_loged_in = false;
if ($csrfmake == 'csrfmake')
{
    $CSRF = CSRFMake();

    if (empty($cs)) $cs = false; else $cs = intval($cs);
    header("Content-Type: text/javascript");
    send_cookie();

    echo "document.getElementById('csrf_code{$cs}').value = '{$CSRF}';";
    die();
}

// Check the User is Identified -------------------------------------------------------------------------------------
$result      = false;
$username    = empty($_POST['user']) ? $_POST['username'] : $_SESS['ix'];
$password    = $_POST['password'];

// User is banned
if ( $bandata = user_getban($ip, false))
{
     if ($bandata[1] > 4)
        msg('error', lang('Error!'), getpart('youban', format_date( $bandata[2], 'since-short')));
}

if ( empty($_SESS['user']))
{
    /* Login Authorization using COOKIES */
    if ($action == 'dologin')
    {
        // Check referer
        RereferCheck();

        // Do we have correct username and password ?
        $member_db      = user_search($username);
        $cmd5_password  = hash_generate($password);

        if ( in_array($member_db[UDB_PASS], $cmd5_password))
        {
            $_SESS['ix']    = $username;
            $_SESS['user']  = $username;

            if ($rememberme == 'yes') $_SESS['@'] = true;
            elseif (isset($_SESS['@'])) unset($_SESS['@']);

            add_to_log($username, 'login');
            user_remove_ban($ip);

            // Modify Last Login
            $member_db[UDB_LAST] = time();
            user_update($username, $member_db);

            $is_loged_in = true;
            send_cookie();
        }
        else
        {
            $_SESS['user'] = false;

            $bandata = user_addban($ip, time() + 3600);
            $result .= getpart('block_ban', $bandata[1], date('d-m-Y H:i:s', $bandata[2]) );

            add_to_log($username, lang('Wrong username/password'));
            $is_loged_in = false;
            send_cookie();
        }
    }
}
else
{
    // Check existence of user
    $member_db = user_search($_SESS['user']);
    if ($member_db)
    {
        $is_loged_in = true;
    }
    else
    {
        $_SESS['user'] = false;
        $is_loged_in = false;
        send_cookie();
    }
}

// ---------------------------------------------------------------------------------------------------------------------
// If User is Not Logged In, Display The Login Page

if (empty($is_loged_in))
{
    echoheader("user", lang("Please Login"));
    echo proc_tpl('login_window',
                  array('lastusername'  => htmlspecialchars($username) ),
                  array('ALLOW_REG'     => ($config_allow_registration == "yes")? 1:0 ) );

    echofooter();
}
elseif ($is_loged_in)
{
    // ********************************************************************************
    // Include System Module
    // ********************************************************************************

                            //name of mod   //access
    $system_modules = array('addnews'       => 'user',
                            'editnews'      => 'user',
                            'main'          => 'user',
                            'options'       => 'user',
                            'images'        => 'user',
                            'editusers'     => 'admin',
                            'editcomments'  => 'admin',
                            'tools'         => 'admin',
                            'ipban'         => 'admin',
                            'about'         => 'user',
                            'categories'    => 'admin',
                            'massactions'   => 'user',
                            'help'          => 'user',
                            'debug'         => 'admin',
                            'wizards'       => 'admin',
                            'update'        => 'user',
                            'rating'        => 'user',
                            );

    list($system_modules, $mod, $stop) = hook('system_modules_expand', array($system_modules, $mod, false));

    // Plugin tells us: don't show anything, stop
    if ($stop == false)
    {
        if ($mod == false) require(SERVDIR."/inc/main.php");
        elseif( $system_modules[$mod] )
        {
            if ($mod == 'rating')
            {
                require (SERVDIR."/inc/ratings.php");
            }
            elseif ($member_db[UDB_ACL] == ACL_LEVEL_COMMENTER and $mod != 'options' and $mod != 'update')
            {
                relocation($config_http_script_dir."/index.php?mod=options&action=personal");
            }
            elseif( $system_modules[$mod] == "user")
            {
                require (SERVDIR."/inc/".$mod.".php");
            }
            elseif( $system_modules[$mod] == "admin" and $member_db[UDB_ACL] == ACL_LEVEL_ADMIN)
            {
                require (SERVDIR."/inc/".$mod.".php");
            }
            elseif( $system_modules[$mod] == "admin" and $member_db[UDB_ACL] != ACL_LEVEL_ADMIN)
            {
                msg("error", lang("Access denied"), "Only admin can access this module");
            }
            else
            {
                die("Module access must be set to <b>user</b> or <b>admin</b>");
            }
        }
        else
        {
            add_to_log($username, 'Module '.htmlspecialchars($mod).' not valid');
            die_stat(false, htmlspecialchars($mod)." is NOT a valid module");
        }
    }
}

exec_time();