<?
include("config.php");
global $link;

if (!empty($_POST["title_product"]) && !empty($_POST["default_price"])) {
	$name = trim($_POST["title_product"]);
	$defaul_price = trim($_POST["default_price"]);

	$sql = mysqli_query($link, "INSERT INTO products (name, default_price) VALUES ('" . $name . "', ".$defaul_price.")");
	header("Location: index.php", true, 301 );
}	
?>
<?php include("views/layouts/header.php"); ?>

	<div class="row">
		<div class="col-md-3"><br>
			<a class="btn btn-default" href="index.php" role="button">Вернуться к списку</a>
		</div>
	</div><br>
	<h2>Добавление товара</h2>
	<form method="post" action="">
		<div class="row">
			<div class="col-md-9 form-group">
				<label for="title_product">Название</label>
				<input class="col-md-2 form-control" id="title_product" type="text" name="title_product" value="" required>
			</div>
			<div class="col-md-3 form-group">
				<label for="default_price">Цена</label>
				<input class="col-md-1 form-control default_price" id="default_price" type="text" name="default_price" value="" required>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-10 form-group">
				<input type="submit" class="btn btn-default" name="save" value="Сохранить">
			</div>
		</div>
	</form>
	
<?php include("views/layouts/footer.php"); ?>

