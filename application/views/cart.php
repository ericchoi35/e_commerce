<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<!-- <link rel="stylesheet" type="text/css" href="assets/css/style.css"> -->
	<link rel="stylesheet" type="text/css" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
	<script type="text/javascript" src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js'></script>
	<style>
		h3{
			display: inline-block;
			width: 430px;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1 >Check Out</h1>
		<div class='row'>
			<div class='col-sm-6'>
				<h3>Your cart</h3>
				<a class='btn btn-default' href='/'>Keep shopping</a>
				<table class='table table-striped'>
					<thead>
						<tr>
							<th>Quantity</th>
							<th>Name</th>
							<th>Price</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
<?php 				foreach($items as $item)
					{	?>
						<tr>
							<td><?= $item['quantity'] ?></td>
							<td><?= $item['name'] ?></td>
							<td>$<?= $item['price'] ?></td>
							<td>
								<form action='/orders/delete' method='post'>
									<input type='hidden' name='id' value="<?= $item['id']?>">
									<input type='submit' class='btn btn-default' value='Delete'>
								</form>
							</td>
						</tr>
<?php 				}	?>
						<tr>
							<td></td>
							<td>Total:</td>
							<td>$<?= $this->session->userdata('total')?></td>
							<td></td>
						</tr>
					</tbody>
				</table>
				<h4>Total # of items: <?= $this->session->userdata('quantity')?></h4>
			</div>
			<div class='col-sm-4 col-sm-offset-1'>
				<h3>Billing Info</h3>
				<form role="form" action='/orders/create' method='post'>
				  	<div class="form-group">
				    	<label>Name</label>
				    	<input type="text" name="name" class="form-control" placeholder="Enter name">
				  	</div>
				  	<div class="form-group">
				    	<label>Address</label>
				    	<input type="text" name="address" class="form-control" placeholder="Enter mailing address">
				  	</div>
				  	<div class="form-group">
				    	<label>Card Number</label>
				    	<input type="text" name="card_number" class="form-control" placeholder="Enter card number">
				  	</div>
				  	<button type="submit" class="btn btn-default">Place Order</button>
				</form>
<?php 			if($this->session->flashdata('message'))
				{	?>
					<h4><?= $this->session->flashdata('message') ?></h4>
<?php			}	?>
			</div>
		</div>	
	</div>
</body>
</html>