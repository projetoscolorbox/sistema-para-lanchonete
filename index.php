<?php

	//iniciando as informações do site
	session_start();
	include_once 'config.php';
	require_once "modules/banco_mysql.php";
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
	<meta charset='utf8'>
	<meta id='viewport' name='viewport' content='width=device-width, user-scalable-no'>

	<?php

		//nomeando o site
		echo "<title>".$config->getEmpresa()."</title>";

		// resetando style padrão dos navegadores
		echo "<link href='assets/css/reset.css' rel='stylesheet'>";

		//definindo o style do site
		echo "<link href='assets/css/style.css' rel='stylesheet'>";
	?>
	

</head>
<body>
	
		
<?php 
	
	//Apresenta a logo
	echo "<div class='logo-barra'></div>";
	

	if(isset($_SESSION['nome'])){
		echo "<div class='welcome'>Bem vindo ao ".$config->getEmpresa()." ".$_SESSION['nome']."</div>";
	}

	//criando a barra de menu
	echo "<div class='menu'>
			<ul>";
	echo "<li><a href='?acao=Cardapio'>Cardápio</a></li>";



	//carregando as outras permissões caso esteja logado

	if ( isset($_SESSION['configuracao']) ) {

		if($_SESSION['set']['pedido'] == 1){

			echo "<li><a href='?acao=Pedido'>Pedido</a></li>";

		}

		if ($_SESSION['set']['categoria'] == 1) {

			echo "<li><a href='?acao=Categoria'>Categoria</a></li>";

		}
					
		if($_SESSION['set']['produto'] == 1){

			echo "<li><a href='?acao=Produto'>Produto</a></li>";

		}

		if($_SESSION['set']['usuario'] == 1){

			echo "<li><a href='?acao=Usuario'>Usuário</a></li>";

		}

		if($_SESSION['set']['configuracao'] == 1){

			//echo "<li><a href='?acao=Configuracao'>Configurações</a></li>";

		}
	}

	if ( isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])) {

		echo "<li><a href='modules/?acao=Deslogar'>Deslogar</a></li>";

	}else{

		echo "<li><a href='?acao=Logar'>Login</a></li>";

	}
		
	echo "</ul>
	</div>";

?>

<?php 

	//Usando as funcionalidades permitidas
	
	echo "<br>";
	
	if( isset($_SESSION['configuracao']) && $_SESSION['configuracao']==1 && !isset($_GET['acao']) ){
		$_GET['acao'] = "Pedido";
	}else if( !isset($_GET['acao']) ){
		$_GET['acao'] = "Cardapio";
	}
	
	
	switch ($_GET['acao']) {

		case 'cliente-cadastrar':
			include "modules/cliente-cadastrar.php";
			break;

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

		case 'pedido-abrir':
			include "modules/pedido/pedido-abrir.php";
			break;

		case 'pedido-gerenciar':
			include "modules/pedido/pedido-gerenciar.php";
			break;

		case 'pedido-finalizar':
			include "modules/pedido/pedido-finalizar.php";
			break;

		case 'Usuario':
			include "modules/usuario/usuario.php";
			break;

		case 'usuario-cadastrar':
			include "modules/usuario/usuario-cadastrar.php";
			break;

		case 'usuario-editar':
			include "modules/usuario/usuario-editar.php";
			break;

		case 'usuario-excluir':
			include "modules/usuario/usuario-excluir.php";
			break;

		case 'Configuracao':
			include "modules/configuracao/configuracao.php";
			break;

		case 'Logar':
			include "modules/login.php";
			break;

		case 'Deslogar':
			header("Location: deslogar.php");
			break;
	}
	
?>

</body>
</html>