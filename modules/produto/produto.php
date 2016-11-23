<div class='titulo'>Produtos</div>
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
			echo "<div class='funcao'><a href='index.php?acao=produto-cadastrar'>Cadastrar</a></div>";
		}

		
		$tabela = "<table class='table-conteiner'>
					<tr>
						<th>Nome</th>
						<th>Preço</th>";
		if($editar == 1 || $excluir == 1) {
			$tabela .= "<th>Ação</td>";
		}
		$tabela .= "</tr>";
		
		
		foreach ($sql->fetchAll() as  $item) {
			
			$tabela .= "<tr>
							<td>".$item['produto_nome']."</td>
							<td>".$item['produto_preco']."</td>";

			if($editar == 1 && $excluir == 1){
				$tabela .= "<td><a href='index.php?acao=produto-editar&prodID=".$item['produto_id']."&prodNome=&prodPreco=&prodCategoria="."'>Editar</a><a href='index.php?acao=produto-excluir&prodID=".$item['produto_id']."'>Excluir</a></td>";
			}else if($editar ==1){
				$tabela .= "<td><a href='index.php?acao=produto-editar&prodID=".$item['produto_id']."&prodNome=&prodPreco=&prodCategoria="."'>Editar</a></td>";
			}else if($excluir == 1){
				$tabela .= "<td><a href='index.php?acao=produto-excluir&prodID=".$item['produto_id']."'>Excluir</a></td>";
			}

			$tabela .= "</tr>";
			
		}
		$tabela .= "</table>";
		echo $tabela;
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