<?

	include_once( '../../crawler/db_connect.php' );

	function crop ( $result ) {

		return trim( preg_replace( '/[^a-zA-Z0-9()&;, ]/', '', $result ));

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

//	$langReplace['in'] = 'es';
//	$langReplace['ag'] = array('en','ca');
//	$langReplace['at'] = 'de';
//	$langReplace['ol'] = 'es';
//	$langReplace['ua'] = 'en';

// For updating domains without a lang
	$updateReplace = array();
	$updateReplace['de'] = 'de';
	$updateReplace['fr'] = 'fr';
	$updateReplace['uk'] = array('en','gb');



	foreach( $updateReplace as $name => $value ) {

		$sql = "SELECT domain, edward.id FROM edward
		WHERE lang = '' AND domain = '%.{$name}'";

		$res = mysql_query( $sql ) or die( mysql_error());

		if( $res ) {

			$count = 0;
			while( list( $domain, $id ) = mysql_fetch_row( $res )) {

				$count++;
				if( isset( $langReplace[$lang])) {

					if( !is_array( $value )) {
						$sql = "UPDATE edward SET lang='{$value}' WHERE id = $id";
						mysql_query( $sql );
					} else {
						$sql = "UPDATE edward SET dialect='{$value[1]}', lang='{$value[0]}' WHERE id = $id";
						mysql_query( $sql );
					}
				}

			}

			echo "$count domains with updated langs ( $name ) <br>\n";
			mysql_free_result( $res );
		}

	}


	$sql = "SELECT lang, domain, edward.id FROM edward
	LEFT JOIN languages ON edward.lang = cc
	WHERE nameEng is null AND lang != ''
	ORDER BY lang ASC";

	$res = mysql_query( $sql ) or die( mysql_error());

	if( $res ) {

		$count = 0;
		while( list( $lang, $domain, $id ) = mysql_fetch_row( $res )) {

			$count++;
			echo "$lang, $domain<br>\n";

			if( isset( $langReplace[$lang])) {

				if( $langReplace[$lang] == '') {
					$sql = "UPDATE edward SET lang='' WHERE id = $id";
				} else {

					if( !is_array( $langReplace[$lang] )) {
						$sql = "UPDATE edward SET dialect='$lang', lang='{$langReplace[$lang]}' WHERE id = $id";
					} else {
						$sql = "UPDATE edward SET dialect='{$langReplace[1]}', lang='{$langReplace[0]}' WHERE id = $id";
					}

				}
				mysql_query( $sql );
			}

		}

		echo "$count domains with no matching data";

		mysql_free_result( $res );
	}


?>