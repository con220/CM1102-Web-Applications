<?php
$con = mysqli_connect("csmysql.cs.cf.ac.uk", "c1524815",
"yrTs34mLFh", "c1524815");
if (!$con) {
die("Failed to connect: " . mysqli_connect_error());
}

session_start();
//session_destroy();
if(isset($_POST['username'])) {
	$username = $_POST['username'];
	$qusername = "'" . $_POST['username'] . "'";
	$password = "'" . $_POST['password'] . "'";

	$query="SELECT * FROM Accounts WHERE Usernames=$qusername AND Passwords=$password";
    $retrieve=mysqli_query($con, $query);

    if(mysqli_num_rows($retrieve) != 0) {
    	$_SESSION['username'] = $username;
    		header("Location: index.php");
			exit;
    }
}
?>

<html>

<head>
	<meta charset="utf-8">
	<title>Graphically intense</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<script type="text/javascript">
		function verify(checkout) {
			var content = "";
			if(checkout.username.value == "") {
				content += "Please enter a username\n";}
			if(checkout.password.value == "") {
				content += "Please enter a password\n";}
			if (!content=="")
				{alert(content); return false;}
		}
	</script>
</head>

<body>
	<div id ="header">
		<img src="images/logo.png">
	</div>

	<div id ="wrapper">
		<div id="login">
			<h2>Login to Your Account</h2>
			<div class="loginform">
				<form method="POST" onSubmit="return verify(this)">
					<input type="text" placeholder="Username" name="username" id="username"><br><br>
					<input type="password" placeholder="Password" name="password" id="password"><br><br>
					<input type="submit" value="Login"/>
				</form>
			</div>
		</div>
	</div>
</body>
</html>