<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="/template/css/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/template/css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
	<script src="/template/js/Chart.min.js"></script>
	
	<script type="text/javascript">
		function delete_product(id){
			$.ajax({
			  type: "POST",
			  url: '/index.php',
			  data: {
					delete_product_id: id
				},
			  success: function(data){window.location="/index.php";},
			  dataType: 'json'
			});
		};
	</script>
	<!-- item -->
	<script type="text/javascript">
		function delete_period(id){
			$.ajax({
			  type: "POST",
			  url: '/item.php',
			  data: {
						delete_period_id: id
				},
			  success: function(data){console.log(data);},
			  dataType: 'json'
			});
		};
		$(document).ready(function(){
		  
			$(".add_price").click(function(){
				$(this).parent().parent().append('<div class="row form-group"><div class="col-md-3"><label for="start_date">В период с </label><input class="form-control" type="date" id="start_date" name="start_date" required></div><div class="col-md-3"><label for="finish_date">В период по </label><input class="form-control" type="date" id="finish_date" name="finish_date" required></div><div class="col-md-3 "><label for="price_">Цена</label><input class="form-control" type="text" id="price_" name="price" required></div><div class="col-md-2 col-md-offset-1"><br><input type="submit" class="btn btn-default" name="save" value="Сохранить"></div></div>');
			});
		});

	</script>
</head>
<body>
	<div class="container">