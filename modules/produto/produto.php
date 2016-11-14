<?php
	extract($_GET);
	try{

		$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
		

		$numero_registros = 10;
		
		

		$sql2 = $banco->query("SELECT COUNT(*) as T FROM tb_produtos where produto_apagado = '0';");
		$sql2 = $sql2->fetch();
		$total = $sql2['T'];
		$paginas = ceil($total/$numero_registros);

		$pg = 1;

		if(isset($_GET['p']) && !empty($_GET['p'])){
			$pg = addslashes($_GET['p']);
		}

		$p = ($pg - 1) * $numero_registros;


		$sql = $banco->query("SELECT produto_id,produto_nome,produto_preco FROM tb_produtos WHERE produto_apagado !='1' LIMIT $p, $numero_registros;");

		#carregando as configurações da pagina de produto##########
		$usuario_id = $_SESSION['usuario'];
		$cadastrar = $_SESSION['set']['produto_cadastrar'];
		$editar = $_SESSION['set']['produto_editar'];
		$excluir = $_SESSION['set']['produto_excluir'];



		if($cadastrar == 1){
			echo "<a href='index.php?acao=produto-cadastrar'>Cadastrar</a>";
		}

		
		echo "<table width='500' border='1'>";
		echo "<tr>";
		echo	"<th>Nome</td>";
		echo 	"<th>Preço</td>";
		if($editar == 1 || $excluir == 1) {
			echo "<th>Ação</td>";
		}
		echo "</tr>";
		
		
		foreach ($sql->fetchAll() as  $item) {
			
			echo "<tr>";
			echo	"<td>".$item['produto_nome']."</td>";
			echo 	"<td>".$item['produto_preco']."</td>";

			if($editar == 1 && $excluir == 1){
				echo "<td><a href='index.php?acao=produto-editar&prodID=".$item['produto_id']."&prodNome=&prodPreco=&prodCategoria="."'>Editar</a><a href='index.php?acao=produto-excluir&prodID=".$item['produto_id']."'>Excluir</a></td>";
			}else if($editar ==1){
				echo "<td><a href='index.php?acao=produto-editar&prodID=".$item['produto_id']."&prodNome=&prodPreco=&prodCategoria="."'>Editar</a></td>";
			}else if($excluir == 1){
				echo "<td><a href='index.php?acao=produto-excluir&prodID=".$item['produto_id']."'>Excluir</a></td>";
			}

			echo "</tr>";
			
		}
		echo "</table>";
		###########################################################
			
		
		#Criando os links de paginação dos registros###############
		if($paginas>1)
		for ($i=1; $i <= $paginas; $i++) { 
			echo "<a href='index.php?acao=Produto&p=".$i."'>[".$i."]</a>";
		}
		###########################################################
	

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
		
	}
?>