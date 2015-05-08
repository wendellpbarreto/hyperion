<?php

    include('core/init.php');

    // plugin tells us: he is fork, stop
    if ( hook('fork_captcha', false) ) return;

    include(SERVDIR.'/core/captcha/captcha.php');

    $code = $_GET['pattern']? $_GET['pattern'] : 'CSW';
    $captcha = new SimpleCaptcha();

    $captcha->imageFormat   = 'png';
    $captcha->session_var   = $code;
    $captcha->scale         = 2;
    $captcha->blur          = true;
    $captcha->resourcesPath = SERVDIR.'/core/captcha/resources';

    // Image generation
    $captcha->CreateImage();
    die();