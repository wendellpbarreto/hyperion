<?php

// Update check not for commenter
if ($action == 'check' && $member_db[UDB_ACL] != ACL_LEVEL_COMMENTER)
{
    $statext = cwget('http://cutephp.com/latest/.export.log');
    $stat    = strlen($statext);

    if ($stat && preg_match('~Exported revision (\d+)~i', $statext, $rev))
    {
        $my_current_rev = 0;
        if  (file_exists(SERVDIR.'/cdata/log/revision.php'))
            include (SERVDIR.'/cdata/log/revision.php');

        if  ($my_current_rev < $rev[1] && $my_current_rev)
             echo 'document.write("<span style=\'color: red; font-size: 15px;\'>'.lang('Build ').' '.$my_current_rev.'. Latest is '.$rev[1].' <a style=\'font-size: 18px;\' href=\"'.$PHP_SELF.'?mod=update&amp;action=update\">Update</a></span>");';
        else echo 'document.write("<span style=\'color: green; font-size: 18px;\'>'.lang('Your version is latest. Check updates in Options > Update Cutenews').'</span>");';
        die();
    }
}

// Only admin there
if ($member_db[UDB_ACL] != ACL_LEVEL_ADMIN)
    msg("error", lang("Access Denied"), lang("You don't have permission for this section"));

if ($action == 'update' )
{
    $statext = cwget('http://cutephp.com/latest/.export.log');
    $stat    = strlen($statext);

    $w = fopen(SERVDIR.'/cdata/cache/.export.log', 'w');
    fwrite($w, $statext);
    fclose($w);

    if ($stat && preg_match('~Exported revision (\d+)~i', $statext, $rev))
    {
        if (file_exists(SERVDIR.'/cdata/log/revision.php'))
             include (SERVDIR.'/cdata/log/revision.php');
        else $my_current_rev = 0;

        $uselast = ($my_current_rev == $rev[1])? 1 : 0;

        echoheader('info', lang("Update Status"), make_breadcrumbs('main/options=options/Update Status'));
        echo proc_tpl('update',
            array('rev' => $rev[1]),
            array('ALREADYLAST' => $uselast,
                  'UPIFRAME' => (($_GET['do'] == 'do_update')? 1:0))
        );

        echofooter();
    }
    else msg('error', lang('Error!'), lang('No update: Error while receiving update file'));
}
elseif ($action == 'do_update' )
{
    $statext = cwget(SERVDIR.'/cdata/cache/.export.log');
    $bundle = explode("\n", $statext);
    $proc   = intval( $_GET['proc'] );

    if ($proc >= count($bundle))
    {
        // Auto update to latest version
        include (SERVDIR.'/migrate/latest.revision.php');
        echo lang('OK! Success updated');
    }
    else
    {
        $mc  = time();
        $log = false;

        if ($proc == 0)
        {
            // Truncate the log
            fclose ( fopen(SERVDIR.'/cdata/log/update.log', 'w') );
        }

        while (time() - $mc < 15 && $proc < count($bundle))
        {
            list (,$name) = explode("A ", $bundle[$proc]);
            $name = trim($name);
            $proc++;

            if ($name == '.' || $name == false || $name == 'inc/install.php') continue;

            // Receive content
            $data = cwget("http://cutephp.com/latest/?cp=".urlencode($name));

            // Make paths
            $DEST_DIR = SERVDIR;
            $dirs = explode('/', $name);

            if (preg_match('~exported revision (\d+)~i', $bundle[$proc], $rev))
            {
                $w = fopen(SERVDIR.'/cdata/log/revision.php', 'w');
                fwrite($w, '<'.'? $my_current_rev = '.$rev[1].'; ?>');
                fclose($w);
            }
            elseif( preg_match('~\.[a-z0-9]+?$~i', $dirs[count($dirs)-1] ) )
            {
                // Make dirs...
                $w = fopen($DEST_DIR.'/'.$name, 'w');
                fwrite($w, $data);
                fclose($w);

                $log .= date('r')." Write file {$name}\n";
            }
            else
            {
                $depth = '';
                foreach ($dirs as $vd)
                {
                    $depth .= '/'.$vd;
                    if (!is_dir($DEST_DIR.$depth) && !file_exists($DEST_DIR.$depth))
                    {
                        mkdir($DEST_DIR . $depth);
                        $log .= date('r')." Make dir {$depth}\n";
                    }
                }
            }
        }

        $a = fopen(SERVDIR.'/cdata/log/update.log', 'a');
        fwrite($a, $log);
        fclose($a);

        $percent = intval( $proc / count($bundle) * 100 );

        // Redirect for continue loading
        echo ( '<html>
                <head><meta http-equiv="refresh" content="1; URL='.$config_http_script_dir.'?mod=update&action=do_update&proc='.$proc.'"></head>
                <body><script type="text/javascript">parent.document.getElementById("progress").style.width = "'.$percent.'%";</script></body>
                </html><head></head>');
        die();
    }
}