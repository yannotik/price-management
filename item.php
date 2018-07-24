<?
include("config.php");
global $link;

$id = $_GET["edit"]; 
$query_price = "SELECT * FROM price WHERE product_id = " . (int)$id . " ORDER BY start_date ";
$query_product = "SELECT * FROM products WHERE id = ".(int)$id;
$product = array();
$product_fields = array();
$res = mysqli_query($link, $query_product); 
if (mysqli_num_rows($res) >= 1) { 
	$i = 0; 
  	if ($row = mysqli_fetch_array($res)) {
       	$product[$i]["id"] = $row["id"];         
		$product[$i]["name"] = $row["name"];
		$product[$i]["default_price"] = $row["default_price"];
		$product[$i]["creation_date"] = $row["creation_date"];
        $i++;
    }
}

$res = mysqli_query($link, $query_price); 
if (mysqli_num_rows($res) >= 1) { 

	$i = 0; 
  	while ($row = mysqli_fetch_array($res)) {
		$product_fields[$i]["id"] = $row["id"];         
		$product_fields[$i]["product_id"] = $row["product_id"];         
		$product_fields[$i]["start_date"] = $row["start_date"];         
		$product_fields[$i]["finish_date"] = $row["finish_date"];         
		$product_fields[$i]["creation_date"] = $row["creation_date"];         
		$product_fields[$i]["price"] = $row["price"];  
		
        $i++;
    }
   
}


if(!empty($_POST["start_date"]) && !empty($_POST["finish_date"]) && !empty($_POST["price"])){     
	$start_date = $_POST["start_date"];
	$finish_date = $_POST["finish_date"];     
	$price = (int)$_POST["price"];
	$creation_date = date("Y-m-d H:i:s");     

	$sql = mysqli_query($link, "INSERT INTO price (product_id, start_date, finish_date, creation_date, price) VALUES (".(int)$id.", '" . $start_date . "', '" . $finish_date . "', '" . $creation_date . "', " . $price . ")");

	header ('Location: /item.php?edit='.$id);
	exit(); 
} 

if($_POST["edit"]){     
	$title = $_POST["title"];
	$default_price = $_POST["default_price"];     
	
	mysqli_query($link, "UPDATE products SET name = '" . $title . "', default_price = '" . $default_price ."' WHERE id = " . $id . "");    

	header ('Location: /item.php?edit='.$id);
	exit(); 
}
	
if ($_POST["delete_period_id"]) {
    mysqli_query($link, "DELETE FROM price WHERE id = " . (int)$_POST["delete_period_id"] . "");
}

$arr_dates = [];
$arr_prices = [];

foreach ($product_fields as $value) {
	$start_date  = substr($value["start_date"], 0, strpos($value["start_date"], ' '));
	$finish_date = substr($value["finish_date"], 0, strpos($value["finish_date"], ' ')); 
	$arr_dates[]   = $start_date . ' - ' .  $finish_date;
	$arr_prices[] = $value["price"];
	
}
if(empty($arr_prices)){
	foreach ($product as $value) {
		$start_date  = substr($value["creation_date"], 0, strpos($value["creation_date"], ' '));
		$finish_date = date("Y-m-d"); 

		$arr_prices[] = $value["default_price"];
		$arr_dates[]   = $start_date . ' - ' .  $finish_date;
	}
}

?>


<?php include("views/layouts/header.php"); ?>
	<div class="row">
		<div class="col-md-3"><br>
			<a class="btn btn-default" href="index.php" role="button">Вернуться к списку</a>
		</div>
	</div><br>
	<?
	foreach ($product as $key => $value) { ?>
		<div class="row">
			<div class="col-md-12"><h1><?= $value["name"]; ?></h1></div>
		</div>	
		
		<form method="post" action="">
			<div class="row">
				<div class="col-md-6  form-group">
					<label for="title_price">Название</label>
					<input class="col-md-2 form-control" id="title" type="text" name="title" value="<?= $value["name"] ?>">
				</div>
				<div class="col-md-3  form-group">
					<label for="title_price">Цена по умолчанию</label>
					<input class="col-md-2 form-control" id="title_price" type="text" name="default_price" value="<?= $value["default_price"] ?>">
				</div>
				<div class="col-md-2 col-md-offset-1 form-group">
					<label for="default_price">Добавить период</label>
					<input class="col-md-1 form-control add_price" type="button" name="add_price" value="+">
				</div>
			</div>
			<br>
			<?
			foreach ($product_fields as $k => $val) { ?>
			<div class="row">
				<div class="col-md-3">
					<label for="start_date_<?= $val['id'] ?>">В период с </label>
					<input class="form-control" type="text" name="start_date_<?= $val['id'] ?>" value="<?= $val['start_date'] ?>">
				</div>
				<div class="col-md-3">
					<label for="finish_date_<?= $val['id'] ?>">В период по </label>
					<input class="form-control" type="text" name="finish_date_<?= $val['id'] ?>" value="<?= $val['finish_date'] ?>">
				</div>
				<div class="col-md-3">
					<label for="price_<?= $val['id'] ?>">Цена</label>
					<input class="form-control" type="text" name="price_<?= $val['id'] ?>" value="<?= $val['price'] ?>">
				</div>
				<div class="col-md-2 col-md-offset-1"><br>
					<a class="btn btn-default delete" href="#" onclick="delete_period(<?= $val['id'] ?>)" name="delete_date_<?= $val['id'] ?>" role="button">Удалить</a>
				</div>
			</div>
			<? } ?>
			<br>
			<div class="row">
				<div class="col-md-6">
					<input type="submit" class="btn btn-default" name="edit" value="Редактировать">
				</div>
				
			</div>
		</form>
			
		
	<? }  ?>

<canvas id="densityChart" width="200" height="100"></canvas>
<script type="text/javascript">
	var densityCanvas = document.getElementById("densityChart");
	
	var arr_dates = JSON.parse('<?php echo JSON_encode($arr_dates);?>');
	var arr_prices = JSON.parse('<?php echo JSON_encode($arr_prices);?>');

	Chart.defaults.global.defaultFontFamily = "Lato";
	Chart.defaults.global.defaultFontSize = 12;

	var densityData = {
	  label: 'График изменения цены',
	  data: arr_prices
	};

	var barChart = new Chart(densityCanvas, {
	  type: 'bar',
	  data: {
	    labels: arr_dates,
	    datasets: [densityData]
	  }
	});
</script>
<?php include("views/layouts/footer.php"); ?>


