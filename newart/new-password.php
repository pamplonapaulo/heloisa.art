<?php
    require '../vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />    
    <meta name="title" content="Heloisa's Watercolors" />
	
    <title>Heloisa's Watercolors | Password Reset</title>
    
	<link rel="icon" href="../assets/favicon.png" type="image/png" />
    <link href="../assets/favicon.png" rel="icon" type="image/x-icon" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">    
    <link href="../css/reset.css" rel="stylesheet"/>
    <link href="../css/main.css" rel="stylesheet"/>
    <link href="../css/extra.css" rel="stylesheet"/>

</head>
<body>

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

<?php

    if(isset($_GET['user']) && isset($_GET['hash']) && $_REQUEST["validar"] != true)
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

        $userEmail = $_GET['user'];

        $rs = $connection->prepare('SELECT * FROM resetpass');

        if($rs->execute())
        {
            while($registro = $rs->fetch(PDO::FETCH_OBJ))
            {

                if(urlencode($_GET['hash']) == urlencode($registro->hash) && $_GET['user'] == $registro->user)
                {
                    $userChecked = true;
                }
            }
        }
    }
?>
                                        
   <div class="container">
     
     <main>

        <?php

        if($userChecked == true && $_REQUEST["validar"] != true)
        {
        ?>

        <h1>Redefinição de senha</h1>

        <br><br><br><h2>Digite a nova senha no campo abaixo. Confirme-a no segundo campo e clique no botão 'Salvar'.</h2>

        <form class="default"  style="padding-bottom:0;" enctype="multipart/form-data" method="POST" action="?validar=true" >
            <fieldset>

                <label for="first-typed">Insira a nova senha:</label><br/><br/>
                <input id="first-typed" class="inputFiled" type="password" name="first-typed" placeholder="Nova senha" required />

                <label for="second-typed">Confirme a nova senha:</label><br/><br/>
                <input id="second-typed" class="inputFiled" type="password" name="second-typed" placeholder="Confirmação de nova senha" required />

                <input id="email" class="inputFiled" type="hidden" name="email" value="<?= $userEmail ?>" required />

                <input type="submit" value="Salvar"/>

            </fieldset>
        </form>

        <?php
        }

        if($_REQUEST["validar"] == true && isset($_POST["email"]) && $_POST['first-typed'] != $_POST['second-typed'])
        {
            ?>

            <h1>Redefinição de senha</h1>

            <h1>Erro de digitação na confirmação da nova senha!</h1>
    
            <br><br><br><h2>Tente novamente e certifique-se de que digitou corretamente em ambos os campos.</h2>
    
            <form class="default"  style="padding-bottom:0;" enctype="multipart/form-data" method="POST" action="?validar=true" >
                <fieldset>
    
                    <label for="first-typed">Insira a nova senha:</label>
                    <input id="first-typed" class="inputFiled" type="password" name="first-typed" placeholder="Nova senha" required />
    
                    <label for="second-typed">Confirme a nova senha:</label>
                    <input id="second-typed" class="inputFiled" type="password" name="second-typed" placeholder="Confirmação de nova senha" required />
    
                    <input id="email" class="inputFiled" type="hidden" name="email" value="<?= $userEmail ?>" required />
    
                    <input type="submit" value="Salvar"/>
    
                </fieldset>
            </form>
    
            <?php
        }

        if($_REQUEST["validar"] == true && isset($_POST["email"]) && $_POST['first-typed'] == $_POST['second-typed'])
        {

            $passwordHash = md5(CONF_DB_TOKEN . $_POST['first-typed']);
            $email = $_POST['email'];

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

            $sql = "UPDATE painters SET senha = ? WHERE email = ?";
            $stmt = $connection->prepare($sql);

            $stmt->bindParam(1, $passwordHash);
            $stmt->bindParam(2, $email);

            $stmt->execute();

            if($stmt->errorCode() != '00000')
            {
                $valido = false;
                $erro = 'Erro código ' . $stmt->errorCode() . ': ';
                $erro .= implode(', ', $stmt->errorInfo());

                echo "<h1>Erro!</h1><br/><br/><h2>{$erro}</h2><br/><br/><br/><div class=\"controls\"><a href=\"./reset-password.php\">Tentar novamente</a></div>"; 
            }
            else
            {
                $valido = true;
                echo "<br/><br/><h1>Senha redefinida com sucesso!</h1>" . "<h2>Para proceguir, realize o login.</h2><br/><div class=\"controls\"><a href=\"./index.php\">Login</a></div>"; 
            }    
            $clearResetChances = true;
        }

        if($clearResetChances == true)
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
                $dbStatus = 'x Connection error: ' . $e->getMessage();
                exit();
            }

            $sql = "DELETE FROM resetpass WHERE user = ?";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(1, $email); 
            $stmt->execute();

            if($stmt->errorCode() != '00000')
            {
                $valido = false;
                $erro = 'Erro: código ' . $stmt->errorCode() . ': ';
                $erro .= implode(', ', $stmt->errorInfo());

                echo $erro;
            }
        }
        ?>

     </main>
       
   </div>
   
   <?php
    include('../includes/footer-admin.php');