
<?php

	#Algoritmo#
	#recuperamos a quantidade de categorias existentes;
	#criamos um enlace para cada categoria, escrevera a categoria e recuperará a lista de produtos
	

	try{
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


		$numero_registros = 10;
		

		$sql2 = $conexao->query("SELECT COUNT(*) as T FROM tb_produtos where produto_apagado = '0';");
		$sql2 = $sql2->fetch();
		$total = $sql2['T'];
		$paginas = ceil($total/$numero_registros);

		$pg = 1;

		if(isset($_GET['p']) && !empty($_GET['p'])){
			$pg = addslashes($_GET['p']);
		}

		$p = ($pg - 1) * $numero_registros;
		

		

		

		#recuperando a lista de registros para preencher a visualização da pagina		

		$querySelect = $conexao->query("SELECT C.categoria_nome,P.produto_nome,P.produto_preco FROM tb_produtos AS P JOIN tb_categorias AS C WHERE P.categoria_id=C.categoria_id AND produto_apagado = '0' union SELECT categoria_id,produto_nome,produto_preco FROM tb_produtos WHERE categoria_id is NULL AND produto_apagado = '0' LIMIT $p, $numero_registros;");

		$dados = $querySelect->fetchAll();



		#Criacao da tabela
		echo "<table width='500' border='1'>";
		echo "<tr>
			<td>Categoria</td>
			<td>Nome</td>
			<td>Preço</td>
			</tr>";
		foreach ($dados as $item) {
			echo "<tr>
				<td>".$item['categoria_nome']."</td>
				<td>".$item['produto_nome']."</td>
				<td>".$item['produto_preco']."</td>
				</tr>";
		}
		
		echo "</table>";



		#Criando os links

		if($paginas>1)
		for ($i=1; $i <= $paginas; $i++) { 
			echo "<a href='index.php?acao=Cardapio&p=".$i."'>[".$i."]</a>";
		}

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
			
	}
?>