<?php
require '../vendor/autoload.php';
session_start();

if($_SESSION['csrf_token'] != $_COOKIE['user'] || $_SESSION['csrf_token'] == null || $_COOKIE['user'] == null){

    include('../includes/head-admin-login-fail.php');
    echo '<div class="container" style="display:table;"><main style="display:table-cell;float:none;vertical-align: middle;"><h1>Realize o login novamente</h1><form><a href="./index.php"><button class="directions inactive" type="button">Login</button></a></form></main></div>';  

    exit();
}

include('../includes/head-admin.php');

$erro = 0;
$thumbErro = 0;
$valido = false;

if(isset($_REQUEST["validar"]) && $_REQUEST["validar"] == true)
{
    // validações (rever e tornar seguro):

    if(strlen(utf8_decode($_POST['title-pt'])) < 5)
    {
        $erro = 'Os campos \'título\' devem ter pelo menos 5 caracteres.';
    }
    else if(strlen(utf8_decode($_POST['title-en'])) < 5)
    {
        $erro = 'Os campos \'título\' devem ter pelo menos 5 caracteres.';
    }
    else if(strlen(utf8_decode($_POST['detail-pt'])) < 5)
    {
        $erro = 'Os campos \'detalhe\' devem ter pelo menos 5 caracteres.';
    }
    else if(strlen(utf8_decode($_POST['detail-en'])) < 5)
    {
        $erro = 'Os campos \'detalhe\' devem ter pelo menos 5 caracteres.';
    }

    if(isset($_FILES["image-file"]) && isset($_FILES["thumb-file"]))
    {
        $fileName = $_FILES["image-file"]["name"];
        $fileType = $_FILES["image-file"]["type"];
        $fileSize = $_FILES["image-file"]["size"];
        $fileTempName = $_FILES["image-file"]["tmp_name"];
        $erro = $_FILES["image-file"]["error"];

        $thumbName = $_FILES["thumb-file"]["name"];
        $thumbTempName = $_FILES["thumb-file"]["tmp_name"];
        $thumbErro = $_FILES["thumb-file"]["error"];

        if($erro == 0 && $thumbErro == 0)
        {

            if(is_uploaded_file($fileTempName) == true){
                move_uploaded_file($fileTempName, "../assets/obras/" . $fileName);
            }

            if(is_uploaded_file($thumbTempName) == true){
                move_uploaded_file($thumbTempName, "../assets/obras/thumb/" . $thumbName);
            }

            $valido = true;
            
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

            $sql = "INSERT INTO watercolors
                    (title_pt, title_en, subtitle_pt, subtitle_en, file_name, thumb_name)
                    VALUES(?, ?, ?, ?, ?, ?)";

            $stmt = $connection->prepare($sql);

            $stmt->bindParam(1, $_POST['title-pt']);
            $stmt->bindParam(2, $_POST['title-en']);
            $stmt->bindParam(3, $_POST['detail-pt']);
            $stmt->bindParam(4, $_POST['detail-en']);
            $stmt->bindParam(5, $_FILES['image-file']['name']);
            $stmt->bindParam(6, $_FILES['thumb-file']['name']);

            $stmt->execute();

            if($stmt->errorCode() != '00000')
            {
                $valido = false;
                $erro = 'Erro: código ' . $stmt->errorCode() . ': ';
                $erro .= implode(', ', $stmt->errorInfo());
            }
        }
        else
        {
            if($erro == 0 && $thumbErro != 0){

                if($thumbErro == 4){$thumbErro = 'Arquivo não selecionado.';}
                if($thumbErro == 2){$thumbErro = 'Arquivo contém mais que o limite de 2mb.';}

                $erro = "Erro no evio do thumbnail:" . $thumbErro;
            }
            else if($erro != 0 && $thumbErro == 0)
            {
                if($erro == 4){$erro = 'Arquivo não selecionado.';}
                if($erro == 2){$erro = 'Arquivo contém mais que o limite de 2mb.';}

                $erro = "Erro no evio da imagem grande:" . $erro;
            }
            else if($erro != 0 && $thumbErro != 0)
            {
                if($erro == 4){$erro = 'Arquivo não selecionado.';}
                if($erro == 2){$erro = 'Arquivo contém mais que o limite de 2mb.';}
                if($thumbErro == 4){$thumbErro = 'Arquivo não selecionado.';}
                if($thumbErro == 2){$thumbErro = 'Arquivo contém mais que o limite de 2mb.';}

                $erro = "Erro no evio das duas imagens:<br><br>Imagem normal: " . $erro . '<br><br>Thumbnail: ' . $thumbErro . '<br><br>';
            }
        }
    }
    else if(!isset($_FILES["image-file"]) && isset($_FILES["thumb-file"]))
    {
        $erro = "Arquivo da imagem não encontrado.";
    }
    else if(isset($_FILES["image-file"]) && !isset($_FILES["thumb-file"]))
    {
        $erro = "Arquivo Thumbnail não encontrado.";
    }
    else if(!isset($_FILES["image-file"]) && !isset($_FILES["thumb-file"]))
    {
        $erro = "Nenhum arquivo encontrado.";
    }
}
?>

<div class="container">
    <main>
        <h1>Gerenciador de artes</h1>
<?php   
        if($valido == true)
        {
            echo '<div class="sucesso">
                    <br><br>
                        Arte adicionada com sucesso!
                    <br>
                </div>

                <div class="controls">

                    <a href="../index.php">Home</a>

                    <a href="./form-art-upload.php">Adicionar arte</a>

                    <a href="./form-art-select.php">Remover ou editar</a>

                </div>';
        }
        else
        {
            if($erro !== 0)
            {
                echo '<h2>' . $erro . '</h2><br><br>';
            }
?>
        <form class="default" enctype="multipart/form-data" method="POST" action="?validar=true" >

            <h2>Adicionar nova obra</h2>

            <button class="directions inactive" type="button">Ajuda</button>

            <div class="advice inactive">

                <h6>1. Antes de qualquer procedimento, altere o formato da imagem pelo Photoshop para que tenha apenas <span>72 dpi de resolução</span>.</h6>
                <h6>2. Salve no Photoshop uma versão otimizada da sua nova arte, obtendo a melhor resolução possível com o mínimo de espaço em megabites. É possível simular o resultado ao salvar a imagem via <span>File > Export > Save for Web (Legacy)</span>.</h6>
                <h6>3. Para conseguir uma otimização ainda melhor, jogue o arquivo no website <a href="https://imagecompressor.com/" target="_blank">Optimizilla</a>  e baixe a versão gerada por ele. Pronto, esta será a imagem utilizada para a visualização da obra em tela cheia.</h6>
                <h6>4. Duplique o arquivo e abra a duplicação no Photoshop. Edite as dimensões da imagem para que esta tenha exatos <span>280 pixels de largura</span>, respeitando a proporção.</h6>
                <h6>5. Pronto! Agora é só preencher todos os campos abaixo.</h6>
            
            </div>

            <fieldset>

                <input id="title-pt" class="inputFiled" type="text" name="title-pt" required placeholder="Título (Português)" 
                
                    <?php
                        if(isset($_POST['title-pt']))
                        {
                            echo 'value="' . $_POST['title-pt'] . '"';
                        }
                    ?>
                />

                <input id="title-en" class="inputFiled" type="text" name="title-en" required placeholder="Título (Inglês)"
                
                    <?php
                        if(isset($_POST['title-en']))
                        {
                            echo 'value="' . $_POST['title-en'] . '"';
                        }
                    ?>
                />

                <input id="detail-pt" class="inputFiled" type="text" name="detail-pt" required placeholder="Detalhe (Português)"
                
                    <?php
                        if(isset($_POST['detail-pt']))
                        {
                            echo 'value="' . $_POST['detail-pt'] . '"';
                        }
                    ?>
                />

                <input id="detail-en" class="inputFiled" type="text" name="detail-en" required placeholder="Detalhe (Inglês)"
                
                    <?php
                        if(isset($_POST['detail-en']))
                        {
                            echo 'value="' . $_POST['detail-en'] . '"';
                        }
                    ?>
                />

                <div class="wrapper">

                    <label class="input-file-label img-file" for="add-img-btn">Selecionar imagem</label>
                    <input type="file" id="add-img-btn" class="hidden add-img-btn" name="image-file" required />

                    <label class="input-file-label thumb-file" for="add-thumb-btn">Selecionar thumbnail</label>
                    <input type="file" id="add-thumb-btn" class="hidden add-thumb-btn" name="thumb-file" required />

                </div>
                
                <div class="wrapper">

                    <input type="submit" value="Enviar"/>

                </div>              

            </fieldset>

        </form>

    <?php
        }
    ?>

    </main>

    <script type="text/javascript" src="./guide-btn.js"></script>

</div>

<?php
    include('../includes/footer-admin.php');
?>