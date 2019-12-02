<?php

session_start();

include_once('lang.php');

require './vendor/autoload.php';

include_once('includes/arts-get-db.php');

include_once('includes/head-art.php');

?>

   <div class="container">
     
    <main>

        <div id="overlay">

            <?php
                include('includes/fancy-loader.php');
            ?>  
        
        </div>
               
        <article id="galleryItemContent" style="opacity:0;">

            <a href="./index.php">
                <div class="btns-wrapper">
                    <button class="close" title="<?php echo $closeBtn; ?>">
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </a>
            
            <div class="figure-wrapper-outer">
                <div class="figure-wrapper-inner">

                    <figure>                        
                        <img alt="<?= $artTitle; ?>" src="assets/obras/<?= $image; ?>" style="width: auto; height: 948px;" />
                        <figcaption><?= $artTitle; ?></figcaption>
                    </figure>

                </div>
            </div>
            
            <div class="comments-wrapper">
                <button class="quitComment"><i class="material-icons">close</i></button>
                <div class="placeholder" data-href="https://heloisa.art/arts.php?item=<?= $_GET['item'] . "&title=" . $_GET['title']; ?>" data-numposts="15"></div>
            </div>
            
            <a title="Previous" href="?item=<?= $prevItem; ?>&title=<?= $prevTitle; ?>" class="btn-swiper btn-prev <?= $prevClassDisplay; ?>"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></a>

            <a title="Next" href="?item=<?= $nextItem; ?>&title=<?= $nextTitle; ?>" class="btn-swiper btn-next <?= $nextClassDisplay; ?>"><span></span><span></span><span></span><span></span><span></span><span></span><span></span><span></span></a>
            
         </article>

    </main>

        <button title="<?= $shareBtn; ?>" class="ui facebook button fb-btn share-btn">
            <i class="material-icons">share</i>
        </button>

        <button title="<?= $commentBtn; ?>" class="fb-btn comment-btn">
            <i class="material-icons">comment</i>
        </button>

       
   </div>
   
   <script type="text/javascript" src="./js/art-page.js"></script>
   <script type="text/javascript" src="./js/mobile-swiper.js"></script>
   
</body>
</html>

