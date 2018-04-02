<?php

namespace AppBundle\Services;

class UtilServicio {
	
	function randomString($length = 8) {
		$str = "";
		$characters = array_merge(range('A','Z'), range('a','z'), range('0','9'));
		$max = count($characters) - 1;
		for ($i = 0; $i < $length; $i++) {
			$rand = mt_rand(0, $max);
			$str .= $characters[$rand];
		}
		return $str;
	}
	
	/**
	 * Retrona la exopresión original sin tags de script, html entities
	 * ni elementos br
	 * 
	 * @param mixed $expresion
	 * @return mixed
	 */
	function clean_str($expresion){
		return preg_replace("/(&#)\d*(;)|<br>|\\\\n/","",preg_replace("/(<script>).*(<\/script>)/", "", $expresion));
	}
	
	/**
	 * Retrona la exopresión original sin tags de script, html entities
	 * pero conserva elementos br
	 *
	 * @param mixed $expresion
	 * @return mixed
	 *
	function clean_str_without_br($expresion){
		return preg_replace("/(&#)\d*(;)|\\\\n/","",preg_replace("/(<script).*(<\/script>)/", "", $expresion));
	}
	*/
}