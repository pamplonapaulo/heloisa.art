<?php
require '../vendor/autoload.php';
session_start();

if($_SESSION['csrf_token'] != $_COOKIE['user'] || $_SESSION['csrf_token'] == null || $_COOKIE['user'] == null){

    include('../includes/head-admin-login-fail.php');
    echo '<div class="container" style="display:table;"><main style="display:table-cell;float:none;vertical-align: middle;"><h1>Realize o login novamente</h1><form><a href="./index.php"><button class="directions inactive" type="button">Login</button></a></form></main></div>';  

    exit();
}

include('../includes/head-admin.php');

?>
    <div class="container">
        <main>
            <h1>Gerenciador de artes</h1>

            <table>
                <tr>
                    <th>&nbsp</th>
                    <th>Título<br>(Português)</th>
                    <th>Título<br>(Inglês)</th>
                    <th>Detalhe<br>(Português)</th>
                    <th>Detalhe<br>(Inglês)</th>
                    <th>Arquivo<br>Imagem</th>
                    <th>Arquivo<br>Thumbnail</th>
                    <th>Ações</th>
                </tr>
<?php

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
    
    if(isset($_REQUEST['excluir']) && $_REQUEST['excluir'] == true)
    {
        $stmt = $connection->prepare('DELETE FROM watercolors WHERE id = ?');
        $stmt->bindParam(1, $_REQUEST['id']); 
        $stmt->execute();
        
        if($stmt->errorCode() != '00000')
        {
            echo 'Erro código ' . $stmt->errorCode() . ': ';
            echo '<br>';
            echo implode(', ', $stmt->errorInfo());
        }
        else
        {

            $img = $_REQUEST['img'];
            $thumb = $_REQUEST['thumb'];

            echo '<h2>Sucesso: arte removida!</h2>';
            echo '<br/><br/><h2>Thumbnail: </h2>' . $thumb;
            echo '<br/><br/><h2>Imagem:</h2>' . $img;
            
            unlink('../assets/obras/' . $img);
            unlink('../assets/obras/thumb/' . $thumb);
        }
    }
    
// seleção:

    // (result set)
    $rs = $connection->prepare('SELECT * FROM watercolors');
    
    if($rs->execute())
    {
        while($registro = $rs->fetch(PDO::FETCH_OBJ))
        {
            echo '<tr><td><img class="ux-help" src="../assets/obras/thumb/'. $registro->thumb_name . '" alt="'. $registro->title_en .'"/></td>';
            
            echo '<td><p>' . $registro->title_pt . '</p></td>';
            echo '<td><p>' . $registro->title_en . '</p></td>';
            echo '<td><p>' . $registro->subtitle_pt . '</p></td>';
            echo '<td><p>' . $registro->subtitle_en . '</p></td>';
            echo '<td><p>' . $registro->file_name . '</p></td>';
            echo '<td><p>' . $registro->thumb_name . '</p></td>';
            echo '<td><a title="EXCLUIR ' . $registro->title_pt . '" href="?excluir=true&id=' . $registro->id . '&img=' . $registro->file_name . '&thumb=' . $registro->thumb_name . '"><i class="material-icons">delete</i></a><a title="EDITAR ' . $registro->title_pt . '" href="form-art-edit.php?id=' . $registro->id . '"><i class="material-icons">create</i></a></td></tr>';
        }
    }
    else
    {
        echo '<br>Falha na seleção de usuários.<br>';
    }
?>    
        </table>
        </main>
</div>

<?php
include('../includes/footer-admin.php');
?>