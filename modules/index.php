<?php

	session_start();

	if( isset($_SESSION['usuario']) && !empty($_SESSION['usuario']) ){

		switch($_GET['a']){

			case 'Cardapio':
			header("Location: cardapio.php");
			break;

			case 'Logar':
			header("Location: login.php");
			break;

			case 'Pedido':
			header("Location: pedido/pedido.php");
			break;

			case 'Categoria':
			header("Location: categoria/categoria.php");
			break;

			case 'Produto':
			header("Location: produto/produto.php");
			break;

			case 'Configuracao':
			header("Location: configuracao/configuracao.php");
			break;


		}

	}else{

		switch($_GET['a']){

			case 'Cardapio':
			header("Location: cardapio.php");
			break;

			case 'Logar':
			header("Location: login.php");
			break;

		}

	}

?>