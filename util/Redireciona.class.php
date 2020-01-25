
<?php
	
	class Redirecionar{
		public static function go($url){
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$url."\" />";
		}
	}
	
?>