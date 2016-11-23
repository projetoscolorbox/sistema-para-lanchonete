<?php

	try{
		$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());

	
		#Recuperando as categorias
		$querySelectCategoria = $conexao->query("SELECT categoria_id,categoria_nome from tb_categorias where categoria_apagado='0' order by categoria_nome;");
		$dadosCategoria = $querySelectCategoria->fetchAll();


		#Recuperando os produtos
		$querySelectProduto = $conexao->query("SELECT categoria_id,produto_nome,produto_preco,produto_id from	tb_produtos where produto_apagado='0' order by categoria_id,produto_nome;");
		$dadosProduto = $querySelectProduto->fetchAll();

		#Montando o cardapio adjunto ao formulario
		$Formulario_Pedido = "<div class='funcao'><form method='POST'>";
		$cardapio = "";
		foreach ($dadosCategoria as $categoria) {

			$cardapio .="<table class='table-conteiner'>
							<tr>
								<th colspan='3'>".$categoria['categoria_nome']."</th>
							</tr>";

			foreach ($dadosProduto as $produto) {
						if($produto['categoria_id']==$categoria['categoria_id']){
							$cardapio .="<tr>
								<td width='150'>".$produto['produto_nome']."</td>
								<td>".$produto['produto_preco']."</td>
								<td align='right'>Quantidade:<input type='number' name='item_quantidade[]'>
															<input type='hidden' name='produto_id[]' value='".$produto['produto_id']."'>
															<input type='hidden' name='produto_preco[]' value='".$produto['produto_preco']."'>
								</td>";

						}
			}

			$cardapio .="	</tr>
						</table>";
		}

		$Formulario_Pedido .= $cardapio."<input type='submit' value='Montar Pedido' class='botao-sucesso'>
			</form></div>";
		echo $Formulario_Pedido;

		//usando o formulario para salvar o Pedido

		//Se o formulario n foi iniciado e n estiver vazio
		if( isset($_POST) && !empty($_POST) ){

			//dentro dos fomularios
			
			$conexao = new Banco($_SERVER['HTTP_HOST'],$config->getBaseDados(),$config->getLogin(),$config->getSenha());

			//Preparando a gravação do pedido
			$pedidos = array(
				'pedido_data' => date("Y-m-d H:i:s"),
				'pedido_apagado' => '0',
				'usuario_id' => $_SESSION['usuario'],
				'pedido_andamento' => 'Aguardando Recepção'
			);
			//Recuperando o id do pedido para usar na gravacao do item e gravando o pedido
			$pedido_id = $conexao->insert("tb_pedidos",$pedidos);



			//Antes de gravar os itens do pedido temos que eliminar do formulario os itens que n foram escolhidos
			$itens = $_POST;

			$linhas = 0;
			foreach ($itens as $valor) {
				
				$linhas = count($valor);
			}

			$balanco = 0;
			for($i=0; $i<$linhas; $i++){

				if( ($itens['item_quantidade'][$i] == NULL) || ($itens['item_quantidade'][$i] == "") || ($itens['item_quantidade'][$i] <= '0')){ //rearrumando os indices
					unset($itens['item_quantidade'][$i]);
					unset($itens['produto_preco'][$i]);
					unset($itens['produto_id'][$i]);
				}else{
					$itens['pedido_id'][$i] = $pedido_id;
				}
			}


			
			if($pedido_id != 0){
				$conexao->insertValues("tb_itens",$itens); // gravacao dos itens
			}

			//Checando se n gravamos um pedido sem itens
			$conexao = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
			$stmtSelect = "SELECT item_id FROM tb_itens WHERE pedido_id='$pedido_id';";
			$querySelect = $conexao->query($stmtSelect);
			$dados = $querySelect->fetchAll();

			print_r($dados);		
			if( empty($dados) ){
				$stmtUpdate = "UPDATE tb_pedidos SET pedido_apagado ='1' WHERE pedido_id ='$pedido_id';";
				$conexao->query($stmtUpdate);
			}
				
			

			header("Location: index.php?acao=Pedido");

		}

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
			
	}
	
?>