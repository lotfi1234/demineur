
<link rel="stylesheet" href="bootstrap-4.1.1-dist/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="bootstrap-4.1.1-dist/js/bootstrap.min.js"></script>
<div class="container" style="font-weight: bold;font-size: 20px;">
<nav class="navbar navbar-dark bg-dark " style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="Parties.php" data-toggle="modal" id="home" data-target="#Modal" style="font-size: 25px"><img src="mine.png" style="width: 30px;height: 30px;font-size: 23px">Minesweeper(Home)</a>

    <form class="form-inline my-2 my-lg-0" style="color:white">
        <a class="navbar-link" href="" style="display:none;color:white"  data-target="#inscription" data-toggle="modal" id="subs">Subscribe</a>&nbsp;&nbsp;
        <a class="navbar-link" href=""  style="display: none;color:white" data-toggle="modal" data-target="#sign_in" id="login">Login</a>
        <a id="name" class="nav-link"></a>
        <div class="dropdown" >
            <a href="#" data-toggle="dropdown"><img class="round" src="avatar_defaut.png" style="margin-right: 40px;height:40px;width: 40px;border-radius:20px;">
                <div class="dropdown-menu" >
                    <h4 style="text-align: center;color: black"> <img src="icon.png" style="width: 20px;height: 20px;"><?php echo $_COOKIE['username'];?></h4>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#exampleModal" ><img src="disconnet.png" style="width:15px;height: 15px"> Disconnect</a>
                    <a class="dropdown-item " href="Parties.php">Check your parties</a>
                </div>
            </a>
        </div>

    </form>
</nav>
</div>