<?php
function uppercase($string){
    return mb_strtoupper($string, "UTF-8");
}
function lowercase($string){
    return mb_strtolower($string, "UTF-8");
}
function capitalize($string){
   $first = mb_substr($string, 0, 1, "UTF-8");
   $first = mb_convert_case($first, MB_CASE_TITLE, 'UTF-8');
   return $first.mb_substr($string, 1, mb_strlen($string, "UTF-8"), "UTF-8");
}
function limitWords($string, $word_limit) {
    $words = explode(" ",$string);
    $num_words = count($words);
    if ($num_words > $word_limit) {$suffix = "...";} else {$suffix = "";}
    return implode(" ",array_splice($words,0,$word_limit)).$suffix;
}
function cleanString ($string) {
		$latin = array('.', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'Ő', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ű', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ő', 'ø', 'ù', 'ú', 'û', 'ü', 'ű', 'ý', 'þ', 'ÿ', '©');
		$nlatin = array('', 'A', 'A', 'A', 'A', 'A', 'A', 'AE', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'D', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'U', 'U', 'Y', 'TH', 'ss', 'a', 'a', 'a', 'a', 'a', 'a', 'ae', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'd', 'n', 'o', 'o', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'u', 'u', 'y', 'th', 'y', '(c)');

		$cleaned = str_replace($latin, $nlatin, $string);
		$cleaned = preg_replace("/[^a-zA-Z0-9-]/", "-", $cleaned);
        $cleaned = strtolower($cleaned);
		return $cleaned;
}
?>