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
?>

<html>

<head>
	<meta charset="utf-8">
	<title>Graphics CARDMart</title>
	<link rel="stylesheet" type="text/css" href="style.css">

	<script type="text/javascript">
		function verify(checkout) {
			var content = "";
			if(checkout.firstname.value == "" || checkout.lastname.value == ""){
				content += "Please enter a full name\n";}
			if(checkout.addressline1.value == ""){
				content += "Please enter an address\n";}
			if(checkout.city.value == ""){
				content += "Please enter a town or city\n";}
			if(checkout.postcode.value == ""){
				content += "Please enter a post code\n";}
			if(checkout.phonenumber.value == "" || /^\d{11}$/.test(checkout.phonenumber.value) == false){
				content += "Please enter a valid mobile number\n";}

			if(checkout.holdername.value == ""){
				content += "Please enter the cardholder's name\n";}
			if(checkout.cardnumber.value == "" || /^\d{16}$/.test(checkout.cardnumber.value) == false){
				content += "Please enter a valid card number\n";}
			if(checkout.csc.value == "" || /^\d{3}$/.test(checkout.csc.value) == false){
				content += "Please enter a valid security code\n";}
			if (!content=="")
				{alert(content); return false;}
		}
	</script>
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
			<div id="checkout">
				<div id="form">
					<h1>Checkout</h1>
					<form class="formCheck" onSubmit="return verify(this)" name="CheckoutForm">
						<h2>About You</h2>
						<div class="textinput">
							<label for="firstname">First Name </label>
							<input type="text" name="firstname" id="firstname">
						</div>
						<br>
						<div class="textinput">
							<label for="lastname">Last Name </label>
							<input type="text" name="lastname" id="lastname">
						</div>
						<br>
						<div class="textinput">
							<label for="addressline1">Address Line 1 </label>
							<input type="text" name="addressline1" id="addressline1">
						</div>
						<br>
						<div class="textinput">
							<label for="addressline2">Address Line 2 </label>
							<input type="text" name="addressline2" id="addressline2">
						</div>
						<br>
						<div class="textinput">
							<label for="city">Town/City </label>
							<input type="text" name="city" id="city">
						</div>
						<br>
						<div class="textinput">
							<label for="postcode">Post Code</label>
							<input type="text" name="postcode" id="postcode">
						</div>
						<br>
						<div class="textinput">
							<label for="phonenumber">Mobile Number</label>
							<input type="text" name="phonenumber" id="phonenumber">
						</div>
						<br>

						<hr>

						<h2>Payment Information</h2>
						<div class="textinput">
							<label for="cardtype">Payment Types</label>
							<select name="cardtype" id="cardtype">
  								<option value="Visa">Visa</option>
  								<option value="Visa Debit">Visa Debit</option>
  								<option value="MasterCard">MasterCard</option>
  								<option value="American Express">American Express</option>
							</select>
						</div>
						<br>
						<div class="textinput">
							<label for="holdername">Cardholder's Name</label>
							<input type="text" name="holdername" id="holdername">
						</div>
						<br>
						<div class="textinput" id="numpar">
							<label for="cardnumber">Card Number</label>
							<input type="text" name="cardnumber" id="cardnumber">
						</div>
						<br>
						<div class="cscinput" id="cscpar">
							<label for="csc">CSC</label>
							<input type="text" name="csc" id="csc">
						</div>
						<br>
						<div class="textinput">
							<label for="expiryMonth">Card Expiry</label>
							<select name="expiryMonth" id="expiryMonth">
  								<option value="01">01</option>
  								<option value="02">02</option>
  								<option value="03">03</option>
  								<option value="04">04</option>
  								<option value="05">05</option>
  								<option value="06">06</option>
  								<option value="07">07</option>
  								<option value="08">08</option>
  								<option value="09">09</option>
  								<option value="10">10</option>
  								<option value="11">11</option>
  								<option value="12">12</option>
							</select>
							/
							<select name="expiryYear" id="expiryYear">
  								<option value="2016">2016</option>
  								<option value="2017">2017</option>
  								<option value="2018">2018</option>
  								<option value="2019">2019</option>
							</select>
						</div>
						<br>

						<div id="submit">
							<input type="submit" value="Continue"/>
						</div>
					</form>
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