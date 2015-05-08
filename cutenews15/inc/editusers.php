<?PHP

if ( $member_db[UDB_ACL] != ACL_LEVEL_ADMIN )
     msg("error", lang("Access Denied"), lang("You don't have permission to edit users"));

// ********************************************************************************
// List All Available Users + Show Add User Form
// ********************************************************************************
if ($action == "list")
{
    $CSRF = CSRFMake();
    echoheader ("users", lang("Manage Users"), make_breadcrumbs('main/options=options/Manage Users'));

    $i = 0;
    $userlist  = array();
    $all_users = file(SERVDIR."/cdata/users.db.php");
    unset ($all_users[0]);

    foreach ($all_users as $user_line)
    {
        $user_arr = user_decode($user_line);

        $bg = ($i++%2 == 1) ? 'bgcolor="#f7f6f4"' : false;
        $last_login = !empty($user_arr[UDB_LAST]) ? date('r', $user_arr[UDB_LAST]) : 'never';

        switch ($user_arr[1])
        {
            case 1: $user_level = "administrator"; break;
            case 2: $user_level = "editor"; break;
            case 3: $user_level = "journalist"; break;
            case 4: $user_level = "commenter"; break;
        }

        $userlist[] = array
        (
            'bg'            => $bg,
            'title'         => htmlspecialchars($user_arr[UDB_NAME]),
            'date'          => date("F, d Y @ H:i a", $user_arr[UDB_ID]),
            'user_level'    => $user_level,
            'last_login'    => $last_login,
            'count'         => intval( $user_arr[UDB_COUNT] ),
        );
    }

    echo proc_tpl('editusers');
    echofooter();
}
// ********************************************************************************
// Add User
// ********************************************************************************
elseif ($action == "adduser")
{
    CSRFCheck();

    if (!empty($userdel))
    {
        foreach ($userdel as $uid => $perm)
        {
            // Except myself
            if ($member_db[UDB_NAME] != $uid) user_delete($uid);
        }
        msg('info', lang('User(s) deleted'), lang('The user(s) was successfully deleted'), "#GOBACK");
    }

    if (!$regusername)
        msg("error", lang('Error!'), lang("Username can not be blank"), "#GOBACK");

    if (!$regpassword)
        msg("error", lang('Error!'), lang("Password can not be blank"), "#GOBACK");

    if (!preg_match('/^[\.A-z0-9_\-]+[@][A-z0-9_\-]+([.][A-z0-9_\-]+)+[A-z]{1,4}$/', $regemail))
        msg("error", lang('Error!'), lang("Not valid Email"), "#GOBACK");

    $all_users = file(SERVDIR."/cdata/users.db.php");
    unset ($all_users[0]);

    foreach ($all_users as $user_line)
    {
        $user_arr = user_decode($user_line);
        if ($user_arr[UDB_NAME]  == $regusername)
        {
            msg("error", lang('Error!'), lang("User with this username already exist"), "#GOBACK");
        }
        /* // @TODO Check registration email
        elseif ($user_arr[UDB_EMAIL]  == $regemail)
        {
            msg("error", lang('Error!'), lang("User with this email already exist"), "#GOBACK");
        }
        */
    }

    $add_time = time() + ($config_date_adjust*60);

    // Generate best password
    $ht = hash_generate($regpassword);
    $regpassword = $ht[ count($ht)-1 ];

    switch ($reglevel)
    {
        case "1": $level = "administrator"; break;
        case "2": $level = "editor"; break;
        case "3": $level = "journalist"; break;
        case "4": $level = "commenter"; break;
    }

    user_add(array(UDB_ID => $add_time, $reglevel, $regusername, $regpassword, $regnickname, $regemail, 0, 0));

    msg("info", lang("User Added"),
                str_replace(array('%1', '%2'), array($regusername, $level), lang("The user <b>%1</b> was successfully added as <b>%2</b>")),
                '#GOBACK');
}
// ********************************************************************************
// Edit User Details
// ********************************************************************************
elseif ($action == "edituser")
{
    $CSRF = CSRFMake();
    if ( false === ($user_arr = user_search($id)) )
         die( lang('User not exist') );

    $edit_level = array
    (
        array('id' => ACL_LEVEL_COMMENTER,  's' => false, 'type' => 'commenter'),
        array('id' => ACL_LEVEL_JOURNALIST, 's' => false, 'type' => 'journalist'),
        array('id' => ACL_LEVEL_EDITOR,     's' => false, 'type' => 'editor'),
        array('id' => ACL_LEVEL_ADMIN,      's' => false, 'type' => 'administrator'),
    );

    if ( isset($edit_level[ 4 - $user_arr[UDB_ACL] ]['id']) )
         $edit_level[ 4 - $user_arr[UDB_ACL] ]['s'] = 'selected';

    echo proc_tpl
    (
        'editusers.user',
        array
        (
            'CSRF'          => $CSRF,
            'user_arr[2]'   => $user_arr[2],
            'user_arr[4]'   => $user_arr[4],
            'user_arr[5]'   => $user_arr[4],
            'user_arr[6]'   => $user_arr[6],
            'user_date'     => date("r", $user_arr[0]),
            'edit_level'    => $edit_level,
            'last_login'    => empty($user_arr[UDB_LAST]) ? lang('never') : date('r', $user_arr[UDB_LAST]),
            'id'            => $id,
        )
    );

}
// ********************************************************************************
// Do Edit User
// ********************************************************************************
elseif ($action == "doedituser")
{
    CSRFCheck();

    if (empty($id))
         msg('error', lang("This is not a valid user"), '#GOBACK');

    if ( false === ($the_user = user_search($id)) )
         msg('error', lang("This is not a valid user"), '#GOBACK');

    // Change password if present
    if (!empty($editpassword))
    {
        $hmet = hash_generate($editpassword);
        $the_user[UDB_PASS] = $hmet[ count($hmet)-1 ];
        if ($id == $_SESS['user']) $_SESS['pwd'] = $editpassword;
        send_cookie();
    }

    // Change user level anywhere
    $the_user[UDB_ACL] = $editlevel;
    user_update($id, $the_user);

    echo proc_tpl('editusers/doedituser/saved');

}

?>
