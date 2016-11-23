<div class='titulo'>Usuarios</div>
<?php
	
	
	extract($_GET);
	try{

		$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
		

		$numero_registros = 10;
		

		$sql2 = $banco->query("SELECT COUNT(*) as T FROM tb_usuarios where usuario_apagado = '0';");
		$sql2 = $sql2->fetch();
		$total = $sql2['T'];
		$paginas = ceil($total/$numero_registros);

		$pg = 1;

		if(isset($_GET['p']) && !empty($_GET['p'])){
			$pg = addslashes($_GET['p']);
		}

		$p = ($pg - 1) * $numero_registros;


		$sql = $banco->query("SELECT usuario_nome,usuario_id FROM tb_usuarios WHERE usuario_apagado !='1' LIMIT $p, $numero_registros;");

		#carregando as configurações###############################
		$usuario_id = $_SESSION['usuario'];
		$cadastrar = $_SESSION['set']['usuario_cadastrar'];
		$editar = $_SESSION['set']['usuario_editar'];
		$excluir = $_SESSION['set']['usuario_excluir'];



		if($cadastrar == 1){
			echo "<div class='funcao'><a href='index.php?acao=usuario-cadastrar'>Cadastrar</a></div>";
		}

		
		echo "<table class='table-conteiner'>";
		echo "<tr>";
		echo	"<th>Nome</th>";
		if($editar == 1 || $excluir == 1) {
			echo "<th>Ação</th>";
		}
		echo "</tr>";
		
		
		foreach ($sql->fetchAll() as  $item) {

			echo "<tr>";

			echo	"<td>".$item['usuario_nome']."</td>";

			if($editar == 1 && $excluir == 1){
				echo "<td><a href='index.php?acao=usuario-editar&userID=".$item['usuario_id']."'>Editar</a><a href='index.php?acao=usuario-excluir&userID=".$item['usuario_id']."'>Excluir</a></td>";
			}else if($editar ==1){
				echo "<td><a href='index.php?acao=usuario-editar&userID=".$item['usuario_id']."'>Editar</a></td>";
			}else if($excluir == 1){
				echo "<td><a href='index.php?acao=usuario-excluir&userID=".$item['usuario_id']."'>Excluir</a></td>";
			}

			echo "</tr>";
			
		}
		echo "</table>";
		###########################################################
			

		#Criando os links de paginação dos registros###############
		if($paginas>1)
		for ($i=1; $i <= $paginas; $i++) { 
			echo "<a href='index.php?acao=Usuario&p=".$i."'>[".$i."]</a>";
		}
		###########################################################
	

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
		
	}


			
?>