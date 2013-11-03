<?php
function get_language() {
	if (isset($_GET["language"])) {
		return $_GET["language"];
	} else {
		// Fall back to EN
		return "en";
	}
}

function get_translation($translation_key) {
	
	global $language;
	
	// If requested language does not exist, fall back
	if (! file_exists ( ABSPATH . "/modules/lang/translations_" . $language . ".txt" )) {
		$language = get_language();
	}
	
	$file = file ( ABSPATH . "/modules/lang/translations_" . $language . ".txt" );
	foreach ( $file as $line ) {
		$translation = explode ( ',', $line );
		if ($translation[0] == $translation_key)
			return $translation[1];
	}
	return "NO translation found: " . $translation_key;
}

?>