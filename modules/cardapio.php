
<?php

	#Algoritmo#
	#recuperamos a quantidade de categorias existentes;
	#criamos um enlace para cada categoria, escrevera a categoria e recuperará a lista de produtos
	
	#require_once "../config.php";

	try{
		$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
		
		$numero_registros = 10;
		
		

		$sql2 = $banco->query("SELECT COUNT(*) as T FROM tb_produtos;");
		$sql2 = $sql2->fetch();
		$total = $sql2['T'];
		$paginas = $total/$numero_registros;

		$pg = 1;

		if(isset($_GET['p']) && !empty($_GET['p'])){
			$pg = addslashes($_GET['p']);
		}

		$p = ($pg - 1) * $numero_registros;
		

		

		

		#recuperando a lista de registros para preencher a visualização da pagina
		$sql = $banco->query("SELECT C.categoria_nome,P.produto_nome,P.produto_preco from tb_produtos as P join tb_categorias as C where P.categoria_id=C.categoria_id LIMIT $p, $numero_registros;");


		
		

		#Criacao da tabela
		echo "<table width='500' border='1'>";
		echo "<tr>
			<td>Categoria</td>
			<td>Nome</td>
			<td>Preço</td>
			</tr>";
		foreach ($sql->fetchAll() as $item) {
			echo "<tr>
				<td>".$item['categoria_nome']."</td>
				<td>".$item['produto_nome']."</td>
				<td>".$item['produto_preco']."</td>
				</tr>";
		}
		
		echo "</table>";
		################################

		#Criando os links###############

		for ($i=1; $i <= $paginas; $i++) { 
			echo "<a href='./cardapio.php?p=".$i."'>[".$i."]</a>";
		}

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
			
	}
?>