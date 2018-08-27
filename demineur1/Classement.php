<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>
Ranking
</title>
    <link rel="shortcut icon" href="mine.png">
    <link href="bootstrap-4.1.1-dist/css/bootstrap.min.css" rel="stylesheet">
<link href="Style.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/select/1.2.6/css/select.bootstrap4.min.css">
    <link href="https://editor.datatables.net/extensions/Editor/css/editor.bootstrap4.min.css" rel="stylesheet">

</head>
<body>
  <div class="container">
      <nav class="navbar navbar-dark bg-dark" style="font-size: 25px;background-color: black">
          <a class="navbar-brand" href="Parties.php" style="font-size: 25px;"><img src="mine.png" style="width: 30px;height: 30px;">Minesweeper(Home)</a>
          <form class="form-inline">
              <a class="navbar-link" style="display:none;font-size: 25px;" >Subscribe</a>
              <a class="nav-link" style="display:none;font-size: 25px;">Login</a>
              <strong id="name" style="font-size: 25px;color: white;"><?php echo $_COOKIE['username'];?>&nbsp;</strong>
              <div class="dropdown" >
                  <a href="#" data-toggle="dropdown"><img class="round" src="avatar_defaut.png" style="margin-right: 40px;height:40px;width: 40px;border-radius:20px;">
                      <div class="dropdown-menu" >
                          <h4 id="name" style="color: black;text-align: center"><img src="icon.png" style="width: 20px;height: 20px"><?php echo $_COOKIE['username'];?></h4>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#exampleModal" ><img src="disconnet.png" style="width:15px;height: 15px"> Disconnect</a>
                          <a class="dropdown-item " href="Parties.php">Check your parties</a>
                      </div>
                  </a>
              </div>
          </form>
      </nav>
<div class="row">
<div class="col-md-8 order-md-1" >
    <h3 style="margin-top: 50px">The Ranking:</h3>
  <table class="table table-bordered table-striped table-dark" id="table">
  <thead>
    <tr >
      <td scope="col">RANK</td>
      <td scope="col">Player</td>
      <td scope="col">Time</td>
    </tr>
  </thead>
  <tbody>
<?php
$bdd=new PDO('mysql:host=127.0.0.1;dbname=demineur','root','linux123');
$req=$bdd->prepare('SELECT DISTINCT user_id,time_id FROM scores WHERE game_id=? ORDER BY time_id');
$req->execute([$_GET['id']]);
$users=$req->fetchAll();


for ($i=0;$i<count($users);$i++){
    $req=$bdd->prepare('SELECT DISTINCT username FROM users WHERE id=? ');
    $us=intval($users[$i][0]);
    $req->execute([$us]);
    $usernames[$i]=$req->fetchAll();

}
$j=1;
for ($i=0;$i<count($usernames);$i++){
    echo '<tr><td>'.$j.'</td>';
        echo '<td>'.$usernames[$i][0][0].'</td>';
echo '<td>'.$users[$i][1].'</td>';
$j++;
}
?>

  </tbody>
</table>
  </div>
</div>
</div>
<script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
<script>
    $(document).ready(function() {
        $('#table').DataTable({
            "lengthChange": false
            });
    } );
    function logout() {
        window.parent.location.href ="logout.php";
    }
</script>
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
