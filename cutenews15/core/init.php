<?php

    /* Check PHP Version */
    if ( substr(PHP_VERSION, 0, 5) < '4.0.3') die('PHP Version is '.PHP_VERSION.', need great than PHP &gt;= 4.0.3 for start cutenews');

    // Remove simple error
    error_reporting(E_ALL ^ E_NOTICE);

    // DEFINITIONS
    define('EXEC_TIME',               microtime(true));

    // BASE SETTINGS
    define('VERSION',                 '1.5.0');
    define('VERSION_ID',              188);

    define('SERVDIR',                 dirname(dirname(__FILE__).'.html'));
    define('CACHE',                   '/cdata/cache');
    define('SKINS',                   '/skins');

    // DEBUG
    define('STORE_ERRORS',            true);

    // CRYPT SETTINGS
    define('HASH_METHOD',             'sha256'); // hash_algos()

    // ACL: base level
    define('ACL_LEVEL_ADMIN',         1);
    define('ACL_LEVEL_EDITOR',        2);
    define('ACL_LEVEL_JOURNALIST',    3);
    define('ACL_LEVEL_COMMENTER',     4);

    // Define user.db.php column
    define('UDB_ID',                  0); // add time
    define('UDB_ACL',                 1); // acl = 1,2,3,4
    define('UDB_NAME',                2); // username
    define('UDB_PASS',                3); // password (md5, sha-256, etc)
    define('UDB_NICK',                4); // nickname
    define('UDB_EMAIL',               5); // email
    define('UDB_COUNT',               6); // count of written news
    define('UDB_CBYEMAIL',            7); // user wants to hide his e-mail
    define('UDB_AVATAR',              8); // default avatar user for write news
    define('UDB_LAST',                9); // last login timestamp
    define('UDB_RESERVED1',           10);
    define('UDB_RESERVED2',           11);
    define('UDB_RESERVED3',           12);

    // Define news.db.php columns
    define('NEW_ID',                  0);
    define('NEW_USER',                1);
    define('NEW_TITLE',               2);
    define('NEW_SHORT',               3);
    define('NEW_FULL',                4);
    define('NEW_AVATAR',              5);
    define('NEW_CAT',                 6);
    define('NEW_RATE',                7); // rating function
    define('NEW_MF',                  8); // more fields
    define('NEW_OPT',                 9); // optins

    // define cats
    define('CAT_ID',                  0);
    define('CAT_NAME',                1);
    define('CAT_ICON',                2);
    define('CAT_PERM',                3);

    // define comments
    define('COM_ID',                  0);
    define('COM_USER',                1);
    define('COM_MAIL',                2);
    define('COM_IP',                  3);
    define('COM_TEXT',                4);

    // -----------------------------------------------------------------------------------------------------------------

    // include necessary libs
    include_once (SERVDIR.'/core/core.php');

    // catch errors
    set_error_handler("user_error_handler", E_ALL);

    // Off magic_quotes
    ini_set ('magic_quotes_gpc', 0);

    // configuration files
    if (file_exists(SERVDIR.'/cdata/config.php'))
        include_once (SERVDIR.'/cdata/config.php');

    if (function_exists('date_default_timezone_set'))
        date_default_timezone_set( empty($config_timezone)?  'Europe/London' : $config_timezone );

    // embedded code no send codes
    if (empty($NotHeaders) && $config_useutf8 == '1')
    {
        header('Content-Type: text/html; charset=UTF-8', true);
        header('Accept-Charset: UTF-8', true);
    }

    // loading plugins
    $_HOOKS = array();
    if (is_dir(SERVDIR.'/cdata/plugins'))
    foreach (read_dir(SERVDIR.'/cdata/plugins', array(), false) as $plugin)
        if (preg_match('~\.php$~i', $plugin)) include (SERVDIR . $plugin);

    // load config
    if (file_exists(SERVDIR . CACHE.'/conf.php'))
         $cfg = unserialize( str_replace("<?php die(); ?>\n", '', implode('', file ( SERVDIR . CACHE.'/conf.php' ))) );
    else $cfg = array();

    // initialize mod_rewrite if present
    if  ($config_use_replacement && file_exists(SERVDIR.'/cdata/conf_rw.php'))
         include ( SERVDIR.'/cdata/conf_rw.php' );
    else $config_use_replacement = 0;

    // check skin if exists
    $config_skin = preg_replace('~[^a-z]~i','', $config_skin);
    if (!isset($config_skin) or !$config_skin or !file_exists(SERVDIR."/skins/$config_skin.skin.php"))
    {
        $using_safe_skin = true;
        $config_skin = 'default';
    }

    // Detect My IP and check it
    if (isset($HTTP_X_FORWARDED_FOR)) $ip = $HTTP_X_FORWARDED_FOR;
    elseif (isset($HTTP_CLIENT_IP))   $ip = $HTTP_CLIENT_IP;
    if (empty($ip))                   $ip = $_SERVER['REMOTE_ADDR'];
    if (empty($ip))                   $ip = false;

    if ( !preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $ip) )
         $ip = false;

    // use default, hooked or cfg skin
    if ( $SKIN = hook('change_skin') )
         define('SKIN',         $SKIN);
    else define('SKIN',         SKINS.'/'.(isset($cfg['skin'])? $cfg['skin'] : 'base_skin'));

    // Definity PHPSELF
    if ( !isset($PHP_SELF) && empty($PHP_SELF) )
         define('PHP_SELF', $_SERVER["PHP_SELF"]);
    else define('PHP_SELF', $PHP_SELF);

    // CRYPT_SALT consist an IP?
    define('CRYPT_SALT',        ($config_ipauth == '1'? $ip : false).'@'.$cfg['crypt_salt']);

    // experimental defines
    define('RATEY_SYMBOL',      empty($config_ratey) ? '*' : str_replace('&amp;', '&', $config_ratey) ); // &#9734;
    define('RATEN_SYMBOL',      empty($config_raten) ? '&ndash;' : str_replace('&amp;', '&', $config_raten) ); // &#9733;

    // SERVER values make
    $_SERVER["HTTP_ACCEPT"]             = isset($_SERVER["HTTP_ACCEPT"])?           $_SERVER["HTTP_ACCEPT"] : false;
    $_SERVER["HTTP_ACCEPT_CHARSET"]     = isset($_SERVER["HTTP_ACCEPT_CHARSET"])?   $_SERVER["HTTP_ACCEPT_CHARSET"] : false;
    $_SERVER["HTTP_ACCEPT_ENCODING"]    = isset($_SERVER["HTTP_ACCEPT_ENCODING"])?  $_SERVER["HTTP_ACCEPT_ENCODING"] : false;
    $_SERVER["HTTP_CONNECTION"]         = isset($_SERVER["HTTP_CONNECTION"])?       $_SERVER["HTTP_CONNECTION"] : false;

    // Cookies
    if (isset($_COOKIE['session']) && $_COOKIE['session'])
    {
        $xb64d = xxtea_decrypt( base64_decode($_COOKIE['session']), CRYPT_SALT );
        if ($xb64d) $_SESS = unserialize( $xb64d ); else $_SESS = array();
    }
    else $_SESS = array();

    // create cache
    $_CACHE = array();

    // save cfg file
    $cfg = hook('init_modify_cfg', $cfg);

    $fx = fopen(SERVDIR.'/cdata/cache/conf.php', 'w');
    fwrite($fx, "<?php die(); ?>\n" . serialize($cfg) );
    fclose($fx);

    if (empty($config_utf8html))
    {
        //----------------------------------
        // Html Special Chars
        //----------------------------------
        $HTML_SPECIAL_CHARS = Array
        (
            '”' => '&rdquo;',  '“' => '&ldquo;',  'œ' => '&oelig;',  '™' => '&trade;',
            '’' => '&rsquo;',  '‘' => '&lsquo;',  '‰' => '&permil;', '…' => '&hellip;',
            '€' => '&euro;',   '¡' => '&iexcl;',  '¢' => '&cent;',   '£' => '&pound;',
            '¤' => '&curren;', '¥' => '&yen;',    '¦' => '&brvbar;', '§' => '&sect;',
            '¨' => '&uml;',    '©' => '&copy;',   'ª' => '&ordf;',   '«' => '&laquo;',
            '»' => '&raquo;',  '¬' => '&not;',    '®' => '&reg;',    '¯' => '&macr;',
            '°' => '&deg;',    'º' => '&ordm;',   '±' => '&plusmn;', '¹' => '&sup1;',
            '²' => '&sup2;',   '³' => '&sup3;',   '´' => '&acute;',  '·' => '&middot;',
            '¸' => '&cedil;',  '¼' => '&frac14;', '½' => '&frac12;', '¾' => '&frac34;',
            '¿' => '&iquest;', 'À' => '&Agrave;', 'Á' => '&Aacute;', 'Â' => '&Acirc;',
            'Ã' => '&Atilde;', 'Ä' => '&Auml;',   'Å' => '&Aring;',  'Æ' => '&AElig;',
            'Ç' => '&Ccedil;', 'È' => '&Egrave;', 'É' => '&Eacute;', 'Ê' => '&Ecirc;',
            'Ë' => '&Euml;',   'Ì' => '&Igrave;', 'Í' => '&Iacute;', 'Î' => '&Icirc;',
            'Ï' => '&Iuml;',   'Ð' => '&ETH;',    'Ñ' => '&Ntilde;', 'Ò' => '&Ograve;',
            'Ó' => '&Oacute;', 'Ô' => '&Ocirc;',  'Õ' => '&Otilde;', 'Ö' => '&Ouml;',
            '×' => '&times;',  'Ø' => '&Oslash;', 'Ù' => '&Ugrave;', 'Ú' => '&Uacute;',
            'Û' => '&Ucirc;',  'Ü' => '&Uuml;',   'Ý' => '&Yacute;', 'Þ' => '&THORN;',
            'ß' => '&szlig;',  'à' => '&agrave;', 'á' => '&aacute;', 'â' => '&acirc;',
            'ã' => '&atilde;', 'ä' => '&auml;',   'å' => '&aring;',  'æ' => '&aelig;',
            'ç' => '&ccedil;', 'è' => '&egrave;', 'é' => '&eacute;', 'ê' => '&ecirc;',
            'ë' => '&euml;',   'ì' => '&igrave;', 'í' => '&iacute;', 'î' => '&icirc;',
            'ï' => '&iuml;',   'ð' => '&eth;',    'ñ' => '&ntilde;', 'ò' => '&ograve;',
            'ó' => '&oacute;', 'ô' => '&ocirc;',  'õ' => '&otilde;', 'ö' => '&ouml;',
            '÷' => '&divide;', 'ø' => '&oslash;', 'ù' => '&ugrave;', 'ú' => '&uacute;',
            'û' => '&ucirc;',  'ü' => '&uuml;',   'ý' => '&yacute;', 'þ' => '&thorn;',
            'ÿ' => '&yuml;',   'Œ' => '&OElig;',  'Š' => '&Scaron;', 'š' => '&scaron;',
            'Ÿ' => '&Yuml;',   'ˆ' => '&circ;',   '˜' => '&tilde;',  '–' => '&ndash;',
            '—' => '&mdash;',  '†' => '&dagger;', '‡' => '&Dagger;', '‹' => '&lsaquo;',
            '›' => '&rsaquo;', 'ƒ' => '&fnof;',   'Α' => '&Alpha;',  'Β' => '&Beta;',
            'Γ' => '&Gamma;',  'Δ' => '&Delta;',  'Ε' => '&Epsilon;','Ζ' => '&Zeta;',
            'Η' => '&Eta;',    'Θ' => '&Theta;',  'Ι' => '&Iota;',   'Κ' => '&Kappa;',
            'Λ' => '&Lambda;', 'Μ' => '&Mu;',     'Ν' => '&Nu;',     'Ξ' => '&Xi;',
            'Ο' => '&Omicron;','Π' => '&Pi;',     'Ρ' => '&Rho;',    'Σ' => '&Sigma;',
            'Τ' => '&Tau;',    'Υ' => '&Upsilon;','Φ' => '&Phi;',    'Χ' => '&Chi;',
            'Ψ' => '&Psi;',    'Ω' => '&Omega;',  'α' => '&alpha;',  'β' => '&beta;',
            'γ' => '&gamma;',  'δ' => '&delta;',  'ε' => '&epsilon;','ζ' => '&zeta;',
            'η' => '&eta;',    'θ' => '&theta;',  'ι' => '&iota;',   'κ' => '&kappa;',
            'λ' => '&lambda;', 'μ' => '&mu;',     'ν' => '&nu;',     'ξ' => '&xi;',
            'ο' => '&omicron;','π' => '&pi;',     'ρ' => '&rho;',    'ς' => '&sigmaf;',
            'σ' => '&sigma;',  'τ' => '&tau;',    'υ' => '&upsilon;','φ' => '&phi;',
            'χ' => '&chi;',    'ψ' => '&psi;',    'ω' => '&omega;',  'ϑ' => '&thetasym;',
            'ϒ' => '&upsih;',  'ϖ' => '&piv;',    '′' => '&prime;',  '″' => '&Prime;',
            '‾' => '&oline;',  '℘' => '&weierp;', 'ℑ' => '&image;', 'ℜ' => '&real;',
            'ℵ' => '&alefsym;','←' => '&larr;',   '↑' => '&uarr;',   '→' => '&rarr;',
            '↓' => '&darr;',   '↔' => '&harr;',   '↵' => '&crarr;', '⇐' => '&lArr;',
            '⇑' => '&uArr;',   '⇒' => '&rArr;',  '⇓' => '&dArr;',  '⇔' => '&hArr;',
            '∀' => '&forall;', '∂' => '&part;',  '∃' => '&exist;', '∅' => '&empty;',
            '∇' => '&nabla;',  '∈' => '&isin;',  '∉' => '&notin;', '∋' => '&ni;',
            '∏' => '&prod;',   '∑' => '&sum;',    '−' => '&minus;', '∗' => '&lowast;',
            '√' => '&radic;',  '∝' => '&prop;',  '∞' => '&infin;',  '∠' => '&ang;',
            '∧' => '&and;',    '∨' => '&or;',    '∩' => '&cap;',    '∪' => '&cup;',
            '∫' => '&int;',    '∴' => '&there4;', '∼' => '&sim;',   '≅' => '&cong;',
            '≈' => '&asymp;',  '≠' => '&ne;',     '≡' => '&equiv;',  '≤' => '&le;',
            '≥' => '&ge;',     '⊂' => '&sub;',    '⊃' => '&sup;',   '⊄' => '&nsub;',
            '⊆' => '&sube;',   '⊇' => '&supe;',   '⊕' => '&oplus;', '⊗' => '&otimes;',
            '⊥' => '&perp;',   '⋅' => '&sdot;',   '⌈' => '&lceil;',  '⌉' => '&rceil;',
            '⌊' => '&lfloor;',  '⌋' => '&rfloor;', '⟨' => '&lang;',   '⟩' => '&rang;',
            '◊' => '&loz;',     '♠' => '&spades;', '♣' => '&clubs;', '♥' => '&hearts;',
            '♦' => '&diams;',
        );
    }
    else $HTML_SPECIAL_CHARS = array();

    hook('init_header_after');

?>