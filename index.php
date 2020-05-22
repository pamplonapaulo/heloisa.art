<?php

session_start();
include_once('lang.php');
require './vendor/autoload.php';
include('includes/head-default.php');

?>                                                              
   <div class="container">
     <main>
        <section class="gallery">
           <div id="overlay" style="">

                <?php
                    include('includes/fancy-loader.php');
                ?>  

           </div>
<?php

    try
    {
        $connection = new PDO(
                'mysql:host=' . CONF_DB_HOST . ';dbname=' . CONF_DB_NAME,
                CONF_DB_USER,
                CONF_DB_PASS
        );

        $connection->exec('set names utf8');
    }
    catch(PDOException $e)
    {
        echo 'Falha: ' . $e->getMessage();
        exit();
    }

    // (result set)
    $rs = $connection->prepare('SELECT * FROM watercolors ORDER BY id DESC LIMIT 999');

    if($rs->execute())
    {

        while($registro = $rs->fetch(PDO::FETCH_OBJ))
        {

            if($_SESSION['lang'] =='en')
            {
                $artTitle = $registro->title_en;
                $artSubtitle = $registro->subtitle_en;
            }
            else
            {
                $artTitle = $registro->title_pt;
                $artSubtitle = $registro->subtitle_pt;
            }

            $urlTitle = tailorMadeSanitize($registro->title_en);

            echo "<div class=\"item\" data-link=\"./arts.php?item=" . $registro->id . "&title={$urlTitle}\">
                
                <h1 class=\"bug-test\">{$artTitle}</h1>

                <div>

                    <figure>

                        <img src=\"assets/obras/thumb/" . $registro->thumb_name . "\" alt=\"{$artTitle}\" data-index=\"" . $registro->id . "\">

                        <figcaption>{$artSubtitle}</figcaption>

                    </figure>

                </div>
            </div>";
        }
    }
    else
    {
        echo '<br/>Falha no carregamento das aquarelas.<br/>';
    }

?>
            </section>                  
        </main>
   </div>
<?php
include('includes/footer.php');
?>