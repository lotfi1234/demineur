<?php
session_start();error_reporting(0);
ini_set('session.cookie_lifetime', '3600000') ;

?>

<!DOCTYPE html>
<html>
<head>
<title>
Mes parties
</title>
    <link rel="shortcut icon" href="mine.png">
    <link href="https://cdn.datatables.net/1.10.17/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/select/1.2.6/css/select.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.css" rel="stylesheet">
    <link href="https://editor.datatables.net/extensions/Editor/css/editor.bootstrap4.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>


    <script src="https://cdn.datatables.net/1.10.17/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.17/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>



</head>
<body>
  <div class="container">
    <div class="head" style="font-weight: bold;font-size: 25px">
      <nav class="navbar navbar-dark bg-dark">
  <a class="navbar-brand" href="Parties.php" style="font-size: 25px"><img src="mine.png" style="width: 30px;height: 30px">Minesweeper(Home)</a>

      <div class="form-inline">
          <a class="nav-link" style="display:none" >Subscribe</a>
          <a class="nav-link" style="display:none">Login</a>
<?php $bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
$req=$bdd->prepare('SELECT * FROM users WHERE id=?');
$id=$_COOKIE['id'];
$req->execute([$id]);
$verify=$req->fetch();
echo '<a class="nav-link" style="font-size: 25px;color: white">'.$_COOKIE['username'].'</a>';
?>
          <?php
          $req=$bdd->prepare('SELECT DISTINCT time_id,created_at,game_id FROM scores WHERE user_id=?');
          $req->execute([$_COOKIE['id']]);
          $data=$req->fetchAll();
          for($i=0;$i<count($data);$i++) {
              $req = $bdd->prepare('SELECT id FROM games WHERE id=?');
              $a=intval($data[$i][0]);
              $req->execute([$a]);
              $data1[$i]=$req->fetchAll();

          }
          ?>&nbsp;&nbsp;
          <div class="dropdown" >
        <a href="#" data-toggle="dropdown"><img class="round" src="avatar_defaut.png" style="margin-right: 40px;height:40px;width: 40px;border-radius:20px;">
            <div class="dropdown-menu"  >
               <?php echo '<h4 class="dropdown-item"><img src="icon.png" style="width: 20px;height: 20px">'.$verify['username'].'</h4>';?>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#exampleModal" ><img src="disconnet.png" style="width:15px;height: 15px"> Disconnect</a>
                <a class="dropdown-item active" href="Parties.php">Check your parties</a>
            </div>
        </a>
      </div>
      </div>

</nav>
</div><br>

<div class="row">

<div class="col-8" style="margin-left:2px;">
    <h2 class="form-inline">All Your Parties:


       </h2>
  <table class="table table-bordered table-striped" id="table" style="box-shadow: 4px 4px 4px #c8cdd1">
  <thead>
    <tr>
      <td scope="col">ID</td>
      <td scope="col">Best time(S)</td>
      <td scope="col">Last time(Date)</td>
      <td scope="col">Best player</td>
<td scope="col">Retry/Ranking</td>
    </tr>
  </thead>

  <tbody>
<?php
for ($i=0;$i<count($data);$i++) {
    $req = $bdd->prepare('SELECT user_id FROM scores WHERE game_id=? ORDER BY time_id LIMIT 1');
    $req->execute([$data[0][2]]);
    $user_id[$i] = $req->fetchAll();
}
$k=1;
for ($i=0;$i<count($data);$i++){
    $k++;
    echo '<tr id="'.$k.'" ><td>'.$i.'</td>';
    for ($j=0;$j<2;$j++){
        echo '<td>'.$data[$i][$j].'</td>';
    }
    $req = $bdd->prepare('SELECT username FROM users WHERE id=? ');
    $req->execute([$user_id[$i][0][0]]);
    $usern = $req->fetch();
    echo '<td>'.$usern['username'].'</td>';
    echo '<td><a id="R" href="play.php?id='.$data[$i][2].'" >Retry/</a><a id="Rank" href="Classement.php?id='.$data[$i][2].'">Ranking</a>';
    echo '</tr>';
}
?>
  </tbody>
</table>
  </div>
    <div  style="margin-left:2px;margin-top: 50px">
    <form method="post" action="levels.php" style="margin-top: 100px">
    <input type="submit" value="New map" class="btn btn-primary btn-lg" />
    </form>&nbsp; <form method="post" action="afficher.php"><button class="btn btn-primary btn-lg" id="pla" >Play the last game</button>
    </form>

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

<script>

    $(document).ready(function() {
        $('#table').on('click', 'a.editor_edit', function (e) {
            e.preventDefault();

            editor.edit( $(this).closest('tr'), {
                title: 'Edit record',
                buttons: 'Update'
            } );
        } );
       $('#table').DataTable({
           select: true,
           autoFill: true,
           "lengthChange": false,
            buttons:[
                'copy', 'excel', 'pdf'
            ]
    } );

    } );

        var id = '<?php echo json_encode($data);?>';
        id=JSON.parse(id);
        function logout() {
            window.parent.location.href ="logout.php";
        }
        function fun(id) {
            document.getElementById('table').deleteRow(id);
        }

    var table = document.getElementById("table");
    if(table.rows.length==1){
       document.getElementById("pla").setAttribute("disabled",null);
    }



</script>
  <div class="modal fade" id="Modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel"><img src="disconnet.png" style="width:20px;height: 20px">&nbsp;Disconnection</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
You don't have any Parties try New map!
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Ok</button>
              </div>
          </div>
      </div>
  </div>
  <div class="modal fade" id="Retry" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="exampleModalLabel" style="text-align: center">&nbsp;Retry!</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                  Are you sur?Your score will be deleted<br>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                  <button type="button" class="btn btn-primary btn-danger" data-dismiss="modal">Yes</button>
              </div>
          </div>
      </div>
  </div>

</body>
</html>
