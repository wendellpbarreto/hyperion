<h1>Template variables</h1>

<br/>
<h2 style="border-bottom: 1px solid #bbbbbb;">Active News and Full Story</h2>
<table>
    <tr> <td class="r" width="150">Template Variable</td>  <td><b>Description</b></td>  </tr>

    <tr bgcolor="#fefee0"> <td class="r" style="font-size: 16px;">Common variables</td> <td>&nbsp;</td>  </tr>
    <tr> <td class="r">{title}</td>            <td>Title of the article</td>  </tr>
    <tr> <td class="r">{avatar}</td>          <td>Show Avatar image (if any)</td>  </tr>
    <tr> <td class="r">{short-story}</td>     <td>Short story of news item</td>  </tr>
    <tr> <td class="r">{full-story}</td>      <td>The full story</td>  </tr>
    <tr> <td class="r">{author}</td>          <td>Author of the article, with link to his email (if any)</td>  </tr>
    <tr> <td class="r">{author-name}</td>     <td>The name of the author, without email</td>  </tr>
    <tr> <td class="r">{date}</td>            <td>Date when the story is written</td>  </tr>
    <tr> <td class="r">{comments-num}</td>    <td>This will display the number of comments posted for article</td>  </tr>
    <tr> <td class="r">{category}</td>        <td>Name of the category where article is posted (if any)</td>  </tr>
    <tr> <td class="r">{category-icon}</td>   <td>Shows the category icon</td>  </tr>
    <tr> <td class="r">{star-rate}</td>       <td>Rating bar</td>  </tr>

    <tr bgcolor="#fefee0"> <td class="r" style="font-size: 16px;">Wrappers</td> <td>&nbsp;</td>  </tr>
    <tr> <td class="r">[mail] ... [/mail]</td> <td>Will generate a link to the author mail (if any) eg. [mail] email [/mail]</td>  </tr>
    <tr> <td class="r">[link] and [/link]</td> <td>Will generate a permanent link to the full story</td>  </tr>
    <tr> <td class="r">[full-link] ... [/full-link]</td> <td>Link to the full story of article, only if there is full story</td>  </tr>
    <tr> <td class="r">[com-link] ... [/com-link]</td> <td>Generate link to the comments of article</td>  </tr>
    <tr> <td class="r">[edit] ... [/edit]</td>    <td>Make link to edit article at admin panel</td>  </tr>

    <tr bgcolor="#fefee0"> <td class="r" style="font-size: 16px;">System variables</td> <td>&nbsp;</td>  </tr>
    <tr> <td class="r">{index-link}</td>       <td>Link to $PHP_SELF</td>  </tr>
    <tr> <td class="r">{phpself}</td>          <td>$PHP_SELF value</td>  </tr>
    <tr> <td class="r">{back-previous}</td>    <td>Link "Go back"</td>  </tr>
    <tr> <td class="r">{cute-http-path}</td>   <td>CuteNew root path</td>  </tr>
    <tr> <td class="r">{news-id}</td>          <td>News ID</td>  </tr>
    <tr> <td class="r">{category-id}</td>      <td>Category ID</td>  </tr>
    <tr> <td class="r">{archive-id}</td>       <td>Archive ID</td>  </tr>
    <tr> <td class="r">{rss-news-include-url}</td> <td>Link to include rss</td>  </tr>
    {$More_Active_News}
</table>
<br/>
<br/>
<h2 style="border-bottom: 1px solid #bbbbbb;">Comment</h2>
<table>
    <tr> <td class="r" width="150">Template Variable</td>  <td><b>Description</b></td>  </tr>
    <tr> <td class="r">{author}</td>                <td>Name of the comment poster</td>  </tr>
    <tr> <td class="r">{mail}</td>                  <td>E-mail of the poster</td>  </tr>
    <tr> <td class="r">{date}</td>                  <td>Date when the comment was posted</td>  </tr>
    <tr> <td class="r">{comment}</td>               <td>The Comment</td>  </tr>
    <tr> <td class="r">{comment-id}</td>            <td>The Comment ID</td>  </tr>
    <tr> <td class="r">{comment-iteration}</td>     <td>Show the sequential number of individual comment</td>  </tr>
    {$More_Comments}
</table>
<br/>
<br/>
<h2 style="border-bottom: 1px solid #bbbbbb;">Add comment form</h2>
<table>
    <tr> <td class="r" width="150">Template Variable</td>  <td><b>Description</b></td>  </tr>
    <tr> <td class="r">{username}</td>      <td>If user logged, show username</td>  </tr>
    <tr> <td class="r">{usermail}</td>      <td>If user logged, show e-mail</td>  </tr>
    <tr> <td class="r">{smilies}</td>       <td>Show smiles tab</td>  </tr>
    <tr> <td class="r">{remember_me}</td>   <td>Remember form</td>  </tr>
    {$More_Comment_Form}
</table>

<br/>
<br/>
<h2 style="border-bottom: 1px solid #bbbbbb;">News and comments pagination</h2>
<table>
    <tr> <td class="r" width="150">Template Variable</td>   <td><b>Description</b></td>  </tr>
    <tr> <td class="r">[prev-link] ... [/prev-link]</td>    <td>Will generate a link to previous page (if there is)</td>  </tr>
    <tr> <td class="r">[next-link] ... [/next-link]</td>    <td>Will generate a link to next page (if there is)</td>  </tr>
    <tr> <td class="r">{pages}</td>                         <td>Shows linked numbers of the pages; example: <a href='#'>1</a> <a href='#'>2</a> <a href='#'>3</a> <a href='#'>4</a></td>  </tr>
    {$More_Com_Pages}
</table>

{$More_Sections}