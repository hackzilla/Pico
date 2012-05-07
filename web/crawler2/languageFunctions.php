<?

function checkForRegionAbbr( $str ) {

	$lang = '';
	$dialect = '';

	switch( strlen( $str )) {
		case 2:
			$lang = $str;
			break;

		case 5:

			if('utf-8' != $str ) {
				$content = preg_split("/[- ]/", $str );
				$lang = $content[0];
				$dialect = $content[1];
			}
			break;

		case 0:

			break;

		default:

			$content = preg_split("/[,; ]/", $str );

			foreach( $content as $langBits ) {
				if( strlen( $langBits ) == 2 ) {

					if( $lang == '') {
						$lang = $langBits;
					} else {
						$dialect = $langBits;
					}

				}
			}
	}

	return array( $lang, $dialect );

}

function checkMetaLang( $metaTags ) {

	$lang = '';
	$dialect = '';

	if(isset( $metaTags['language'] )) {
		list( $lang, $dialect ) = checkForRegionAbbr( $metaTags['language'] );
	}

	if( $lang == '' && isset( $metaTags['content-language'] )) {

		list( $lang, $dialect ) = checkForRegionAbbr( $metaTags['content-language'] );

	}

	return array( $lang, $dialect );

}

function checkLang( $lang, $dialect ) {

	if( !$lang ) {
//#		echo "\nb4 lang: {$lang}, {$dialect}\n";
	}

	$langReplace = array();
	$langReplace['gb'] = array('en','gb');
	$langReplace['uk'] = array('en','gb');
	$langReplace['us'] = array('en','us');
	$langReplace['du'] = 'nl';
	$langReplace['jp'] = 'ja';
	$langReplace['dk'] = 'da';
	$langReplace['cz'] = 'cs';
	$langReplace['ut'] = '';
	$langReplace['ct'] = 'es';
	$langReplace['sp'] = 'es';
	$langReplace['mx'] = array('es','mx');
	$langReplace['cn'] = array('zh','cn');

	if( isset($langReplace[$lang])) {

		if( is_array($langReplace[$lang])) {
			$lang = $langReplace[$lang][0];
			if( isset($langReplace[$lang][1])) {
				$dialect = $langReplace[$lang][1];
			}
		} else {
			$lang = $langReplace[$lang];
		}

	}

	if( !$lang ) {
//#		echo "af lang: {$lang}, {$dialect}\n";
	}

	return array( $lang, $dialect );
}

?>
