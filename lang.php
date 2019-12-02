<?php

if(isset($_GET['lang']) && $_GET['lang']=='pt'){
    unset($_SESSION['lang']);
    $_SESSION['lang']=true;
    $_SESSION['lang']='pt';
}

if(isset($_GET['lang']) && $_GET['lang']=='en'){
    unset($_SESSION['lang']);
    $_SESSION['lang']=true;
    $_SESSION['lang']='en';
}

if(!isset($_GET['lang']) && !isset($_SESSION['lang'])){
    include_once('lang/pt.php');
}

if(isset($_SESSION['lang']) && $_SESSION['lang']=='pt'){
    include_once('lang/pt.php');
}

if(isset($_SESSION['lang']) && $_SESSION['lang']=='en'){
    include_once('lang/en.php');
}

?>