<!doctype html>
<html lang="pt-BR">
<head>
        <meta charset="UTF-8">
        <meta name="robots" content="index,follow">
        <meta name="viewport" content="initial-scale=1.0 maximum-scale=1.0 user-scalable=no">  
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>L2 Hyperion</title>

        <link rel="stylesheet" href="assets/styles/main.css">

        <link rel="stylesheet" href="assets/fonts/felix titling/font.css">
        <link rel="stylesheet" href="assets/fonts/tex gyre pagella/font.css">

        <link rel="Stylesheet" type="text/css" href="new.css" />
        <link rel="Stylesheet" type="text/css" href="menudol.css" />
        <link rel="Stylesheet" type="text/css" href="login.css" />
        <link rel="shortcut icon" href="img/favicon.png"/>

        <script  type="text/javascript">
            function scroll() {
                window.scrollTo(130, 0)
            }
        </script>

        <script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
    </head>

    <body>
        <div id="wrap">
            <div id="all">
                <div id="menu">
                    <?php include "menu.php" ?>
                </div>
            </div>
            
            <div class="hero">
                <img class="hero__logo" src="assets/images/logo.png" alt="Hyperion">
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="1613" height="431" class="swf" id="FlashID" title="">
                    <param name="movie" value="fames.SWF" />
                    <param name="quality" value="high" />
                    <param name="wmode" value="opaque" />
                    <param name="swfversion" value="8.0.35.0" />
                    <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
                    <param name="expressinstall" value="Scripts/expressInstall.swf" />
                    <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
                    <!--[if !IE]>-->
                    <object type="application/x-shockwave-flash" data="fames.SWF" width="1613" height="431">
                        <!--<![endif]-->
                        <param name="quality" value="high" />
                        <param name="wmode" value="opaque" />
                        <param name="swfversion" value="8.0.35.0" />
                        <param name="expressinstall" value="Scripts/expressInstall.swf" />
                        <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->

                        <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                        <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" width="112" height="33" /></a></p>

                        <!--[if !IE]>-->
                    </object>
                    <!--<![endif]-->
                </object>
            </div>

            <script type="text/javascript">
                swfobject.registerObject("FlashID");
            </script>

            <div id="main-content">
                <table border="0" cellpadding="0" cellspacing="0">
                    <tr valign="top">
                        <td width="340">
                            <section id="leftbox">
                                <?php #include('login.php'); ?>
                                <?php #include('serverstatus.php'); ?>
                                <a href="http://www.gameborder.net/file/lineage-ii-interlude-client#.VTsL7JOkPIU" target="_blank" class="leftbox__download-interlude-client-direct-button"><img src="assets/images/button@interlude_client_direct.png" alt="Direct Download Interlude Client"></a>
                                <a href="https://thepiratebay.se/torrent/5332437/Lineage_2_Interlude_C6_Client" target="_blank" class="leftbox__download-interlude-client-torrent-button"><img src="assets/images/button@interlude_client_torrent.png" alt="Torrent Download Interlude Client"></a>
                                <a href="#" class="leftbox__download-patch-button"><img src="assets/images/button@download-patch.png" alt="Download L2 Hyperion PATCH"></a>
                            </section>
                        </td>
                        <td width="733"> 
                            <section id="rightbox">
                                <div class="rightbox__container">
                                    <div class="rightbox__left">
                                        <h2 class="text__title">
                                            Bem-vindo, estrangeiro.
                                            <br>
                                            Sinta-se em casa!
                                        </h2>
                                        <div class="text__box">
                                            <p>É com grande orgulho que damos boas vindas aos nossos players. O Hyperion é um servidor de Lineage II na expansão Interlude C6. E nós o criamos com o único objetivo de trazer entretenimento e diversão pra vocês.</p>

                                            <p>Se você ainda não faz parte do nosso império, não perca tempo, baixe o cliente interlude usando o link direto <a href="http://www.gameborder.net/file/lineage-ii-interlude-client#.VTsL7JOkPIU" target="_blank">Interlude Client</a> ou o link para torrent <a href="https://thepiratebay.se/torrent/5332437/Lineage_2_Interlude_C6_Client" target="_blank">Torrent Interlude Client</a> (só precisa baixar de um dos links) e então baixe o <a href="#">patch L2 Hyperion</a>. As contas são AUTO-CREATED, então não precisa se cadastrar, só abrir o jogo e aproveitar (:</p>
                                            
                                            <p>Caso surja alguma dúvida, dica ou reclamação, use o email <a href="mailto:someone@example.com?Subject=Hello%20again" target="_top">suporte@l2hyperion.com</a> para entrar em contato conosco.</p>
                                        </div>
                                    </div>
                                    <div class="rightbox__right">
                                        <h2 class="text__title">Notícias</h2>
                                        <div class="news">
                                            <div class="text__date">
                                                <span class="day">09</span>/05/2015
                                            </div>
                                            <div class="text__subtitle">
                                                Inaugurado!
                                            </div>
                                            <div class="text__box">
                                                <p>O grande dia chegou e os portões foram abertos. Venham todos, isto é Hyperion!</p>
                                            </div>
                                        </div>
                                        <hr class="divider">
                                        <div class="news">
                                            <div class="text__date">
                                                <span class="day">07</span>/05/2015
                                            </div>
                                            <div class="text__subtitle">
                                                Proteções adicionadas
                                            </div>
                                            <div class="text__box">
                                                <p>Foram adicionadas proteções contra l2W, l2PHX, tower e etc, e foi dado um upgrade no servidor com o intuito de melhor satisfazer aos nossos players. Enjoy it!</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </td>
                    </tr>
                </table>
            </div>

            <div id="footer">
                <div id="menudol">
                    <?php include('menudol.php'); ?>
                </div>
                <div style="margin-left:800px;padding-top:30px;">
                    <?php include('footer.php'); ?>
                </div>
                <div id="footerdeco"></div>
            </div>

        </div>
    </body>
</html>

