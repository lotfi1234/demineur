<?php
session_start();
ini_set('session.cookie_lifetime', '3600000') ;
$erreur="&nbsp;";$erreur2="&nbsp;";
$bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
if(isset($_POST['sign_in'])){
    if(!preg_match('^/[a-zA-Z0-9_]+$/^',$_POST['username'])){
        $erreur="the username don't respect the standard";
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
                header('Location:play.php?id='.$_COOKIE['game_id']);
                exit;
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
        $erreur2="wtf1";

        $req = $bdd->prepare('INSERT INTO users SET username=?,password=?');
        $req->execute([$_POST['username1'], $_POST['passwd1']]);
        $erreur2="wtf2";

        setcookie('password',$_POST['passwd1'],time() + 365*24*3600, null, null, false, true);
            setcookie('username',$_POST['username1'],time() + 365*24*3600, null, null, false, true);
            $id = $bdd->lastInsertId();
            setcookie('id',$id,time() + 365*24*3600, null, null, false, true);
            $_SESSION['u_id'] = $id;
            header('Location:play.php?id='.$_COOKIE['game_id']);
            exit;
    }
}
?>
<div class="modal" tabindex="-1" role="dialog" id="sign_in">
    <div class="modal-dialog" role="document">
        <div class="modal-content text center">
            <div class="modal-header">
                <h2 class="modal-title w-100 font-weight-bold" >Login</h2>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="modalinsc_login.php" method="post">
                <label> <i class="fa fa-user prefix grey-text"></i>UserName:</label>
                <input type="text" name="username" class="form-control" required placeholder="UserName"/><br>
                <label>Your Password:</label>
                <input type="password" class="form-control" name="passwd" required placeholder="Tap your password"/><br>
                <div style="text-align: center"><input type="checkbox" name="remember_me" > Remember me<br>
                    <div class="border border-danger" id="erreur" style="display:none;color: red;border-radius: 5px;height: 35px"><?php echo $erreur;?></div><br>

                    <input type="submit" name="sign_in" value="Login" class=" btn btn-primary" required/>
                </div>

                </form>
            </div>

            <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal" tabindex="-1" role="dialog" id="inscription">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title w-100 font-weight-bold">Inscription</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="modalinsc_login.php" method="post">
                    <label>UserName:</label>
                    <input type="text" name="username1" class="form-control" required placeholder="UserName"/><br>
                    <label>Your Password:</label>
                    <input type="password" name="passwd1" id="passwd1" class="form-control" required placeholder="Tap your password"/><br>
                    <label>Confirm Your Password:</label>
                    <input type="password" name="passwd2" class="form-control" id="passwd2" required placeholder="Confirm your password" onkeyup="erreur()"/><br>
                    <div class="border border-danger" id="erreur2" style="display: none;color: red;border-radius: 5px;height: 35px"><?php echo $erreur2;?></div><br>

                    <div style="text-align: center"><input type="submit"  name="submit" value="Submit" class="btn btn-primary btn-lg" required />
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
var mistakes1='<?php echo $erreur;?>';
var mistakes2='<?php echo $erreur;?>';
var get='<?php echo $_COOKIE['game_id'];?>';
if(mistakes1!="&nbsp;"){
    window.parent.location.href="play.php?id="+get;
    alert(mistakes1);
    document.getElementById("erreur").style.display="block";
}
if(mistakes2!="&nbsp;"){
    window.parent.location.href="play.php?id="+get;
alert(mistakes1);
    document.getElementById("erreur2").style.display="block";
}
function erreur(){

if(document.getElementById("passwd1").value!=document.getElementById("passwd2").value) {
document.getElementById("passwd2").className = "form-control is-invalid";
}else {
document.getElementById("passwd2").className = "form-control ";
}
}
</script>