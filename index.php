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
	
		
		<?php #carregando as outras permissões caso esteja logado

		//echo "<input type='submit' name='acao' value='Cardapio'>";
		echo "<a href='modules/index.php?acao=Cardapio'>Cardápio</a>";
			if ( isset($_SESSION['configuracao']) ) {

				if($_SESSION['set']['pedido'] == 1){
					//echo "<input type='submit' name='acao' value='Pedido'>";
					echo "<a href='modules/index.php?acao=Pedido'>Pedido</a>";
				}

				if ($_SESSION['set']['categoria'] == 1) {
					//echo "<input type='submit' name='acao' value='Categoria'>";
					echo "<a href='modules/index.php?acao=Categoria'>Categoria</a>";
				}
						
				if($_SESSION['set']['produto'] == 1){
					//echo "<input type='submit' name='acao' value='Produto'>";
					echo "<a href='modules/index.php?acao=Produto'>Produto</a>";
				}
											
				if($_SESSION['set']['usuario'] == 1){
					//echo "<input type='submit' name='acao' value='Usuario'>";
					echo "<a href='modules/index.php?acao=Usuario'>Usuário</a>";
				}

				if($_SESSION['set']['configuracao'] == 1){
					//echo "<input type='submit' name='acao' value='Configuracao'>";
					echo "<a href='modules/index.php?acao=Configuracao'>Configurações</a>";
				}

			}

			if ( isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {
				//echo "<input type='submit' name='acao' value='Deslogar'>";
				echo "<a href='modules/index.php?acao=Deslogar'>Deslogar</a>";
			}else{
				//echo "<input type='submit' name='acao' value='Logar'>";
				echo "<a href='modules/index.php?acao=Logar'>Login</a>";
			}
			

		?>

		<?php #carregando o corpo com as funções do site
			
		?>

	
</body>
</html>