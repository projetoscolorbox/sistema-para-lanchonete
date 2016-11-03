carregando produto...
<form method="GET">
	<input type='submit' value='Buscar os primeiros' >
	<input type='number' size='1' name='quantidade' value=10>
</form>
<?php
	require_once "../../config.php";
	extract($_GET);
	try{

			$pagina = 0;
			$n = 10;
			if (!empty($quantidade)) {
				$n = $quantidade;
			}

			$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


			$sql = $banco->query("SELECT produto_id,produto_nome,produto_preco FROM tb_produtos LIMIT $pagina, $n;");
			$total = $banco->query("SELECT COUNT(*) as c FROM tb_produtos");
			$total = $total->fetch();

			#Criacao da tabela
			echo "<table width='500' border='1'>";
			echo "<tr>
				<td>ID</td>
				<td>Nome</td>
				<td>Preço</td>
			</tr>";
			foreach ($sql->fetchAll() as $item) {
				echo "<tr>
					<td>".$item['produto_id']."</td>
					<td>".$item['produto_nome']."</td>
					<td>".$item['produto_preco']."</td>
				</tr>";
			}
			
			echo "</table>";
			###################################

			#Criando os links###############
			for ($i=1; $i <= $total['c']; $i++) { 
				echo "<a href='./produto.php?quantidade=".$i."'>[".$i."]</a>";
			}

			################################

		}catch(PDOException $e){

			echo "Falhou".$e->getMessage();
			
		}
?>