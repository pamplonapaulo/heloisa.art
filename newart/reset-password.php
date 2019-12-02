<?php

    require '../vendor/autoload.php';
    use Mailgun\Mailgun;
    $mg = Mailgun::create(CONF_MAILGUN_KEY);
    
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />    
    <meta name="title" content="Heloisa's Watercolors" />
	
    <title>Heloisa's Watercolors</title>
    
	<link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link href="../assets/favicon.png" rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="../css/reset.css" rel="stylesheet"/>
    <link href="../css/main.css" rel="stylesheet"/>
    <link href="../css/extra.css" rel="stylesheet"/>

</head>
<body>
    
<?php

    $erro = 0;
    $valido = false;
    $login = false;

    if(isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true)
    {
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
            $dbStatus = 'Connection error: ' . $e->getMessage();
            exit();
        }

        $userEmail = $_POST['email'];

        $rs = $connection->prepare('SELECT * FROM painters WHERE email = ?');
        $rs->bindParam(1, $userEmail);

        if($rs->execute())
        {
            while($registro = $rs->fetch(PDO::FETCH_OBJ))
            {
                if($_POST['email'] == $registro->email)
                {
                    $email = true;
                    $id = $registro->id;
                }
            }
        }
    }
?>

    <header>
        <div class="header-wrapper">
                    
            <a href="../index.php">
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
                <h2>Aquarela & cia.</h2>                  
                </div>
            </div>

        </div>
    </header>
                                        
   <div class="container">
     
     <main>

        <h1>Área de acesso restrito</h1>

        <?php

        if($email != true && $_REQUEST["validar"] != true)
        {
        ?>

        <br><br><br><h2>Digite abaixo seu email cadastrado e clique no botão 'enviar'.<br><br>
        Você receberá um email com instruções para redefinir uma nova senha.</h2>

        <form class="default"  style="padding-bottom:0;" enctype="multipart/form-data" method="POST" action="?validar=true" >
            <fieldset>
                <input id="email" class="inputFiled" type="email" name="email" placeholder="Email" required />

                <input type="submit" value="Enviar"/>
            </fieldset>
        </form>

        <?php
        }

        if($email == true)
        {
            $hash = base64_encode(random_bytes(20));
            $hash = urldecode($hash);

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
                $dbStatus = 'x Connection error: ' . $e->getMessage();
                exit();
            }

            $sql = "INSERT INTO resetpass
                    (user, hash)
                    VALUES(?, ?)";

            $stmt = $connection->prepare($sql);

            $stmt->bindParam(1, $_POST['email']);
            $stmt->bindParam(2, $hash);

            $stmt->execute();

            if($stmt->errorCode() != '00000')
            {
                $valido = false;
                $erro = 'Erro: código ' . $stmt->errorCode() . ': ';
                $erro .= implode(', ', $stmt->errorInfo());
            }

            $to = $_POST['email'];

            $subject = '* * * Redefinição de Senha | Heloisa Aquarela & Cia. * * *';

            $message_body = '<html><head><title>Heloisa Aquarela & Cia</title></head>
                            <body>
                            <br>
                            <h2 style="color: rgba(0, 0, 0, 0.9);">Heloisa Aquarela & Cia</h2> 
                            <h4 style="color: rgba(0, 0, 0, 0.9);">Redefinição de senha</h4> 
                            <h4 style="color: rgba(0, 0, 0, 0.9);">Clique abaixo para definir a sua nova senha:</h4>
                            <br>
                            <a style="text-decoration: none; padding: 1.2em 1.4em; margin-top: .8em; background-color: rgba(204, 204, 204, 0.4); border: solid 1px #b2d430; color: rgba(0, 0, 0, 0.9); font-size: 1rem; font-weight: 700; letter-spacing: 1px;" target="_blank" href="https://heloisa.art/newart/new-password.php?user=' . $_POST['email'] . '&hash=' . $hash . '">DEFINIR NOVA SENHA</a>
                            <br>
                            <br>
                            </body>
                            </html>';

            $mg->messages()->send('mg.heloisa.art', [
                'from'    => 'mailgun@mg.heloisa.art',
                'to'      => $to,
                'subject' => $subject,
                'text'    => 'Testing some Mailgun awesomness!',
                'html'    => $message_body
                ]);


        }
        if($_REQUEST["validar"] == true)
        {
            echo '<div class="controls" style="width: 50%; margin: 0 auto; padding-top: 160px;"><h2 style="line-height: 3;">Caso seu email esteja nos cadastros, você receberá em breve um email<br>com as orientações para a alteração de sua senha.</h2></div>';
        }
        ?>

     </main>
       
   </div>
   
   <?php
    include('../includes/footer-admin.php');