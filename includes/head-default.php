<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="canonical" href="https://heloisa.art/index.php" />
	<meta property="og:locale" content="<?= $ogIdiom; ?>"/>

    <meta name="title" content="Heloisa Beatriz <?= $headline; ?>" />
	<meta name="description" content="<?= $description; ?>" />

    <meta property="og:title" content="Heloisa Beatriz <?= $headline; ?>" />
    <meta property="og:description" content="<?= $description; ?>" />
    <meta property="og:image" content="https://heloisa.art/assets/heloisa/heloisa-working.jpg" />

	<meta property="og:url" content="https://heloisa.art/index.php" />
	<meta property="og:type" content="article" />
    <meta property="og:image:alt" content="Heloisa Beatriz <?= $headline; ?>" />	
	<meta property="og:site_name" content="Heloisa Beatriz <?= $headline; ?>"/>
	<meta property="fb:app_id" content="2364535097110679" />
	
    <title>Heloisa Beatriz <?= $headline; ?></title>
    
	<link rel="icon" href="assets/favicon.png" type="image/png" />
    <link href="assets/favicon.png" rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="css/reset.css" rel="stylesheet"/>
    <link href="css/default.css" rel="stylesheet"/>

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
                      
     <header>
        <div class="header-wrapper">
          
            <a href="index.php">
                <div class="logo-btn" title="Home">

                   <div class="palette">
                   </div>

                   <div class="toe-hole">
                   </div>   

                   <div class="colors-wrapper">

                       <div class="colors color-1">
                           <div class="lightcolor"></div>
                       </div>   

                       <div class="colors color-2">
                           <div class="lightcolor"></div>
                       </div>    

                       <div class="colors color-3">
                           <div class="lightcolor"></div>
                       </div>   

                       <div class="colors color-4">
                           <div class="lightcolor"></div>
                       </div>                  

                   </div>

                   <div class="bg"></div>  

                   <div class="edge-top-bg">
                       <div class="edge-top-color"></div>
                   </div>    

                   <div class="edge-top-bg corner">
                       <div class="edge-top-color corner"></div>
                   </div>    

                </div>
            </a>
           
            <div class="headline">
               <div class="headline-wrapper">
                <h1>Heloisa Beatriz</h1>
                <h2><?= $headline; ?></h2>                  
               </div>
            </div>

            <div class="header-right">
             <div class="menu-btn-wrapper">
              <div class="menu-btn">
                 <span></span>
                 <span></span>
                 <span></span>
              </div>
             </div>
            </div>

            <nav>
                 <ul>
                   
                    <li class="idioms">
                        
                        <a title="English" href="?lang=en" class="flags langEN ">&nbsp;</a>
                        
                        <label class="switch" title="<?= $switcherTitle; ?>">
                            <input id="idiom-switcher" type="checkbox">
                            <span class="slider"></span>
                        </label>
                        
                        <a title="Português" href="?lang=pt" class="flags langPT ">&nbsp;</a>     
                        
                    </li>
                    
                    <li title="About"><a href="about.php"><?= $about; ?></a></li>
                    <li title="Portfolio"><a href="index.php"><?= $portfolio; ?></a></li>
                    <li title="Contact"><a href="contact.php"><?= $contact; ?></a></li>
                    <li class="instagram" title="Instagram">
                       <a class="social-item-link" href="https://www.instagram.com/yelloweesa/" target="_blank" >
                           <svg xmlns="http://www.w3.org/2000/svg" viewBox="-70 -150 1000 1000" class="social_icon">
                               <path fill="currentColor" d="M571 500q0-59-41-101t-101-42-101 42-42 101 42 101 101 42 101-42 41-101zm77 0q0 91-64 156t-155 64-156-64-64-156 64-156 156-64 155 64 64 156zm61-229q0 21-15 36t-37 15-36-15-15-36 15-36 36-15 37 15 15 36zM429 148H327l-54 2-57 5-40 11q-28 11-49 32t-33 49q-6 16-10 40t-6 58-1 53 0 59 0 43 0 43 0 59 1 53 6 58l10 40q12 28 33 49t49 32q16 6 40 11t57 5 54 2 59 0 43 0 42 0 59 0 54-2 58-5 39-11q28-11 50-32t32-49q6-16 10-40t6-58 1-53 0-59 0-43 0-43 0-59-1-53-6-58l-10-40q-11-28-32-49t-50-32q-16-6-39-11t-58-5-54-2-59 0-42 0zm428 352q0 128-3 177-5 116-69 180t-179 69q-50 3-177 3t-177-3q-116-6-180-69T3 677q-3-49-3-177t3-177q5-116 69-180t180-69q49-3 177-3t177 3q116 6 179 69t69 180q3 49 3 177z"></path>
                            </svg> 
                       </a>
                    </li>
                 </ul>
             </nav>  
        </div>
     </header>