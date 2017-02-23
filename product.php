<?php
$con = mysqli_connect("csmysql.cs.cf.ac.uk", "c1524815",
"yrTs34mLFh", "c1524815");
if (!$con) {
die("Failed to connect: " . mysqli_connect_error());
}

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

if (isset($_GET['id'])){
	$id = intval($_GET['id']);
}

if (isset($_GET['action']) && $_GET['action']=="addcart"){
	$id = intval($_GET['id']);

	if (isset($_SESSION[$username][$id])){
		$_SESSION[$username][$id]['amount'] = $_SESSION[$username][$id]['amount'] + 1;

		} else {
			$query="SELECT * FROM Products WHERE ID={$id}";
			$retrieve = mysqli_query($con, $query);

			$row=mysqli_fetch_assoc($retrieve);
			$_SESSION[$username][$row['ID']] = array("amount" => 1);
			}

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
			<div id="product">
				<?php 
					$query="SELECT * FROM Products WHERE ID=$id";
    				$retrieve=mysqli_query($con, $query);

    				$row=mysqli_fetch_assoc($retrieve);
				?>

				<h1><?php echo $row['Product']?></h1>
				<div id="image">
					<img src=<?php echo $row['URL']?> border="3px">
				</div>

				<div id="basic">
					<h3>Price: £<?php echo $row['Price']?></h3>
					<p><?php echo $row['Description']?></p>
					<div class="button"><p><a href="product.php?action=addcart&id=<?php echo $row['ID'] ?>">Add to cart</a></p></div>
				</div>

				<div id="footer">
					<a href="http://support.amd.com/en-us/" class="amd"></a>
					<a href="http://www.nvidia.co.uk/page/support.html" class="nvida"></a>
					<p style="text-indent:0">For support please visit the related manufacturers via the links above</p>
				</div>
			</div>

			<div id ="basket">
				<h2>Basket</h2>
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
    								<td style="text-align:right">x <?php echo $_SESSION[$username][$id]['amount'] ?></td>
    							</tr>
    						<?php	
							}
						} else {
							echo "<h3>Your basket is empty</h3>";
						}
					?>
				</table>

				<div class="button">
					<p><a href="cart.php">View basket</a></p>
				</div>
			</div>
	</div>
</body>
</html>