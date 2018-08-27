<?php
session_start();
ini_set('session.cookie_lifetime', '3600000') ;
$bdd = new PDO('mysql:host=127.0.0.1;dbname=demineur', 'root', 'linux123');

$height=$_POST['height'];
$level=$_POST['button'];
$width=$_POST['width'];
if(isset($_POST['launch'])) {
    if ($level == 'easy') {
        $mines_number = ($height * $width * 10) / 100;
    }
    if ($level == 'medium') {
        $mines_number = ($height * $width * 20) / 100;
    }
    if ($level == 'hard') {
        $mines_number = ($height * $width * 30) / 100;
    }
$_SESSION['level']=$level;
    error_reporting(0);
    $mines_number = intval($mines_number);
    $_SESSION['num_min'] = $mines_number;
    function place($c, $width, $height, $min = [])
    {
        if ($c < 0) {
            return $min;
        }
        $x = rand(0, $width - 1);
        $y = rand(0, $height - 1);
        if ($min[$x][$y] == 'x') {
            return place($c, $width, $height, $min);
        }
        $min[$x][$y] = 'x';
        return place($c - 1, $width, $height, $min);
    }

    $map = place($mines_number - 1, $width, $height);
    $map = json_encode($map);
    $req = $bdd->prepare('INSERT INTO games(mines_number,width,height,map) VALUES(:mines_number,:width,:height,:map)');
    $req->execute(array('mines_number' => $mines_number, 'width' => $width, 'height' => $height, 'map' => $map));
    $idg = $bdd->lastInsertId();
    $_SESSION['game_id']=$idg;
    header('Location:play.php?id=' . $idg);
}
else {
    $req = $bdd->prepare('SELECT game_id FROM scores WHERE user_id=? ORDER BY id DESC LIMIT 1');
    $req->execute([$_COOKIE['id']]);
    $gameid = $req->fetch();
    $_SESSION['game_id']=$gameid;
    $req=$bdd->prepare('SELECT mines_number FROM games WHERE id=?');
    $req->execute([$gameid['game_id']]);
    $mine=$req->fetch();
    $_SESSION['num_min']=$mine['mines_number'];
    header('Location:play.php?id=' . $gameid['game_id']);
}
?>
