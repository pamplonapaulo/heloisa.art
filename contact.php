<?php
session_start();
include_once('lang.php');
require 'vendor/autoload.php';
use Mailgun\Mailgun;
$mg = Mailgun::create(CONF_MAILGUN_KEY);
include('includes/form_process.php');
include('includes/head.php');
?>
     
   <div class="container">
     
     <main>
     
        <section class="about contact" >
        
            <div class="row">
            
               <div class="column width-100">
            
                  <h1><?php echo $contact; ?></h1>
              
               </div>
        
            </div>
                                       
            <?php
               if ( !$success ) {
                   include("includes/contact-form.php");
               } else {
                   include("includes/sent.php");
               }
               ?>

        </section>
                       
     </main>
       
   </div>
   
   <?php
        include('includes/footer.php');
   ?>