<?php

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="E-Commerce Website">
	<meta name="author" content="Laurent Echeverria">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<title>E-Commerce</title>

	<link rel="stylesheet" type="text/css" href="assets/css/materialize.min.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/material-icons.css" />
  <link rel="stylesheet" type="text/css" href="assets/css/style.css" />

</head>

<body>
	<nav class="blue lighten-1">
    <div class="nav-wrapper">
      <a href="#!" class="brand-logo">My Web Shop</a>
      <ul class="right hide-on-med-and-down">
				<li>
					<a class="dropdown-trigger" href="#!" data-target="product">Products Menu
						<i class="material-icons right">arrow_drop_down</i>
					</a>

					<ul id="product" class="dropdown-content">
  					<li><a href="#!">Shirts</a></li>
  					<li><a href="#!">Pants</a></li>
						<li><a href="#!">Shoes</a></li>
						<li><a href="#!">Accessories</a></li>
					</ul>
				</li>

				<li>
					<a class="dropdown-trigger" href="#!" data-target="account">My Account
						<i class="material-icons right">arrow_drop_down</i>
					</a>

					<ul id="account" class="dropdown-content">
  					<li><a href="#!">Login</a></li>
  					<li><a href="#!">Create Account</a></li>
					</ul>
				</li>

				<li>
					<a class="dropdown-trigger" href="#!" data-target="cart">My Cart (<small> 5 Items </small>)
						<i class="material-icons right">arrow_drop_down</i>
					</a>

					<ul id="cart" class="dropdown-content">
  					<li><a href="#!">Product 1</a></li>
						<li><a href="#!">Product 2</a></li>
						<li><a href="#!">Product 3</a></li>
						<li><a href="#!">Product 4</a></li>
						<li><a href="#!">Product 5</a></li>
					</ul>
				</li>
			</ul>
		</div>
  </nav>

	<script src="assets/js/jquery-3.3.1.min.js"></script>
  <script src="assets/js/materialize.min.js"></script>

	<script>
		$(document).ready(function() {
			$(".dropdown-trigger").dropdown();
		});
	</script>

        

</body>
</html>