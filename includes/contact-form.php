
   
<div class="textPage">


    <p><?= $contact_h2_1 . ' ' . $contact_p1; ?></p>
    
    <p><?= $contact_p2; ?></p>
    
</div>
    
<div class="formWrapper">
    <form id="contact" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>" method="post">
        
    <div class="success"><?= $success ?></div>
        
        <fieldset>
            <input placeholder="<?= $contact_name; ?>" type="text" name="name" value="<?= $name ?>" tabindex="1" />
            
            <span class="error"><?= $name_error ?></span>

            <input placeholder="EMAIL" type="text" name="email" value="<?= $email ?>" tabindex="2" />                
            
            <span class="error"><?= $email_error ?></span>

        </fieldset>

        <fieldset>
            <textarea placeholder="<?= $contact_message; ?>" name="message" value="<?= $message ?>" tabindex="7"></textarea>
        </fieldset>
        
        <fieldset>
            <button name="submit" type="submit" id="contact-submit" data-submit="...Sending"><?= $contact_submit; ?></button>
        </fieldset>
    </form>
</div>    