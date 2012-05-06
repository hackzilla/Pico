<?

function loadSpellChecker($lang) {

	static $int = 0;

	if( $int == 0 ) {
		$int = pspell_new($lang);
	}

	return $int;

}
function spellCheck( $word ) {

	loadSpellChecker('en_GB-w-accents');
	return pspell_check( $int, $word );

}

?>