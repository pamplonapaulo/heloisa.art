<?php
require '../vendor/autoload.php';
session_start();

if($_SESSION['csrf_token'] != $_COOKIE['user'] || $_SESSION['csrf_token'] == null || $_COOKIE['user'] == null){

    include('../includes/head-admin-login-fail.php');
    echo '<div class="container" style="display:table;"><main style="display:table-cell;float:none;vertical-align: middle;"><h1>Realize o login novamente</h1><form><a href="./index.php"><button class="directions inactive" type="button">Login</button></a></form></main></div>';  

    exit();
}

include('../includes/head-admin.php');

$erro = null;
$valido = false;

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
    else
    {
        $valido = true;
                
        $sql = 'UPDATE watercolors SET
                title_pt = ?,
                title_en = ?,
                subtitle_pt = ?,
                subtitle_en = ?
                WHERE id = ?';

        $stmt = $connection->prepare($sql);
        $stmt->bindParam(1, $_POST['title-pt']);
        $stmt->bindParam(2, $_POST['title-en']);
        $stmt->bindParam(3, $_POST['detail-pt']);
        $stmt->bindParam(4, $_POST['detail-en']);
        $stmt->bindParam(5, $_POST['id']);

        $stmt->execute();

        if($stmt->errorCode() != '00000')
        {
            $valido = false;
            $erro = 'Erro código ' . $stmt->errorCode() . ': ';
            $erro .= implode(', ', $stmt->errorInfo());
        }        
    }      
}
// se o arquivo não tiver o atributo 'validar', assume-se que é para permitir a alteração.
else
{
    $rs = $connection->prepare('SELECT * FROM watercolors WHERE id = ?');
    $rs->bindParam(1, $_REQUEST['id']);
    
    if($rs->execute())
    {
        if($registro = $rs->fetch(PDO::FETCH_OBJ))
        {
            $_POST['title-pt'] = $registro->title_pt;
            $_POST['title-en'] = $registro->title_en;
            $_POST['detail-pt'] = $registro->subtitle_pt;
            $_POST['detail-en'] = $registro->subtitle_en;
            $_POST['file-name'] = $registro->file_name;
            $_POST['thumb-name'] = $registro->thumb_name;
        }
        else
        {
            $erro = 'Arte não encontrada.';
        }
    }
    else
    {
        $erro = 'Falha na captura da arte.';
    }
}

?>
    <div class="container">
        <main>
            <h1>Gerenciador de artes</h1>
            <br>
            <h2>Alteração de dados</h2>
            <br>
<?php  
    if($valido == true)
    {
        echo '<h2>Dados alterados com sucesso!</h2>
              <br><br>
              <div class="controls">
                  <a href="../index.php">Home</a>
                  <a href="./form-art-upload.php">Adicionar arte</a>
                  <a href="./form-art-select.php">Remover ou editar</a>
              </div>';
    }
    else
    {    
        if(isset($erro))
        {
            echo   '<h2>Erro!</h2>
                    <br><br>
                    <h2>' . $erro . '</h2>
                    <br>';

        }    
?>
            <form id="art-changes" method="POST" action="?validar=true">
                <table>
                    <tr>
                        <th>&nbsp</th>
                        <th>Título<br>(Português)</th>
                        <th>Título<br>(Inglês)</th>
                        <th>Detalhe<br>(Português)</th>
                        <th>Detalhe<br>(Inglês)</th>
                        <th>Arquivo<br>Imagem</th>
                        <th>Arquivo<br>Thumbnail</th>
                        <th>&nbsp</th>
                    </tr>

                    <tr class="edition">
                        <td><img src="../assets/obras/thumb/<?php if(isset($_POST['thumb-name'])) { echo $_POST['thumb-name'] ; } ?>" /></td>
                        <td><input type="text" name="title-pt" <?php if(isset($_POST['title-pt'])) { echo 'value="' . $_POST['title-pt']. '"'; } ?> /></td>
                        <td><input type="text" name="title-en" <?php if(isset($_POST['title-en'])) { echo 'value="' . $_POST['title-en']. '"'; } ?> /></td>
                        <td><input type="text" name="detail-pt" <?php if(isset($_POST['detail-pt'])) { echo 'value="' . $_POST['detail-pt']. '"'; } ?> /></td>
                        <td><input type="text" name="detail-en" <?php if(isset($_POST['detail-en'])) { echo 'value="' . $_POST['detail-en']. '"'; } ?> /></td>

                        <td><p><?php if(isset($_POST['file-name'])) { echo $_POST['file-name'] ; } ?></p></td>
                        <td><p><?php if(isset($_POST['thumb-name'])) { echo $_POST['thumb-name'] ; } ?></p></td>

                        <td><a href="javascript:{}" onclick="document.getElementById('art-changes').submit();" title="GRAVAR <?php echo $registro->title_pt ?>"><i class="material-icons">save</i></a></td>
                    </tr>
    
                </table>

                <input type="hidden" name="file-name" value="<?php echo $_POST['file-name']; ?>" />
                <input type="hidden" name="thumb-name" value="<?php echo $_POST['thumb-name']; ?>" />

                <input type="hidden" name="id" value="<?php echo $_REQUEST["id"]; ?>" />

            </form>
<?php
    }        
?>
        </main>
</div>

<?php
include('../includes/footer-admin.php');
?>