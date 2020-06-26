<?php
// include('../../config.php');
namespace App;
use Database\MySql;
use Email\Email;
class Site {
	public static function random_id() {
		return md5(uniqid().uniqid().uniqid().uniqid());
	}
	public static function logout($redirect_after_logout="") {
		unset($_SESSION['login']);
		if(!empty($redirect_after_logout))
			self::redirect($redirect_after_logout);
		unset($_SESSION['cart']);
	}
	public static function generateSlug($string_to_be_converted) {
		$str = mb_strtolower($string_to_be_converted);
		$str = preg_replace('/(à|á|â|ã)/', 'a', $str);
		$str = preg_replace('/(é|è|ê)/', 'e', $str);
		$str = preg_replace('/(í|ì|î)/', 'i', $str);
		$str = preg_replace('/(ó|ô|ò|õ)/', 'o', $str);
		$str = preg_replace('/(ú|ù|û)/', 'u', $str);
		$str = preg_replace('/( )+/', '-', $str);
		$str = preg_replace('/(ç)/', 'c', $str);
		$str = preg_replace('/(\?|\"|\'|\*|#|@|!|\.|;)+/', '', $str);
		return $str;
	}
	public static function convertToDouble($str) {
		$str = str_replace('R$', '', $str);
		$str = str_replace(',', '.', $str);
		$str = number_format($str, 2, '.','');
		return $str;
	}
	public static function formatMoney($str) {
		$str = number_format($str, 2, ',','.');
		$str = substr_replace($str, 'R$', 0,0);
		return $str;
	}
	public static function redirect($link) {
		echo '<script>location.href="'.$link.'"</script>';
	}
	public static function alert($status, $message) {
		switch ($status) {
			case 'success':
				echo '<div class="alert success"><i class="fas fa-check"></i> '.$message.'</div>';
				break;
			case 'error':
				echo '<div class="alert error"><i class="fas fa-times"></i> '.$message.'</div>';
				break;
			case 'warning':
				echo '<div class="alert warning"><i class="fas fa-exclamation-triangle"></i> '.$message.'</div>';
				break;
			
			default:
				# code...
				break;
		}
	}
	public static function uploadFile($file) {
		$extension = explode('.', $file['name'])[1];
		$name = Site::random_id();
		$name.='.'.$extension;
		move_uploaded_file($file['tmp_name'], BASE_DIR.'uploads/'.$name);
		return $name;

	}
	public static function isImage($image) {
		if($image['type'] == 'image/jpg' || $image['type'] == 'image/png' || $image['type'] == 'image/jpeg') {
			return true;
		}
		return false;
	}

	//Your App

	public static function login($usuario) {
		$verifica = MySql::find('tb_admin.usuarios_online', 'WHERE usuario = ?', array($usuario));
		if(!empty($verifica)) {
			self::alert('error', 'Usuário já está online! Escolha outro nome');
			return false;
		}
		$_SESSION['login']['log_id'] = self::random_id();
		$_SESSION['login']['usuario'] = $usuario;
		$now = date('Y-m-d H:i:s');
		MySql::insert('tb_admin.usuarios_online', array($_SESSION['login']['log_id'], $usuario, $now));
	}
	public static function clearOnlineUsers() {
		$now = date('Y-m-d H:i:s');
		$sql = MySql::delete('tb_admin.usuarios_online', 'WHERE data < ? - INTERVAL 5 HOUR', array($now));
	}
}

?>