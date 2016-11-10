<?php
	session_start();
	
	if( isset($_SESSION['usuario']) && !empty($_SESSION['usuario'])){
		header("Location: ../index.php");
	}
	
?>
<div class="login">
<form method='POST' action='carregar_funcionalidades.php'>
		<label>Usuário:</label>
		<br>
		<input type='text' name='user'>
		<br><br>
		<label>Senha:</label>
		<br>
		<input type='password' name='password'>
		<br><br>
		<input type='submit' name="entrar">
	</form>
</div>
<a href='cliente-cadastrar.php'>Cadastrar</a>
