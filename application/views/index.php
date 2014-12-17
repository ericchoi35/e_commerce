<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>E-commerce</title>
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
	<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
</head>
<body>
<div class="container">
	<h1 class='page-header'>E-commerce</h1>
<?php 	if($this->session->flashdata('success'))
		{	?>
		<h3><?= $this->session->flashdata('success') ?></h3>
<?php	}	?>
	<div class='row'>
		<h1 class='col-sm-4'>Products</h1>
		<h3 class='col-sm-4 col-sm-offset-4'><a href='/cart'>Your Cart (<?= $this->session->userdata('quantity')?>)</a></h3>
	</div>
	<table class='table table-striped'>
		<thead>
			<tr>
				<th>Name</th>
				<th>Description</th>
				<th>Price</th>
				<th>Quantity</th>
			</tr>
		</thead>
		<tbody>
<?php 		foreach($products as $product)
			{	?>
			<tr>
				<td><?= $product['name'] ?></td>
				<td><?= $product['description'] ?></td>
				<td>$<?= $product['price'] ?></td>
				<td>
					<form action='/orders/update' method='post'>
						<input type='hidden' name='product_id' value="<?= $product['id']?>">
						<select name='quantity'>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
						</select>
						<input type='submit' class='btn btn-default' value='Buy'>
					</form>
				</td>
			</tr>
<?php		}	?>
		</tbody>
	</table>
</div>
</body>
</html>