<?php 
	
		
	$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	
	if (isset($_GET['prodID']) && !empty($_GET['prodID'])) {

		$prodID = addslashes($_GET['prodID']);

		$stmtSelect = "SELECT * FROM tb_produtos WHERE produto_id='$prodID';";
		$querySelect = $conexao->query($stmtSelect);
		$produto = $querySelect->fetch();
		$nome = $produto['produto_nome'];
		$preco = $produto['produto_preco'];
		$categoria_id = $produto['categoria_id'];


		##########Montando o combo box####################
		#recuperando os dados
		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT categoria_id,categoria_nome FROM tb_categorias WHERE categoria_apagado = '0';";
		
		$querySelect = $conexao->query($stmtSelect);

		$dadosCB = $querySelect->fetchAll();

		
		#montando o Combo Box

		foreach ($dadosCB as $item) {#para descobrir o nome da $categoria_id
			if($categoria_id == $item['categoria_id']){
				$categoria_nome = $item['categoria_nome'];
			}
		}


		$CB_categorias = "<select name='prodCategoria'>
							<option value='$categoria_id'>$categoria_nome</option>";

		foreach ($dadosCB as $item) {
			
			$id = $item['categoria_id'];
			$categoria_nome = $item['categoria_nome'];

			if($categoria_id != $id){
				$CB_categorias .= "<option value='$id'>$categoria_nome</option>";
			}

		}
		$CB_categorias .= "</select>";

		#teminando de montar o Combo Box#################################################



		$formulario = 
		"<form method='GET'>
			<input type='hidden' name='prodID' value='$prodID'>
			Nome:
			<input type='text' name='prodNome' value='$nome'>
			<br>
			Preco:
			<input type='text' name='prodPreco' value='$preco'>
			<br>
			Categoria:
			$CB_categorias
			<br>
			<input type='submit' name='' value='Editar'>

			<input type='hidden' name='acao' value='produto-editar'>
		</form>";

		echo $formulario;

		if(isset($_GET['prodNome']) && !empty($_GET['prodNome']) ){

			$prodNome = addslashes($_GET['prodNome']);
			$stmtUpdate = "UPDATE tb_produtos SET produto_nome ='$prodNome'";

			if( isset($_GET['prodPreco']) && !empty($_GET['prodPreco'])){

				$prodPreco = addslashes($_GET['prodPreco']);
				$stmtUpdate .= " ,produto_preco ='$prodPreco'"; 

			}

			if( isset($_GET['prodCategoria']) && !empty($_GET['prodCategoria'])){
				$prodCategoria = addslashes($_GET['prodCategoria']);
				$stmtUpdate .= " ,categoria_id ='$prodCategoria'"; 
			}

			$stmtUpdate .= " WHERE produto_id='$prodID';";
			echo $stmtUpdate;
			$queryUpdate = $conexao->query($stmtUpdate);

			header("Location: index.php?acao=Produto");

		}		
		



	}

?>