<?php
	

	if(isset($_GET['catNome'])){

		$conexao =  new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

		if($_GET['catNome']!=NULL)
		{
			$categoria_nome = addslashes($_GET['catNome']);
			$stmtInsert = "INSERT INTO tb_categorias SET categoria_nome ='$categoria_nome', categoria_apagado = '0';";
		}
		else
		{
			echo "Faltou preencher o nome da categoria";
			header("Refresh:2; index.php?acao=categoria-cadastrar");
			exit;	
		}
		
		$queryInsert = $conexao->query($stmtInsert);
		$total = $queryInsert->rowCount();
		
		if($total > 0){
			
			header("Location: index.php?acao=Categoria");
			
		}

	}
	
?>
<div class='titulo'>Cadastrar Categoria</div>
<div class='formulario'>
<form method='GET' >
	Nome:
	<input type='text' name='catNome'>
	<br>
	<input type='submit' name='' value='Cadastrar'>
	<input type='hidden' name='acao' value='categoria-cadastrar'>
</form>
</div>