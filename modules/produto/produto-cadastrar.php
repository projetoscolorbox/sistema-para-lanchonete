<?php
	
	
	
	if( isset($_GET['prodNome']) ){

		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		if($_GET['prodNome']!=NULL)
		{
			$produto_nome = addslashes($_GET['prodNome']);
			$stmtInsert = "INSERT INTO tb_produtos SET produto_nome ='$produto_nome',";
		}
		else
		{
			echo "Faltou preencher o nome do produto";
			header("Refresh:2; index.php?acao=produto-cadastrar");
			exit;	
		}

		

		if(isset($_GET['prodPreco']) && !empty($_GET['prodPreco'])){

			$produto_preco = addslashes($_GET['prodPreco']);
			$stmtInsert .= "produto_preco ='$produto_preco',";

		}

		if(isset($_GET['prodCategoria'])){

			$categoria = $_GET['prodCategoria'];

			$stmtInsert .= "categoria_id = ".$categoria.", produto_apagado = '0';";

		}else{

			$stmtInsert .= " produto_apagado = '0';";

		}

		

		$queryUpdate = $conexao->query($stmtInsert);
		$total = $queryUpdate->rowCount();

		if($total>0){

			header("Location: index.php?acao=Produto");

		}

		
	}

	
?>
<div class='titulo'>Cadastrar Produto</div>
<div class='formulario'>
<form method='GET'>
	Nome:
	<input type='text' name='prodNome'>
	<br>
	Preço:
	<input type='text' name='prodPreco'>
	<br>
	<?php # recupera as categorias existentes no banco e cria o ComboBox

		#recuperando os dados
		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		$stmtSelect = "SELECT categoria_id,categoria_nome FROM tb_categorias WHERE categoria_apagado = '0';";
		
		$querySelect = $conexao->query($stmtSelect);

		$dadosCB = $querySelect->fetchAll();



		#montando o Combo Box
		$CB_categorias = "Categoria: <select name='prodCategoria'>";

		foreach ($dadosCB as $item) {
			
			$id = $item['categoria_id'];
			$nome = $item['categoria_nome'];

			$CB_categorias .= "<option value='$id'>$nome</option>";

		}
		$CB_categorias .= "</select>";

		echo $CB_categorias;

	?>
	<br>
	<input type='submit' name='' value='Cadastrar'>
	<input type='hidden' name='acao' value='produto-cadastrar'>
</form>
</div>