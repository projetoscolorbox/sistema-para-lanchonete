

<form method='GET'>
<select>
	<option>Aberto</option>
	<option>Preparo</option>
	<option>Despachado</option>
</select>
<input type='hidden' name='acao' value='pedido-gerenciar'>
<?php
	echo "<input type='hidden' name='pedID' value='".$_GET['pedID']."'>";
?>

</form>