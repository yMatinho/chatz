<?php
	include('../../config.php');
	use Ajax\Ajax;
	use Database\MySql;
	use App\Site;
	if(Ajax::verify()) {
		try {
			$mensagem = $_POST['mensagem'];
			$imagens = $_FILES['imagem'];
			if(empty($mensagem) && empty($imagens['name'][0]))
				throw new Exception('Você precisa escrever uma mensagem para postar algo!');
			$i = 0;
			if(!empty($imagens['name'][0])) {
				for($i = 0; $i < count($imagens['name']); $i++) {
					if(!Site::isImage(array('type'=>$imagens['type'][$i])))
						throw new Exception('Imagem inválida!');
				}
				$imagem = array();
				$i = 0;
				for($i = 0; $i < count($imagens['name']); $i++) {
					$imagem[] = Site::uploadFile(array('name'=>$imagens['name'][$i], 'tmp_name'=>$imagens['tmp_name'][$i]));
				}
				foreach ($imagem as $key => $value) {
					$mensagem.='<br><br>';
					$mensagem.='<img src="'.INCLUDE_PATH.'uploads/'.$value.'">';
				}
			}
			MySql::insert('tb_admin.posts', array($_SESSION['login']['usuario'], $mensagem, date('Y-m-d H:i:s')));
			die();
		} catch(Exception $e) {
			die($e->getMessage());
		}
	} else {
		die('Você precisa estar logado para continuar!');
	}
?>