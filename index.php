<?php
	session_start();
	require 'config.php';
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='utf8'>

	<?php
		echo "<title>".$config->getEmpresa()."</title>";
	?>
	

</head>
<body>
	<form method='GET' action='modules/'>
		<input type='submit' name=a value='Cardapio'>
		<input type='submit' name=a value='Logar'>
		<?php #carregando as outras permissões caso esteja logado
		
			if ( isset($_SESSION['configuracao']) ) {

				switch ($_SESSION['set']) {

					case $_SESSION['set']['pedido'] == 1:

						echo "<input type='submit' name=a value='Pedido'>";
						
					case $_SESSION['set']['categoria'] == 1:

						echo "<input type='submit' name=a value='Categoria'>";
											
					case $_SESSION['set']['produto'] == 1:

						echo "<input type='submit' name=a value='Produto'>";
											
					case $_SESSION['set']['configuracao'] == 1:

						echo "<input type='submit' name=a value='Configuracao'>";
						
					case true;

						echo "<input type='submit' name=a value='Deslogar'>";
						break;

				}

			}

		?>

	</form>
</body>
</html>