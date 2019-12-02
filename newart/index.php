<?php

    require '../vendor/autoload.php';

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
            echo "<br/><br/><h1>{$dbStatus3}</h1><br/><br/>";
            exit();
        }

        $rs = $connection->prepare('SELECT * FROM painters WHERE id = 1');

        $passwordHash = md5(CONF_DB_TOKEN . $_POST['password']);

        if($rs->execute())
        {
            while($registro = $rs->fetch(PDO::FETCH_OBJ))
            {
                if($passwordHash == $registro->senha && $_POST['email'] == $registro->email)
                {
                    $login = true;

                    session_start();

                    session_regenerate_id(true);
                    $_SESSION['csrf_token'] = base64_encode(random_bytes(20));

                    setcookie('user', $_SESSION['csrf_token'], time() + (3600));
                }
            }
        }
    }

if($login == false && isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true)
{
    $message = 'Usuário ou senha inválidos.';
}
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
                <h2 class="enlarged">Aquarela & Cia.</h2>                  
                </div>
            </div>

            <?php

            if ($login == true)
            {
                echo '<nav>
                            <ul>
                            
                            <li title="Banco de Artes"><a href="./form-art-select.php">Banco de Artes</a></li>
                            <li title="Nova Arte"><a href="./form-art-upload.php">Nova Arte</a></li>
                            
                            </ul>
                     </nav>';
            }
            ?>

        </div>
    </header>
                                        
   <div class="container">
     
     <main>

        <h1>Área de acesso restrito</h1>

        <?php echo '<br/><br/><h2>' . $message . '</h2><br/><br/>';?>

        <?php

        if($login == false)
        {
        ?>

        <form class="default"  enctype="multipart/form-data" method="POST" action="?validar=true" >
            <fieldset>
                <input id="email" class="inputFiled" type="email" name="email" placeholder="Email" />
                <input id="password" class="inputFiled" type="password" name="password" placeholder="Password" />

                <div class="wrapper-outer">
                    <div class="wrapper-inner">

                        <!-- <input id="rememberMe" type="checkbox" name="checkbox" />
                        <label for="rememberMe">Salvar senha</label> -->
                        <a href="./reset-password.php"><p>Esqueceu a senha?</p></a>

                    </div>
                </div>

                <input type="submit" value="Login"/>
            </fieldset>
        </form>

        <?php
        }
        else if ($login == true)
        {
            echo '<div class="controls">
                    <a href="./form-art-upload.php">Adicionar arte</a>
                    <a href="./form-art-select.php">Remover ou editar</a>
                </div>';        
        }
        ?>

     </main>
   </div>
   
   <?php
    include('../includes/footer-admin.php');
   ?>