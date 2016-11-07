<?php
	session_start();
	include_once 'config.php';
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

		echo "<a href='?acao=Cardapio'>Cardápio</a>";
		if ( isset($_SESSION['configuracao']) ) {

			if($_SESSION['set']['pedido'] == 1){

				echo "<a href='?acao=Pedido'>Pedido</a>";

			}

			if ($_SESSION['set']['categoria'] == 1) {

				echo "<a href='?acao=Categoria'>Categoria</a>";

			}
						
			if($_SESSION['set']['produto'] == 1){

				echo "<a href='?acao=Produto'>Produto</a>";

			}

			if($_SESSION['set']['usuario'] == 1){

				echo "<a href='?acao=Usuario'>Usuário</a>";

			}

			if($_SESSION['set']['configuracao'] == 1){

				echo "<a href='?acao=Configuracao'>Configurações</a>";

			}
		}

		if ( isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {

			echo "<a href='modules/?acao=Deslogar'>Deslogar</a>";

		}else{

			echo "<a href='modules/?acao=Logar'>Login</a>";

		}
			


		?>

		<?php #Usando as funcionalidades permitidas
			echo "<br>";
			if(!isset($_GET['acao'])){
				$_GET['acao'] = "Cardapio";
			}
			
			switch ($_GET['acao']) {

				case 'Cardapio':
					include "modules/cardapio.php";
					break;

				case 'Categoria':
					include "modules/categoria/categoria.php";
					break;
					
				case 'categoria-cadastrar':
					include "modules/categoria/categoria-cadastrar.php";
					break;
					
				case 'categoria-editar':
					include "modules/categoria/categoria-editar.php";
					break;
					
				case 'categoria-excluir':
					include "modules/categoria/categoria-excluir.php";
					break;

				case 'Produto':
					include "modules/produto/produto.php";
					break;		

				case 'produto-cadastrar':
					include "modules/produto/produto-cadastrar.php";
					break;
					
				case 'produto-editar':
					include "modules/produto/produto-editar.php";
					break;
					
				case 'produto-excluir':
					include "modules/produto/produto-excluir.php";
					break;

				case 'Pedido':
					include "modules/pedido/pedido.php";
					break;

				case 'Usuario':
					include "modules/usuario/usuario.php";
					break;

				case 'Configuracao':
					include "modules/configuracao/configuracao.php";
					break;

				case 'Logar':
					header("Location: login.php");
					break;

				case 'Deslogar':
					header("Location: deslogar.php");
					break;
			}
			
		?>

</body>
</html>