<?

	session_start();

	echo "<html><head></head><body>\n";

	include_once( '../../crawler2/db_connect.php' );
	include_once( '../../crawler2/functions.php' );
	include_once( '../../crawler2/crawlerFunctions.php' );
	include_once( '../../crawler2/pageFunctions.php' );
	include_once( '../../crawler2/languageFunctions.php' );

#	$page = strtolower( stripslashes( $_POST['page'] ));
	$page = ( stripslashes( $_POST['page'] ));

	echo "<form action='{$_SERVER['PHP_SELF']}' method='post'>

	<textarea name='page' rows='20' cols='80'>{$page}</textarea>
	<br>
	<input type='submit' value='check'>
</form>
<br>
<br>
";
//	print_r( $_POST );

//	$page = " \n ".$page;

	if( isset( $_POST['page'] ) ) {

		$meta = process( $page );

		print_r( $meta );
		if( isset($meta['revisit-after'])) {
			$revisitTime = $meta['revisit-after'];
			echo "<p>revisitTime: $revisitTime</p>";
		}

		//[\s]*
		preg_match('/<html(.*)>/', $page, $out);
		$out = $out[1];
#		print '<p>HtmlArgs:' . print_r( $out, true ) . '</p>'."\n";

		$htmlArgs = getProperties( $out );

		print '<p>HtmlArgs:' . print_r( $out, true ) . '</p>'."\n";
		echo '<br>';

		if( isset( $htmlArgs['lang'] )) {
			list( $lang, $dialect ) = checkForRegionAbbr( $htmlArgs['lang'] );
		} else {
			$lang = '';
			$dialect = '';
		}

#		echo "1. lang: {$lang}, {$dialect}\n" . '<br>';

		if( !isset($lang) || $lang == '' ) {

			list( $lang, $dialect) = checkMetaLang( $meta );
			if( $lang == '' ) {

#				echo "did not find lang, " . '<br>';

			} else {
#				echo "finally found lang, " . '<br>';

			}

		} else {
#			echo "found lang, " . '<br>';
		}

#		echo "checking lang ($lang,$dialect), " . '<br>';
		list( $lang, $dialect ) = checkLang( $lang, $dialect );
#		echo "2. lang: ({$lang},{$dialect}) \n" . '<br>';

		$lang = crop( $lang );
		$dialect = crop( $dialect );

#		echo "3. lang: ({$lang},{$dialect}) \n" . '<br>';

		print_r( $meta );

	}


#		preg_match_all('|<meta[^>]+name=\\"([^"]*)\\"[^>]+content="([^\\"]*)"[^>]+>|i', $page, $out);

#		print_r( $out );


	print "</body>
</html>
";
//	print_r( $_POST );

?>