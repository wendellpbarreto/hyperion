<div style="clear: both; margin: 0 8px 0 0">

    <h2 style="font-size: 20px; margin: 16px 0 0 0;">System self-check</h2>
    <div style="color: gray; margin: 0 0 8px 0;"><span style="color: green;">Green</span> color - all right, <span style="color: red;">Red</span> - error</div>
    <hr style="border: none; border-bottom: 1px dashed gray;"/>
    {SHOW}
        <div style="color: red; font-size: 16px;">Some files have the permissions error</div>

        <div style="margin: 16px 0 32px 16px;">

            <h3 style="font-family: 'Trebuchet MS', serif; font-size: 14px; margin: 0;">File exists?</h3>
            {foreach from=exists}<div style="border-bottom: 1px dashed #80E0C0;"><div style="clear: left; float: left; width: 580px; color: {$exists.1}">{$exists.0}</div><div style="text-align: right;">{$exists.2}</div></div>{/foreach}

        </div>

        <div style="margin: 16px 0 32px 16px;">

            <h3 style="font-family: 'Trebuchet MS', serif; font-size: 14px; margin: 0;">Readable status</h3>
            {foreach from=r}<div style="border-bottom: 1px dashed #80E0C0;"><div style="clear: left; float: left; width: 580px; color: {$r.1}">{$r.0}</div><div style="text-align: right;">{$r.2}</div></div>{/foreach}

        </div>

        <div style="margin: 16px 0 32px 16px;">

            <h3 style="font-family: 'Trebuchet MS', serif; font-size: 14px; margin: 0;">Execution status</h3>
            {foreach from=x}<div style="border-bottom: 1px dashed #80E0C0;"><div style="clear: left; float: left; width: 580px; color: {$x.1}">{$x.0}</div><div style="text-align: right;">{$x.2}</div></div>{/foreach}

        </div>

        <div style="margin: 16px 0 32px 16px;">

            <h3 style="font-family: 'Trebuchet MS', serif; font-size: 14px; margin: 0;">Writable status</h3>
            {foreach from=w}<div style="border-bottom: 1px dashed #80C0C0;"><div style="clear: left; float: left; width: 580px; color: {$w.1}">{$w.0}</div><div style="text-align: right;">{$w.2}</div></div>{/foreach}

        </div>

        <hr style="border: none; border-bottom: 1px dashed gray;"/>
    {/SHOW}
    {-SHOW}
        <div style="color: green; font-size: 16px;">All permissions are correct</div>
    {/-SHOW}

    <div style="margin: 16px 0 32px 0;">

        <h3 style="font-size: 14px; margin: 0;">Common information</h3>
        {foreach from=fs}<div class="hover" style="border-bottom: 1px dashed #80C0C0; padding: 3px 0 3px 0;"><div style="clear: left; float: left;">{$fs.0}</div><div style="text-align: right;">{$fs.1}</div></div>{/foreach}

        {FREE}
        <div style="margin: 16px 0 0 0; float: left; width: 745px; height: 20px; border: 1px solid gray;"><div style="float: left; width: {$free}%; background: #0080FF; height: 16px; color: white; text-align: center; padding: 2px;">Used {$free}%</div></div>
        <div style="clear: left;"></div>
        {/FREE}

    </div>

</div>

<p><a href="example1.php" target="blank">Example 1</a>
   &middot; <a href="example2.php" target="blank">Example 2</a>
   &middot; <a href="{$config_http_script_dir}/README.html">Readme</a>
</p>