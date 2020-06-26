<?php
include('config.php');
	use Core\Hantix;
	use App\Site;
	Site::clearOnlineUsers();
	$url = explode('/', @$_GET['url']);
	Hantix::initialize();
	if(!empty($url[0])) {
		if(file_exists(BASE_DIR.'pages/'.$url[0].'.php')) {
			include('pages/'.$url[0].'.php');
		} else {
			include('pages/home.php');
		}
	} else {
		include('pages/home.php');
	}
?>
<?php
Hantix::end();
?>