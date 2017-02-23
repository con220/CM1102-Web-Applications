<?php
$con = mysqli_connect("csmysql.cs.cf.ac.uk", "c1524815",
"yrTs34mLFh", "c1524815");
if (!$con) {
die("Failed to connect: " . mysqli_connect_error());
}

$total = 0;

session_start();
//session_destroy();
if(isset($_GET['action']) && $_GET['action'] == "logout") {
	unset($_SESSION['username']);
	header("Location: login.php");
	exit;
}

if(isset($_SESSION['username'])) {
	$username = $_SESSION['username'];
} else {
	header("Location: login.php");
	exit;
}

if (isset($_GET['action']) && $_GET['action']=="remove"){
	$id = intval($_GET['id']);

	unset($_SESSION[$username][$id]);
}

?>

<html>

<head>
	<meta charset="utf-8">
	<title>Graphically intense</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>
	<div id ="header">
		<img src="images/logo.png">
		<div id="logout">
			<h3><a href="index.php?action=logout">Log Out</a></h3>
		</div>
	</div>

	<div id ="wrapper">
		<div id="left">
			<ul>
				<li><a href="index.php">All Products</a></li>
				<li><a href="index.php?action=filter&type='AMD R9'">AMD R9 Series</a></li>
				<li><a href="index.php?action=filter&type='AMD R7'">AMD R7 Series</a></li>
				<li><a href="index.php?action=filter&type='GeForce'">NVIDA GeForce Series</a></li>
			</ul>
		</div>
		<div id="main">
			<div id="cart">
				<h1>Shopping Basket</h1>
					<?php
						if (isset($_SESSION[$username]) && count($_SESSION[$username]) > 0) {
					?>
					<table style="width:80%;text-align:center", align="center">
					<tr>
						<th>ID</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Quantity</th>
						<th></th>
					</tr>
					<?php
							foreach ($_SESSION[$username] as $id => $val) {
								$query="SELECT * FROM Products WHERE ID=$id";
    							$retrieve=mysqli_query($con, $query);

    							$row=mysqli_fetch_assoc($retrieve);

    							?>
    							<tr style="width:100%">
    								<td><?php echo $row['ID']?></td>
    								<td><?php echo $row['Product']?></td>
    								<td>£<?php echo $row['Price']?></td>
    								<?php $total =  $total + ($row['Price'] * $_SESSION[$username][$id]['amount'])?>
    								<td>x <?php echo $_SESSION[$username][$id]['amount'] ?></td>
    								<td><a href="cart.php?action=remove&id=<?php echo $row['ID'] ?>">Remove</a></td>
    							</tr>
    						<?php	
							}
							?>

							<tr>
								<td></td>
								<td></td>
								<td>£<?php echo $total ?></td>
								<td></td>
								<td></td>
							</tr>

							<?php
						} else {
							echo "<h2 style='text-align:center'>Your basket is empty</h2>";
						}
					?>
				</table>
				<br>

				<div class="button"><p><a href="index.php">Back</a></p></div>
				<hr>
				<?php
					if (isset($_SESSION[$username]) && count($_SESSION[$username]) > 0) {
				 ?>
					<div class="button"><p><a href="checkout.php">Checkout</a></p></div>
					<?php
					}	
					 ?>
			</div>

			<div id ="basket">
				<h2 style="text-align:left, text-indent:7%">Basket</h2>
				<hr>
				<table align="center">
					<?php
						if (isset($_SESSION[$username]) && count($_SESSION[$username]) > 0) {
							foreach ($_SESSION[$username] as $id => $val) {
								$query="SELECT * FROM Products WHERE ID=$id";
    							$retrieve=mysqli_query($con, $query);

    							$row=mysqli_fetch_assoc($retrieve);

    							?>
    							<tr style="width:100%">
    								<td><?php echo $row['Product']?></td>
    								<td>x <?php echo $_SESSION[$username][$id]['amount'] ?></td>
    							</tr>
    						<?php	
							}
						} else {
							echo "<h3>Your basket is empty</h3>";
						}
					?>
				</table>
			</div>
	</div>
</body>
</html>