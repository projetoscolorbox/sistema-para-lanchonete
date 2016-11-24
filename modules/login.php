<?php
	//se estiver logado redireciona para a pagina inicial
	
	if( isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])){
		header("Location: index.php");
	}
	
?>
<div class='titulo'>Logar</div>
<div class='formulario'>
<form method='POST' action='modules/carregar_funcionalidades.php'>
		<label>Usuário</label>
		<br>
		<input type='text' name='user' autofocus>
		<br><br>
		<label>Senha</label>
		<br>
		<input type='password' name='password'>
		<br><br>
		<input type='submit' name="entrar">
	</form>
	<a href='?acao=cliente-cadastrar' class='cadastrar-centralizado'>Cadastrar</a>
</div>