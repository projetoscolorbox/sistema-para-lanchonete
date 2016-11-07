
<?php
	#session_start();
	#require_once "../config.php";
	
	extract($_GET);
	try{

		$banco = new PDO("mysql:dbname=".$config->getBaseDados().";host=".$_SERVER['HTTP_HOST'].";charset=utf8",$config->getLogin(),$config->getSenha());
		

		$numero_registros = 10;
		

		$sql2 = $banco->query("SELECT COUNT(*) as T FROM tb_categorias where categoria_apagado = '0';");
		$sql2 = $sql2->fetch();
		$total = $sql2['T'];
		$paginas = $total/$numero_registros;

		$pg = 1;

		if(isset($_GET['p']) && !empty($_GET['p'])){
			$pg = addslashes($_GET['p']);
		}

		$p = ($pg - 1) * $numero_registros;


		$sql = $banco->query("SELECT categoria_nome,categoria_id FROM tb_categorias WHERE categoria_apagado !='1' LIMIT $p, $numero_registros;");

		#carregando as configurações###############################
		$usuario_id = $_SESSION['usuario'];
		$cadastrar = $_SESSION['set']['categoria_cadastrar'];
		$editar = $_SESSION['set']['categoria_editar'];
		$excluir = $_SESSION['set']['categoria_excluir'];



		if($cadastrar == 1){
			echo "<a href='index.php?acao=categoria-cadastrar'>Cadastrar</a>";
		}

		
		echo "<table width='500' border='1'>";
		echo "<tr>";
		echo	"<td>Nome</td>";
		if($editar == 1 || $excluir == 1) {
			echo "<td>Ação</td>";
		}
		echo "</tr>";
		
		
		foreach ($sql->fetchAll() as  $item) {

			echo "<tr>";

			echo	"<td>".$item['categoria_nome']."</td>";

			if($editar == 1 && $excluir == 1){
				echo "<td><a href='index.php?acao=categoria-editar&catID=".$item['categoria_id']."'>Editar</a><a href='index.php?acao=categoria-excluir&catID=".$item['categoria_id']."'>Excluir</a></td>";
			}else if($editar ==1){
				echo "<td><a href='index.php?acao=categoria-editar&catID=".$item['categoria_id']."'>Editar</a></td>";
			}else if($excluir == 1){
				echo "<td><a href='index.php?acao=categoria-excluir&catID=".$item['categoria_id']."'>Excluir</a></td>";
			}

			echo "</tr>";
			
		}
		echo "</table>";
		###########################################################
			

		#Criando os links de paginação dos registros###############
		for ($i=1; $i <= $paginas; $i++) { 
			echo "<a href='modules/categoria/categoria.php?p=".$i."'>[".$i."]</a>";
		}
		###########################################################
	

	}catch(PDOException $e){

		echo "Falhou".$e->getMessage();
		
	}


			
?>