
<?

include("config.php");
global $link;

$query = "SELECT * FROM products";
$res = mysqli_query($link, $query);
$product = array();
$i = 0;
if (mysqli_num_rows($res) > 0) {
    while ($row = mysqli_fetch_array($res)) {
        $product[$i]["id"] = $row["id"];
        $product[$i]["name"] = $row["name"];
        $product[$i]["default_price"] = $row["default_price"];
        $i++;
    }
}	

if ($_POST["delete_product_id"]) {
    mysqli_query($link, "DELETE FROM products WHERE id = " . (int)$_POST["delete_product_id"] . "");
	header("Location: /index.php", true, 301);
    exit();
}
?>

<?php include("views/layouts/header.php"); ?>
	<br>
	<div class="row">
		<div class="col-md-3"><a class="btn btn-default" href="add.php" role="button">Создать товар</a></div>
		<div class="col-md-3"><a class="btn btn-default" href="show.php" role="button">Посмотреть актуальные цены</a></div>
	</div>	
	<br>
	<table class="table table-bordered">
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>Удалить</th>
	</tr>

	<?
	foreach ($product as $key => $value) { ?>
		<tr>
			<td><?= $value["id"]; ?></td>
			<td><a href="item.php?edit=<?= $value["id"]; ?>"><?= $value["name"]; ?></a></td>
			<td>
			<form method="post" action="">
				<a href="#" onclick="delete_product(<?= $value['id'] ?>)">Удалить</a>
			</form>	
			</td>
		</tr>
	<? } ?>
	</table>

<?php include("views/layouts/footer.php"); ?>
