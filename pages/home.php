<?php
use Database\MySql;
use App\Site;
	if(!isset($_SESSION['login'])) {
		Site::redirect(INCLUDE_PATH.'login');
	}
?>
<section class="chat">
	<div class="center">
		<h2>Olá <?php echo $_SESSION['login']['usuario'] ?>! Seja bem vindo ao <span style="color: green">C</span><span style="color: red">h</span><span style="color: blue">a</span><span style="color: yellow">t</span><span style="color: purple">z</span></h2>
		<div class="chat-container">
			<div class="chat-container-mensagem">
				<?php
					$posts = MySql::selectAll('tb_admin.posts');
					foreach ($posts as $key => $value) {
				?>
				<div class="chat-mensagem">
					<div class="user">
						<p class="usuario"><?php echo $value['usuario']; ?></p>
						<p><?php echo date('d/m/Y H:i:s', strtotime($value['data'])); ?></p>
					</div>
					<div class="post">
						<p><?php echo $value['post']; ?></p>
					</div>
				</div>
				<?php } ?>
			</div>
			<form enctype="multipart/form-data" method="post">
				<div class="form-group">
					<input class="left" type="text" name="mensagem">
					<label class="left" for="imagem-input"><i class="fas fa-image"></i></label>
					<div class="clear"></div>
					<input multiple style="display: none;" type="file" id="imagem-input" name="imagem[]">
				</div>
				<div class="form-group">
					<input type="submit" name="acao" value="Enviar">
				</div>
			</form>
		</div>
	</div>
</section>
<script type="text/javascript">
	var target = $('.chat-container').prop('scrollHeight');
	$('.chat-container').scrollTop(target);
	$('form').on('submit', function(e) {
		e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
        	url: include_path+'back/Ajax/chat-submit.php',
        	method:'post',
        	data:formData,
        	processData: false,
			contentType: false,
        	beforeSend: function() {
        		$('html,body').animate({'opacity':'0.6'}, 500);
        	},
        	success: function(data) {
        		$('html,body').animate({'opacity':'1.0'},500);
        		if(data == '') {
        			var target = $('.chat-container').prop('scrollHeight');
					$('.chat-container').scrollTop(target);
        			atualizarChat();
					$('form input[type=text]').val('');
					$('form input[type=file]').val('');
					var target = $('.chat-container').prop('scrollHeight');
					$('.chat-container').scrollTop(target);
        		} else {
        			alert(data);
        		}
        	}
        });

        setInterval(function() {
        	atualizarChat();
        }, 1000)

        function atualizarChat() {
        	$.ajax({
        		url:include_path+'back/Ajax/chat-get.php',
        		method:'post',
        		dataType:'json'
        	}).done(function(data) {
        		if(data['status'] == true) {
    				$('.chat-container-mensagem').html(data['mensagem']);
    			} else {
    				alert(data['mensagem']);
    			}
        	})
        }
    });
</script>
