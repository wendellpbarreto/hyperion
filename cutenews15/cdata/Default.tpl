<?php
///////////////////// TEMPLATE Default /////////////////////
$template_active = <<<HTML
<div style="width:420px; margin-bottom:5px;line-height:17px;font-family:"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif;">
<div style="float:left;">{category-icon}</div>



<div style="color:#f1b44e; font-size:14px;"><b>{date}</b> </div>

<div id="news"> <font color="#624b23"> Posted by</font>   {author} </div> 


<div style="color:#d59d46; font-size:15px;"><strong>{title}</strong></div> 

<div style="color:#fff3de;text-align:justify;font-size:12px;padding:3px;">{short-story}</div>

<div style="float: right;">[edit]<img src=img/edit.png> [/edit]   [full-link]<img src=img/readmore.png>[/full-link]  [com-link]<img src=img/comment.png>[/com-link]</div>


<img src="img/sn.png" style="margin-left:0px;margin-top:5px;margin-bottom:5px;width:420px;">
</div>
HTML;


$template_full = <<<HTML
<div style="width:420px; margin-bottom:5px;line-height:17px;font-family:"Palatino Linotype","Book Antiqua",Palatino,FreeSerif,serif;">
<div style="float:left;">{category-icon}</div>



<div style="color:#f1b44e; font-size:14px;"><b>{date}</b> </div>

<div> Posted by  {author} </div> 


<div style="color:#d59d46; font-size:15px;"><strong>{title}</strong></div> 

<div style="color:#fff3de;text-align:justify;font-size:12px;padding:3px;">{full-story}</div>

<div style="float: right;"> <a href="index.php"><img src="img/goback.png"/></a></div>



</div>


HTML;


$template_comment = <<<HTML
<div style="width: 400px; margin-bottom:20px;">

<div style="border-bottom:1px solid black;"> by <strong>{author}</strong> @ {date}</div>

<div style="padding:2px; background-color:#F9F9F9">{comment}</div>

</div>
HTML;


$template_form = <<<HTML
<img src="img/sn.png" style="width:420px;margin-top:10px;margin-bottom:10px;">


<div id="comment" style="width:400px;">
<table>
<tr><td><img src="img/name.png" style="margin-bottom:2px;" /></td></tr>
<tr><td><input type="text" name="name" value="{username}"></td></tr>
<tr><td><img src="img/mail.png" style="margin-bottom:2px;" /></td></tr>
<tr><td><input type="text" name="mail"  value="{usermail}"></td></tr>
</table>




<img src="img/icons.png" style="margin-left:2px;"/> {smilies}


<textarea cols="40" rows="6" id=commentsbox name="comments"></textarea><br />

<br />

<input type="submit" name="submit" value="">

  {remember_me}

</div>


HTML;


$template_prev_next = <<<HTML
<div style="margin-left:160px;">
[prev-link]<img src=img/prev.png> [/prev-link]   [next-link] <img src=img/next.png> [/next-link] 
</div>
HTML;


$template_comments_prev_next = <<<HTML
<p align="center">[prev-link]<< Older[/prev-link] ({pages}) [next-link]Newest >>[/next-link]</p>
HTML;


?>