<?php
session_start();
include_once('lang.php');
require './vendor/autoload.php';
include('includes/head.php');
?>
    
<div id="fb-root"></div>
<script async defer src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v3.2&appId=2364535097110679&autoLogAppEvents=1"></script>    
     
   <div class="container">
     
     <main>
     
        <section class="about">
        
            <div class="row">
            
               <div class="column width-100">
            
                  <h1><?php echo $about_title; ?></h1>
              
               </div>
        
            </div>
            
            <div class="row">
               
               <div class="column width-66">
                                    
                  <div class="hero-image">
                      <div class="caption">
                          <p><?php echo $about_figureCaption; ?></p>
                      </div>
                  </div>
                   
               </div>
               
               <div class="column width-33">
                  
                <article>
                
                    <p><?php echo $about_p1; ?></p>

                    <p><?php echo $about_p2; ?></p>

                    <p><?php echo $about_p3; ?></p>

                </article>
                   
               </div>
                
            </div>
                        
            <div class="row">
                               
                <div class="parallax width-100"></div>
                
            </div>
            
            <div class="row">
                
                <article class="width-33">

                    <p><?php echo $about_p4; ?></p>
                    
                </article>
                
                <article class="width-33">
                    
                    <p><?php echo $about_p5; ?></p>

                </article>
                
                <article class="width-33">

                    <p><?php echo $about_p6; ?></p>

                </article>
                                
            </div>
            
            <div class="row">
                               
                <div class="parallax width-100 row"></div>
                
            </div>
                             
            <div class="row">
                               
                <div class="fb-comments" data-href="https://paulopamplona.com/jobs/helo/about.php" data-numposts="15"></div>
                
            </div>
                             
        </section>
                        
     </main>
       
   </div>
   
   <?php
        include('includes/footer.php');
   ?>