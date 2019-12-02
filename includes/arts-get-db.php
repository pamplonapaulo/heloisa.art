<?php

$artTitle;
$artSubtitle;
$description;

$image;
$thumb;

$allArts = [];

$prev;
$prevItem;
$prevTitle;

$next;
$nextItem;
$nextTitle;

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

// (result set)
$rs = $connection->prepare('SELECT * FROM watercolors ORDER BY id DESC LIMIT 999');

if($rs->execute())
{
    while($registro = $rs->fetch(PDO::FETCH_OBJ))
    {

        if($registro->id == $_GET['item']){

            if($_SESSION['lang'] =='en')
            {
                $artTitle = $registro->title_en;
                $artSubtitle = $registro->subtitle_en;
                $description =  'An art by Helosia Beatriz made with ' . $artSubtitle . '.';
            }
            else
            {
                $artTitle = $registro->title_pt;
                $artSubtitle = $registro->subtitle_pt;
                $description =  'Uma arte de Heloisa Beatriz feita com ' . $artSubtitle . '.';
            }
            $image = $registro->file_name;
            $thumb = $registro->thumb_name;
        }


        $single = array('id' => $registro->id,
                        'title' => $registro->title_en);

        array_push($allArts, $single);

    }
}
else
{
    echo '<br>Falha no carregamento.<br>';
}

for($i = 0; $i < count($allArts); ++$i) {

    if($allArts[$i]['id'] == $_GET['item']){
        $prev = $i - 1;
        $next = $i + 1;
    }
}

if(isset($allArts[$prev])){
    $prevItem = $allArts[$prev]['id'];
    $prevTitle = tailorMadeSanitize($allArts[$prev]['title']);
    $prevClassDisplay = "visible";
}

if(isset($allArts[$next])){
    $nextItem = $allArts[$next]['id'];
    $nextTitle = tailorMadeSanitize($allArts[$next]['title']);
    $nextClassDisplay = "visible";
}

