<?php
$bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
$req=$bdd->prepare('SELECT * FROM games WHERE id=?');
$req->execute([$_GET['id']]);
$verify=$req->fetch();
if(!$verify){
  echo "Cette map n'existe pas";
}
else
{
  $verify['map']=json_decode($verify['map'],true);
  print_r($verify['map']);
}
 ?>
