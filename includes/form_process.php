<?php 

// define variables and set to empty values
$name_error = $email_error = "";
$name = $email = $message = $success = "";


//form is submitted with POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["name"])) {
    $name_error = $lang_name_required;
  } else {
    $name = test_input($_POST["name"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
      $name_error = $lang_name_error;
    }
  }

  if (empty($_POST["email"])) {
    $email_error = $lang_email_required;
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email_error = $lang_email_error; 
    }
  }
  
  if (empty($_POST["message"])) {
    $message = "";
  } else {
    $message = test_input($_POST["message"]);
  }
  
  if ($name_error == '' and $email_error == '' and $phone_error == '' and $url_error == '' ){
      $message_body = '';

      unset($_POST['submit']);
      foreach ($_POST as $key => $value){
          $message_body .=  "$key: $value\n";
      }
      
      $to = 'yelloweesa@gmail.com';

      $subject = '* * * Contato | Heloisa Aquarela & Cia. * * *';

      $message_body = '<html><head><title>Heloisa Aquarela & Cia</title></head>
      <body>
      <h2 style="color: rgba(0, 0, 0, 0.9);">Heloisa Aquarela & Cia | CONTATO</h2>
      <h4 style="color: rgba(0, 0, 0, 0.9);">Alguém visitou o website e acaba de enviar uma mensagem pelo formulário:</h4><br/> 
      
      <h3 style="color: rgba(0, 0, 0, 0.9);">Nome: ' . $_POST['name'] . '</h3><br/>
      <h3 style="color: rgba(0, 0, 0, 0.9);">Email: ' . $_POST['email'] . '</h3><br/>
      <h3 style="color: rgba(0, 0, 0, 0.9);">Mensagem: ' . $_POST['message'] . '</h3><br/>
      <br/>
      <br/>
      </body>
      </html>';

      $mg->messages()->send('mg.heloisa.art', [
        'from'    => 'mailgun@mg.heloisa.art',
        'to'      => $to,
        'subject' => $subject,
        'text'    => 'Testing some Mailgun awesomness!',
        'html'    => $message_body
        ]);

      $success = $lang_success;
      $name = $email = $message = '';
  }
}