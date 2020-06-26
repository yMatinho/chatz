<?php
namespace Ajax;
	class Ajax {
		public static function verify() {
			if(isset($_SESSION['login'])) {
				return true;
			}
			return false;
		}
	}
?>