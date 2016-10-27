<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='utf8'>

	<?php
		require 'config.php';

		echo "<title>".$config->getEmpresa()."</title>";
	?>
	
	<link rel="stylesheet" href="../template/assets/css/style.css">

</head>
<body>
	<?php 
	//esta logado?
	//caso s
		//include "../template/modules/carregar_funcionalidades.php"
	//caso n
		include "../template/modules/usuario/login.php";
	?>
</body>
</html>