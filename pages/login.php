<div class="login-box">
	<h2><span style="color: green">C</span><span style="color: red">h</span><span style="color: blue">a</span><span style="color: yellow">t</span><span style="color: purple">z</span></h2>
	<?php
		use App\Site;
		if(isset($_SESSION['login'])) {
			Site::redirect(INCLUDE_PATH);
		}
		if(isset($_POST['acao'])) {
			try {
				$usuario = $_POST['usuario'];
				if(empty($usuario))
					throw new Exception('Usuário inválido!');
				if(Site::login($usuario))
					Site::redirect(INCLUDE_PATH);

			} catch(Exception $e) {
				Site::alert('error', $e->getMessage());

			}
		}
	?>
	<form method="post">
		<div class="form-group">
			<label>Digite um nome para entrar:</label>
			<input type="text" name="usuario">
		</div>
		<div class="form-group">
			<input type="submit" name="acao" value="Entrar">
		</div>
	</form>
</div>