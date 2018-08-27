<?php
setcookie('id','s',time()-10000 , null, null, false, true);
setcookie('password','',time()-10000, null, null, false, true);
setcookie('username','',time()-1000 , null, null, false, true);
setcookie('remember','',time()-1000 , null, null, false, true);

header('Location:Index.php');
?>