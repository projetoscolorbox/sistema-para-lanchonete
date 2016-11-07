carregando usuario...
<form method="GET">
	<input type='submit' value='Buscar os primeiros' >
	<input type='number' size='1' name='quantidade' value=10>
</form>
<?php
	extract($_GET);
	try{

			$pagina = 0;
			$n = 10;
			if (!empty($quantidade)) {
				$n = $quantidade;
			}

			$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());


			$sql = $banco->query("SELECT usuario_id,usuario_nome,usuario_telefone,usuario_email,usuario_data_cadastro FROM tb_usuarios LIMIT $pagina, $n;");
			$total = $banco->query("SELECT COUNT(*) as c FROM tb_usuarios");
			$total = $total->fetch();

			#Criacao da tabela
			echo "<table width='500' border='1'>";
			echo "<tr>
				<td>ID</td>
				<td>Nome Id</td>
				<td>Telefone</td>
				<td>E-mail</td>
				<td>Data de Cadastro</td>
			</tr>";
			foreach ($sql->fetchAll() as $item) {
				echo "<tr>
					<td>".$item['usuario_id']."</td>
					<td>".$item['usuario_nome']."</td>
					<td>".$item['usuario_telefone']."</td>
					<td>".$item['usuario_email']."</td>
					<td>".$item['usuario_data_cadastro']."</td>
				</tr>";
			}
			
			echo "</table>";
			###################################

			#Criando os links###############
			for ($i=1; $i <= $total['c']; $i++) { 
				echo "<a href='./usuario.php?quantidade=".$i."'>[".$i."]</a>";
			}

			################################

		}catch(PDOException $e){

			echo "Falhou".$e->getMessage();
			
		}
?>