<?
	die('Only needed if lose of Country Codes');

	include_once( '../../crawler/db_connect.php' );

	function crop ( $result ) {

		return trim( preg_replace( '/[^a-zA-Z0-9()&;, ]/', '', $result ));

	}


	$ccs = file_get_contents('countryCodes.txt');

	$ccs = explode( '        </tr>', $ccs );

	foreach( $ccs as $cc ) {

		$cc = explode( '<td align="left">', $cc );

		//print_r( $cc );

		$cc2 = crop( $cc[2] );
		$cc3 = crop( $cc[1] );
		$ccNameEng = crop( $cc[3] );
		$ccNameFr  = crop( $cc[4] );

		if( $cc2 != '&nbsp;' && $cc2 != '' ) {

			echo "'$cc2' '$ccNameEng' <br>\n";
			$sql = "INSERT INTO languages (cc, nameEng) VALUES ('{$cc2}','{$ccNameEng}')";
			$res = mysql_query( $sql );// or die( mysql_error());

		}

	}

?>
