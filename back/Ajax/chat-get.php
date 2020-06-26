<?php
include('../../config.php');
	use Ajax\Ajax;
	use Database\MySql;
	use App\Site;
	if(Ajax::verify()) {
		$posts = MySql::selectAll('tb_admin.posts');
		$data = '';
		foreach ($posts as $key => $value) {
			$data.='<div class="chat-mensagem">
						<div class="user">
							<p class="usuario">'.$value['usuario'].'</p>
							<p>'.date('d/m/Y H:i:s', strtotime($value['data'])).'</p>
						</div>
						<div class="post">
							<p>'.$value['post'].'</p>
						</div>
					</div>';
		}
		die(json_encode(array('status'=>true, 'mensagem'=>$data)));

	} else {
		die(json_encode(array('status'=>false,'mensagem'=>'Você precisa estar logado para fazer isto!')));
	}
?>