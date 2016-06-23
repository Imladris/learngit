<?php
try{
    $pdo = new PDO("mysql:host=".SAE_MYSQL_HOST_M.";port=".SAE_MYSQL_PORT.";dbname=".SAE_MYSQL_DB, SAE_MYSQL_USER, SAE_MYSQL_PASS);
    //$pdo = new PDO('mysql:host=SAE_MYSQL_HOST_M;dbname=SAE_MYSQL_DB','SAE_MYSQL_USER','SAE_MYSQL_PASS');
	$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
}catch(PDOException $e){
	//echo "can't link mysql datebase";
	exit();
}
?>
