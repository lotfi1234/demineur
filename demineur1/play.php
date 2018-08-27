
<?php
session_start();
ini_set('session.cookie_lifetime', '3600000') ;
setcookie('game_id',$_GET['id'],time()+32222,null, null, false, true)?>
<?php
error_reporting(0);
$bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
if(isset($_GET['id'])){
   $req=$bdd->prepare('SELECT * FROM games WHERE id=?');
  $req->execute([$_GET['id']]);
  $verify=$req->fetch();
  if(!$verify){
   header('Location:logout.php');
  }
  else
  {
    $min=json_decode($verify['map'],true);
  }
}

include 'exem.php';
include 'modalinsc_login.php';
echo '<div class="container2" style="background: limegreen;max-width: 720px;display:none;max-width: 1110px;width: 100%; padding-right: 15px;padding-left: 15px; margin-right: auto; margin-left: auto;height: 170px" id="show1">';
echo  '<h2 style="margin-left: 200px;color: red">Congratulation!,you have won the party';
echo '</h2>';
echo '<div id="score" class="win-block cold-md-6" style="margin-left:200px;width: 100px">';
echo '</div>';
echo '<a class="btn btn-primary btn-lg " id="wtf"  style="margin-left: 200px;color:#dfdfdf;border-radius: 0px;">Back to your parties!';
echo '</a>&nbsp;';
echo '<a class="btn btn-primary btn-lg " href="levels.php"  style="color:#dfdfdf;border-radius: 0px;">Create a new map';
echo '</a>&nbsp;';
echo '<a class="btn btn-primary btn-lg " href="Classement.php?id='.$_GET['id'].'"  style="color:#dfdfdf;border-radius: 0px;">Check the ranking';
echo '</a>';
echo '<br>';
echo '</div>';
echo '<div class="container1" style="background: #2c3e50;max-width: 1110px;width: 100%; padding-right: 15px;padding-left: 15px; margin-right: auto; margin-left: auto;display: none;height: 170px" id="show">';
echo  '<h2 style="margin-left: 200px;color: red"><img src="lose.png" style="width: 40px;height: 40px">Game Over!!';
echo '</h2>';
echo '<p style="margin-left: 200px;color: white"> Sorry,You lose!';
echo '</p>';
echo '<a class="btn btn-primary btn-lg btn-new-game" href="Parties.php"  style="margin-left: 200px;color:#dfdfdf;border-radius: 0px;">Back to your parties!';
echo '</a>';
echo '<a class="btn btn-default btn-lg btn-share"  href="levels.php" style="border-radius: 0px;background:whitesmoke"> New game?';
echo '</a>';

echo '<br>';
echo '</div>';

$req=$bdd->prepare('SELECT * FROM users WHERE id=?');
        $req->execute($_COOKIE['id']);
        $verify1=$req->fetch();

echo '<div class="container" >';

echo'<div class="row col-sm-21"><div class="col-8" ><table style="margin-left: 100px;margin-top: 50px" align="left">';
$k=0;$map=[];
for ($i=0;$i<$verify['width'];$i++){
    for ($j=0;$j<$verify['height'];$j++){
        echo '<td id="'.$i.'-'.$j.'" style="box-shadow:2px 2px 2px grey;width: 30px;height: 30px; text-align: center;background:lightgray;border:1px solid rgb(191, 191, 191);border-top-color:white;border-left-color:white;border-image-source:initial; border-image-slice: initial; "  onclick="f();opencase('.$i.','.$j.');win();"  >'.$map[$i][$j].'</td>';
    }
    echo '</tr>';
}

echo '</table></div>';
function mine_pos($i,$j,$map){
    $l=0;
if($map[$i][$j]=='x')
    return 'x';
if($map[$i][$j]==''){
    for ($o=$i-1;$o<$i+2;$o++){
    for ($k=$j-1;$k<$j+2;$k++) {
        if($map[$o][$k]=='x'){
            $l++;
    }
    }
    }
}
return $l ? $l : '';

}
function mape($x,$y,$min,$map=[]){

    for ($i=0;$i<$x;$i++){
        for ($j=0;$j<$y;$j++){
           $map[$i][$j]=mine_pos($i,$j,$min);
        }

    }
return $map;
}
$map=array();
    $map=mape($verify['width'],$verify['height'],$min);

?>

<!DOCTYPE html>
<head>
    <title>Minesweeper</title>
    <link rel="shortcut icon" href="mine.png">
</head>
<body style="">

<link href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
<link href="td.css">
<div id="tuto" class="col-4" style="margin-top: 30px">

    <h3>
        <img src="clock.png">
        <span  >{{ time.secondes }} </span>s &nbsp;
              <img src="mine.png" style="height: 30px;width: 30px;"><?php
        $req=$bdd->prepare('SELECT mines_number FROM games WHERE id=?');
        $req->execute([$_GET['id']]);
        $mine=$req->fetch();
        echo intval($mine['mines_number']);
        ?>
    </h3>
    <br>
    <p>
        <button class="btn btn-danger btn-lg" v-show="etat.play" @click="play">Proceed</button>
        <button class="btn btn-primary btn-lg" v-show="etat.stop" @click="stop" id="button" disabled>{{ btnPlay }}</button>
    </p><p style="font-size: 18px">URL:</p>
    <input type="url" class="form-control" id="url1"/>
</div>
<?php echo '</div></div>'?>
<br><br><br>
<div class="help container" >
    <h2 style="text-align: center">How to play Minesweeper online&nbsp;?</h2>
    <div class="row" style="font-size: 15px">
    <div class="col-5" style="margin-left: 95px">
        <p>The goal of the deminer is to discover all the free squares without detonating the mines.<br>

            Left click = free a box.<br>
            Right click = place a flag.<br>

            The number that appears on the boxes clicked indicates the number of mines nearby: left or right, up or down, or diagonally.<br>

            Thanks to the indications given by these figures, you can know where the mines are.<br>
            </p>
    </div>

    <div class="col-5">
        <p>If a box says "1" and there is only one box not discovered next, it is so that a mine is hidden there!<br>
            The counter on the top left shows how many mines remain to be found.<br>
            The counter at the top right is a stopwatch. Your goal is also to finish the deminer game as quickly as possible.<br>

            There are 3 levels of difficulty: Beginner, Medium, and Expert, the most difficult. Your best scores are saved.
        </p>
    </div>
    </div>
    <div class="clearfix"></div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.16/vue.js"></script>
<script src="game.js">
</script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<link href="bootstrap-4.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
<script>
    var m=[];
    m='<?php echo json_encode($map);?>';
    m=JSON.parse(m);
    var w='<?php echo $verify['width'];?>';
    var h='<?php echo $verify['height'];?>';
    function e() {
        for (i=0;i<w;i++) {
            for (j = 0; j < h; j++) {
                if (document.getElementById(i + "-" + j).innerHTML.length > 0) {
                    return true;
                }
            }
        }
        return false;
    }
    function f() {
        var t=e();
        if(t==false){
            document.getElementById("button").removeAttribute("disabled");

            chronoStart();
        }
    }

    function  opencase(i,j) {
        if(i<0 || i>=w){
            return;
        }
        if(j<0 || j>=h ) {
            return;
        }
        if (document.getElementById(i+"-"+j).innerHTML.length > 0){
    return;
}
        if(m[i][j]=='x'){
        return game_over(i,j);
        }
        if (typeof (m[i][j])=="number"){
            document.getElementById(i+"-"+j).innerHTML=m[i][j];
            if(m[i][j]==1) {
                document.getElementById(i + "-" + j).style.color = "blue";
            }
            if(m[i][j]==2) {
                document.getElementById(i + "-" + j).style.color = "green";
            }
            if(m[i][j]==3) {
                document.getElementById(i + "-" + j).style.color = "purple";
            }
            if(m[i][j]==4) {
                document.getElementById(i + "-" + j).style.color = "red";
            }
            document.getElementById(i+"-"+j).style.background="white";
            return;
        }
        else{
            document.getElementById(i+"-"+j).innerHTML = " ";
            document.getElementById(i+"-"+j).style.background="white";
            opencase(i-1,j-1);
            opencase(i-1,j);
            opencase(i-1,j+1);
            opencase(i,j-1);
            opencase(i,j);
            opencase(i,j+1);
            opencase(i+1,j-1);
            opencase(i+1,j);
            opencase(i+1,j+1);
            }

        }

        function game_over(i,j) {
            document.getElementById("home").removeAttribute("data-toggle");
            document.getElementById(i + "-" + j).style.background = "red";
            clearInterval(timer);
            for (i = 0; i < w; i++) {
                for (j = 0; j < h; j++) {
                    if (m[i][j] == 'x') {
                        document.getElementById(i + "-" + j).animate({
                            opacity: [0, 1],
                            color: ["#fff", "#000"]
                        }, 1000);
                        document.getElementById(i + "-" + j).style.backgroundImage="url('mine.png')";
document.getElementById(i+"-"+j).style.backgroundSize="30px 30px";

                    }
                }
            }
            unclick();

            setTimeout(showgame_over,1800);
        }
        function showgame_over(){

            $(document).ready(function () {
                $('#show').slideDown(1000);
            })
        }
        function win() {
        var check=true;var i,j;
        i=0;j=0;
      while (i<w){
          j=0;
          while (j<h){
                if(document.getElementById(i+"-"+j).innerHTML.length == 0 && m[i][j]!='x'){
                    return;
                }
              j++;
            }
i++;
        }

        if(i>=w-1 && j>=h-1){
clearInterval(timer);
            var t='<?php echo $_GET['id'];?>';
            var xhr=new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                }
            };
            xhr.open("POST","score.php", true);
            xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
            xhr.send("score="+totalSecondes+"&id="+t);
unclick();
show_win();
document.getElementById("home").removeAttribute("data-toggle");
        }
        }
function unclick() {
        document.getElementById("button").setAttribute("disabled",null);
    for (i=0;i<w;i++){
        for (j=0;j<h;j++){
            document.getElementById(i+"-"+j).removeAttribute("onclick");
        }
    }
}
function show_win() {
    document.getElementById("score").innerHTML="Your time: <br><h3>"+totalSecondes+"s</h3>";
    $(document).ready(function () {
        $('#show1').slideDown(1500);
    })
}
var level='<?php echo $_SESSION['level'];?>';
var url="Parties.php";
document.getElementById("wtf").href=url;
function re() {
    window.location.reload();
}
document.getElementById("name").innerHTML="<?php echo $_COOKIE['username'];?>&nbsp";
    function Back() {
        window.parent.location.href ="Parties.php";
    }
    document.getElementById("url1").value=document.location.href;

    if (document.getElementById("name").innerHTML!="&nbsp;"){
        document.getElementById("subs").style.display="none";
        document.getElementById("login").style.display="none";
    }else{
        document.getElementById("subs").style.display="block";
        document.getElementById("login").style.display="block";
    }
    function logout() {
        window.parent.location.href ="logout.php";
    }
var verifu='<?php echo  $_COOKIE['username'];?>';
if(verifu.length==0) {
    unclick();
    alert("you must login or subscibe to play");
}
</script>
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><img src="disconnet.png" style="width:20px;height: 20px">&nbsp;QUIT!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sur?You didn't finish your party yet<br>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="Back()">Yes</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><img src="disconnet.png" style="width:20px;height: 20px">&nbsp;Disconnection</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sur?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="logout()" id="yes">Yes</button>

            </div>
        </div>
    </div>
</div>


</body>
</html>