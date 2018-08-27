<?php
session_start();
ini_set('session.cookie_lifetime', '3600000') ;

$erreur="&nbsp;";$erreur2="&nbsp;";
    if(!empty($_COOKIE['remember'])){
        $_SESSION['id']=$_COOKIE['id'];
        header('Location:Parties.php');
        exit;
    }

$bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
if(isset($_POST['sign_in'])){
    if(!preg_match('^/[a-zA-Z0-9_]+$/^',$_POST['username'])){
        $erreur="Syntaxe_error";
    }
$check=$bdd->prepare('SELECT password,id FROM users WHERE username=?');
$check->execute([$_POST['username']]);
$user=$check->fetch();

if($user['password']!=$_POST['passwd']){
  $erreur="Wrong Password,Try again";
}else {
    if(isset($_POST['remember_me'])){
        setcookie('remember','true',time() + 365*24*3600, null, null, false, true);
    }
    setcookie('id',$user['id'],time() + 365*24*3600, null, null, false, true);
    setcookie('password',$_POST['passwd'],time() + 365*24*3600, null, null, false, true);

    setcookie('username',$_POST['username'],time() + 365*24*3600, null, null, false, true);
    $id=$user['id'];
    $_SESSION['u_id']=$id;

  header('Location:Parties.php');
}
}
else if(isset($_POST['submit'])) {
    $check = $bdd->prepare('SELECT id FROM users WHERE username=?');
    $check->execute([$_POST['username1']]);
    $user = $check->fetch();
    if ($user) {
        $erreur2 = "the username is taken try something else!!";
    }
    else {
        $req = $bdd->prepare('INSERT INTO users SET username=?,password=?');
        if ($_POST['passwd1'] == $_POST['passwd2']) {
            $req->execute([$_POST['username1'], $_POST['passwd1']]);
            setcookie('password',$_POST['passwd1'],time() + 365*24*3600, null, null, false, true);
            setcookie('username',$_POST['username1'],time() + 365*24*3600, null, null, false, true);
            $id = $bdd->lastInsertId();
            setcookie('id',$id,time() + 365*24*3600, null, null, false, true);
            $_SESSION['u_id'] = $id;
            header('Location:Parties.php');
        } else {
            $erreur2 = "the password doesn't match";
        }
    }
}
 ?>
<!DOCTYPE html>
<html>
<head>
<title>  Minesweeper</title>
    <link rel="shortcut icon" href="mine.png">

    <link href="bootstrap-4.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style1.css" rel="stylesheet">
</head>
<body style="background-image: url('mine.png')" >
<script href="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script>

  <div class="container">
<form method="post" action="index.php" name="form1" >
  <div class="row col-sm-12" style="padding-top: 40px;" id="allo1">

    <div class="col-sm-4" style=" border: 2px solid #C0C0C0;box-shadow:3px 4px 2px #c8cdd1;background: #F5F5F5;border-style:groove;padding-top: 20px;margin-left: 20px;">
        <h2 style="text-align: center">Sign in:</h2><br>
<label>UserName:</label>
<input type="text" name="username" class="form-control" required placeholder="UserName"/><br>
<label>Your Password:</label>
<input type="password" class="form-control" name="passwd" required placeholder="Tap your password"/><br>
        <div style="text-align: center"><input type="checkbox" name="remember_me" > Remember me</div><br>
        <div class="border border-danger" id="erreur" style="display: none;color: red;border-radius: 5px;height: 35px"><?php echo $erreur;?></div><br>
           <div style="text-align: center"><input type="submit" name="sign_in" value="Sign in" class=" btn btn-primary btn-lg"  onclick="erreur()" /></div>
  </form> <div class="form" id="subm">

      </div></div>
<div style="color: black;border-right: 1px solid black;height: 230px;"><p style="margin-top: 231px;text-align: center">Or =></p><div style="color: black;border-right: 1px solid black;height: 230px;">
    </div></div>



<div  class="col-sm-5" style=" border: 2px solid #C0C0C0;box-shadow:3px 4px 1px #c8cdd1;background: #F5F5F5;border-style:groove;padding-top: 30px;padding-bottom: 20px;" id="allo">
<form method="post" action="index.php" name="form2">
  <h2 align="center"> Please register:</h2><br>
<label>UserName:</label>
<input type="text" name="username1" class="form-control" required placeholder="UserName"/><br>
<label>Your Password:</label>
<input type="password" id="passwd1" name="passwd1" class="form-control" required placeholder="Tap your password"/><br>
<label>Confirm Your Password:</label>
<input type="password" name="passwd2" class="form-control" id="passwd2" required placeholder="Confirm your password" onkeyup="erreur()"/><br>
    <div class="border border-danger" id="erreur2" style="display:none;color: red;border-radius: 5px;height: 35px"><?php echo $erreur2;?></div><br>

    <div style="text-align: center"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-lg" />
</div>
</form>
</div>
</div>
</div>

<script>
        var mistakes1='<?php echo $erreur;?>';
        var mistakes2='<?php echo $erreur2;?>';
if(mistakes1!="&nbsp;"){
    document.getElementById("erreur").style.display="block";
}
if(mistakes2!="&nbsp;"){
    document.getElementById("erreur2").style.display="block";
}

    document.getElementById("allo").animate({
        opacity: [ 0, 5 ],
        color:   [ "#fff", "#000" ]
    }, 2000);
    document.getElementById("allo1").animate({
        opacity: [ 0, 5 ],
        color:   [ "#fff", "#000" ]
    }, 2000);
    function erreur(){

if(document.getElementById("passwd1").value!=document.getElementById("passwd2").value) {
    document.getElementById("passwd2").className = "form-control is-invalid";
}else {
    document.getElementById("passwd2").className = "form-control ";
}
    }
</script>
</body>

</html>
