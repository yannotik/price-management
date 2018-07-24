<!-- 
create table products (
id int (10) AUTO_INCREMENT,
name varchar(100) NOT NULL,
default_price int(10) NOT NULL,
creation_date datetime NOT NULL,
PRIMARY KEY (id)
); 

create table price (
id int (10) AUTO_INCREMENT,
product_id int (10) NOT NULL,
start_date datetime NOT NULL,
finish_date datetime NOT NULL,
creation_date datetime NOT NULL,
price int(10) NOT NULL,
PRIMARY KEY (id)
);  

-->
<?
$host = '******';
$database = '******';
$user = '******';
$password = '******';

$link = mysqli_connect($host, $user, $password, $database) or die("Error " . mysqli_error($link));
