<?php
session_start();
error_reporting(0);
ini_set('session.cookie_lifetime', '3600000') ;
?>
<?php
$date=date("Y-m-d");
echo $date;
echo gettype($date);
    $bdd = new PDO('mysql:host=127.0.0.1;dbname=demineur', 'root', 'linux123');
    $req = $bdd->prepare('INSERT INTO scores SET user_id=?,game_id=?,time_id=?,created_at=?');
        $score = $_POST['score'];
    $id = $_COOKIE['id'];
    $g_id = $_POST['id'];
    $_SESSION['score']=$score;
    $req->execute([$id, $g_id, $score,$date]);

?>
