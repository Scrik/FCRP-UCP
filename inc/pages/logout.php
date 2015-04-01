<?php if(!isset($_SESSION['Logged'])) header("Location: ?page=homepage");?>
<div class="jumbotron" align="center">
<?php 
echo GetMessage("Signed out:", 'You have logged out of the session.', 4);
unset($_SESSION['Logged']);
unset($_SESSION['CLogged']);
echo "<meta http-equiv='refresh' content='1.5;url=?page=homepage'>";
?>
</div>