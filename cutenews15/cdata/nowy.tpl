<?php
///////////////////// TEMPLATE nowy /////////////////////
$template_active = <<<HTML
<div style="width:420px; margin-bottom:30px;">
<div><strong>{title}</strong> {star-rate}</div>

<div style="text-align:justify; padding:3px; margin-top:3px; margin-bottom:5px; border-top:1px solid #D3D3D3;">{short-story}</div>

<div style="float: right;">[edit]Edit[/edit] [full-link]Read more[/full-link] | [com-link]{comments-num} Comments[/com-link]</div>

<div><em>Posted on {date} by {author}</em></div>
</div>
HTML;


$template_full = <<<HTML

HTML;


$template_comment = <<<HTML

HTML;


$template_form = <<<HTML

HTML;


$template_prev_next = <<<HTML

HTML;


$template_comments_prev_next = <<<HTML

HTML;


?>