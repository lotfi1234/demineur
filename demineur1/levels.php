<?php
session_start();
ini_set('session.cookie_lifetime', '3600000') ;

?>
<!DOCTYPE html>
<html>
<head>
<title>Levels</title>
<link href="bootstrap-4.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="bootstrap-4.1.1-dist/css/build.css" rel="stylesheet">
<link href="game.js" rel="stylesheet">
</head>
<body>
  <div class="container" style="padding-top:70px;padding-left:50px;border: 2px solid #C0C0C0;background: #F5F5F5;width:350px;height:400px;border-radius:20px;margin-top:50px;padding-bottom:30px;">
<form id="choice" action="afficher.php"method="post">
  <table>
    <tr><td><h4>Width :</h4> <input style="width: 250px" class="form-control" type="number" name="width" required max="25" min="10"/></td></tr>
    <tr><td><h4>Height : </h4><input class="form-control" type="number" name="height" required max="25" min="10"/></td></tr>
<tr><td ><input class="btn btn-primary" type="radio" name="button" value="hard"/><font size="+2">hard</font></td></tr>
<tr><td ><input class="btn btn-primary" type="radio" name="button" value="medium"/><font size="+2">medium</font></td></tr>
<tr><td ><input class="btn btn-primary" type="radio" name="button" value="easy"/><font size="+2">easy</font></td></tr>
<tr><td align="center"><input class="btn btn-primary" type="submit" name="launch" value="launch"/></td></tr>

</table>
</form>
</div>

</body>
</html>
