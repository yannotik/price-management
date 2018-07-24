<?
include("config.php");
global $link;


$query = "SELECT p.product_id, p.price, p.finish_date, p.start_date, MIN(DATEDIFF( p.start_date,NOW())) , MIN(DATEDIFF( p.finish_date,NOW())) AS date_diff
			FROM price p
			WHERE p.finish_date >= NOW() 
			AND p.start_date <= NOW()
			GROUP BY p.id, p.product_id
			ORDER BY date_diff DESC
";

$res = mysqli_query($link, $query);

$product_actual_prices = [];
$product_start_date = [];
$product_finish_date = [];
$product = array();

while ($row = mysqli_fetch_array($res)) {
	$product_actual_prices[$row['product_id']] = $row['price'];
	$product_start_date[$row['product_id']]    = $row['start_date'];
	$product_finish_date[$row['product_id']]   = $row['finish_date'];
}

$query = "SELECT pro.id, pro.name, pro.default_price
 			FROM products pro ";


$res = mysqli_query($link, $query); 
if (mysqli_num_rows($res) >= 1) { 
	$i = 0; 
  	
  	while ($row = mysqli_fetch_array($res)) {

        $product[$i]["id"] = $row["id"];         
		$product[$i]["name"] = $row["name"];
		$product[$i]["default_price"] = $row["default_price"];
				
		if(array_key_exists( $row["id"], $product_start_date)){
			$product[$i]["start_date"] = $product_start_date[$row['id']];
		}else{
			$product[$i]["start_date"] = $row["start_date"];
		}
		
		if(array_key_exists( $row["id"], $product_finish_date)){
			$product[$i]["finish_date"] = $product_finish_date[$row['id']];
		}

		if(array_key_exists( $row["id"], $product_actual_prices)){
			$product[$i]["price"] = $product_actual_prices[$row['id']];
		}else{
			$product[$i]["price"] = $row["default_price"];
		}

		$i++;
    }
}

?>

<?php include("views/layouts/header.php"); ?>
	<div class="row">
		<div class="col-md-3"><br>
			<a class="btn btn-default" href="index.php" role="button">Вернуться к списку</a>
		</div>
	</div><br>
	<h1>Список товаров</h1>
	<table class="table table-bordered">
		<tr>
			<th>
				Название
			</th>
			<th>
				Базовая цена
			</th>
			<th>
				Уктуальная цена
			</th>
			<th>
				Период с
			</th>
			<th>
				Пероид по
			</th>
		</tr>	
	<?
	foreach ($product as $key => $value) { ?>
		<tr>
			<td>
				<a href="item.php?edit=<?= $value["id"] ?>"><?= $value["name"] ?></a>
			</td>
			<td>
				<?= $value["default_price"] ?>
			</td>
			<td>
				<?= $value["price"] ?>
			</td>
			<td>
				<?= $value["start_date"] ?>
			</td><td>
				<?= $value["finish_date"] ?>
			</td>
		</tr>
	<? } ?>
	</table>

<?php include("views/layouts/footer.php"); ?>
