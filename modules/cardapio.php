
<?php

	try{
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	
		#Recuperando as categorias
		$querySelectCategoria = $conexao->query("SELECT categoria_id,categoria_nome from tb_categorias where categoria_apagado='0' order by categoria_nome;");
		$dadosCategoria = $querySelectCategoria->fetchAll();


		#Recuperando os produtos
		$querySelectProduto = $conexao->query("SELECT categoria_id,produto_nome,produto_preco from	tb_produtos where produto_apagado='0' order by categoria_id,produto_nome;");
		$dadosProduto = $querySelectProduto->fetchAll();

		#Montando o cardapio
		$cardapio = "";
		foreach ($dadosCategoria as $categoria) {

			$cardapio .="<table width='500' border='1'>
							<tr>
								<th colspan='2'>".$categoria['categoria_nome']."</td>
							</tr>";

			foreach ($dadosProduto as $produto) {
						if($produto['categoria_id']==$categoria['categoria_id']){
							$cardapio .="<tr><td>".$produto['produto_nome']."</td>";
							$cardapio .="<td>".$produto['produto_preco']."</td>";
						}
			}

			$cardapio .="	</tr>
						</table>";
		}

		echo $cardapio;

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
			
	}
?>