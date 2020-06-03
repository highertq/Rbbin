<?php // Example 27-12: logout.php
  require_once 'header.php';
  date_default_timezone_set('PRC');
  if (isset($_SESSION['user']))
  {
    $_SESSION['user'] = $user;
    $thing6="log out";
    $time=time();
    queryMysql("INSERT INTO log VALUES(NULL,'$user', '$thing6',$time)");
    destroySession();
    echo "<br><div class='center'>You have been logged out. Please
         <a data-transition='slide' href='index.php'>click here</a>
         to refresh the screen.</div>";
  }
  else echo "<div class='center'>You cannot log out because
             you are not logged in</div>";
?>
    </div>
  </body>
</html>
