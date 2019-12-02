<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="https://heloisa.art/arts.php?item=<?= $_GET['item']; ?>&title=<?= $_GET['title']; ?>" />
	<meta property="og:locale" content="<?= $ogIdiom; ?>"/>

    <meta name="title" content="<?= $artTitle; ?>" />
	<meta name="description" content="<?= $description; ?>" />

    <meta property="og:title" content="<?= $artTitle; ?>" />
    <meta property="og:description" content="<?= $description; ?>" />
    <meta property="og:image" content="https://heloisa.art/assets/obras/thumb/<?= $thumb; ?>" />

	<meta property="og:url" content=https://heloisa.art/arts.php?item=<?= $_GET['item']; ?>&title=<?= $_GET['title']; ?>" />
	<meta property="og:type" content="image" />
    <meta property="og:image:alt" content="<?= $artTitle . ': ' . $description; ?>" />	
	<meta property="og:site_name" content="Heloisa Beatriz <?= $headline; ?>"/>
	<meta property="fb:app_id" content="2364535097110679" />

    <title>Heloisa Beatriz <?= $headline; ?></title>
    
	<link rel="icon" href="assets/favicon.png" type="image/png" />
    <link href="./assets/favicon.png" rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="./css/reset.css" rel="stylesheet"/>
    <link href="./css/art-page.css" rel="stylesheet"/>

</head>

<body>

    <div id="fb-root"></div>
                     
    <script>
    window.fbAsyncInit = function() {
        FB.init({
        appId            : '2364535097110679',
        autoLogAppEvents : true,
        xfbml            : true,
        version          : 'v2.10'
        });
        FB.AppEvents.logPageView();
    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
                      