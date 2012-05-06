<?

function checkPage( $domainId, $domain ) {

	$page = false;
	$meta = false;

	if($domainId) {

		if($domain) {

			$url = 'http://' . $domain . '/';
			//check /robots.txt file

			$headers = check_rights( $domainId, $url );

			if( $headers !== false ) {

				// get /
				$page = get_page( $domainId, 'index', $url );
#				echo "al'd, ";
				if( $page === false ) {

#					block_domain( $domainId, 'connection','Problem connecting' );
#					delay_domain( $domainId );
					update_domain_pause( $domainId );
					print( 'Error 14, Problem connecting' ."<br />\n" );


				} else if( $page == '') {

					block_domain( $domainId, 'page', 'No Page Contents' );
					print( 'Error 7, No Page Contents'."<br />\n" );

				} else {

					$meta = get_meta_data( $page );


					if( $meta == false ) {

						block_domain( $domainId, 'meta','Meta infomation missing' );
						print( 'Error 9, Meta infomation missing'."<br />\n" );
						$meta = false;

					} else {

						processMetaTag( $domainId, $page, $meta );

					}
				}

			} else {

#				remove_queue_item( $domainId );
				block_domain( $domainId, 'robot','Denied by Robot File' );
				print( 'Error 4, Denied by Robot File' ."<br />\n" );

			}

		} else {

			remove_queue_item( $domainId );
			print( 'Error 2, Need something to dial' ."<br />\n" );
		}

	} else {

		// Means queue was empty
		print( 'Error: 1, Nothing to do' ."<br />\n");

	}

	return array($page, $meta);
}

function process( $page ) {

	if( $page != '' ) {

#		preg_match_all("/(<([\w]+)[^>]*>)(.*)(<\/\\2>)/", $page, $metaTags, PREG_SET_ORDER);
		return get_meta_data( $page );

	}

	return false;

}

function processMetaRevist($meta) {

	$time = time();
	$timenext = 0;

	if( isset($meta['revisit-after'])) {

		$revisitTime = $meta['revisit-after'];

		if( $revisitTime != '' ) {

			if( 'daily' ) {

				$timenext = strtotime( '+1 day' );

			} else {

				$timenext = strtotime( '+'.$revisitTime );

			}

		}

	}

#	if( $timenext < $time ) {
#		$timenext = $time + 604800;
#	}

	if(( $time + ( 604800 * 8 )) >= $timenext ) {
		// force sites to require a min of 4 week(s) before recheck
		$timenext = $time + ( 604800 * 8 );
	}

	return $timenext;

}

function processMetaTag( $domainId, $page, $metaTags )
{
	if(isset($metaTags['description'])) {
		$extract = cacheLink()->real_escape_string( $metaTags['description']);
	} else {
		$extract = '';
	}

	if(isset($metaTags['keywords'])) {
		$kywds = cacheLink()->real_escape_string($metaTags['keywords']);
		$kywd = preg_split('/[ ,;]/', $kywds );
		/*
		if( count( $kywd ) < 2 ) {
			$kywd = preg_split('/[ ,;]/', $kywds );
		}*/
	} else {
		$kywd = array();
	}

	echo "found " . count( $kywd ) . ', ';

	$rank = 2500;

	if(is_array($kywd)) {

		foreach( $kywd as $word ) {

			$word = trim(crop($word));

			// insert keyword
			if( $word ) {
				addKeyword( $domainId, $word, $rank );
			}
		}
	}

	// Content Lang
	preg_match('/<html(.*)>/i', $page, $out);

	if( count( $out )) {
		$out = $out[1];
		$htmlArgs = getProperties( $out );
	} else {
		$htmlArgs = array();
	}

	if( isset( $htmlArgs['lang'] )) {
		list( $lang, $dialect ) = checkForRegionAbbr( $htmlArgs['lang'] );
	}

	if( !isset($lang) || $lang == '' ) {

#		echo "did not find lang, ";
		list( $lang, $dialect) = checkMetaLang( $metaTags );
		if( $lang == '' ) {

			echo "did not find lang, ";
#			echo "still did not find lang, ";

		}

	} else {
		echo "found lang, ";
	}

	echo "checking lang ($lang,$dialect), ";
	list( $lang, $dialect ) = checkLang( $lang, $dialect );

	$lang = crop( $lang );
	$dialect = crop( $dialect );

	$values = array();
	$count = 0;

	$values['lang'] = strtolower($lang);
	$values['dialect'] = strtolower($dialect);
	$values['extract'] = $extract;

	if( $lang ) {
		$count++;

		if( $dialect ) {
			$count++;
		}
	}

	if( $extract ) {
		$count++;
	}

	// Lets store them all..
	$count++;

	if($count)
	{
		$table = 'metadata';
		$checks = array('domainId'=>$domainId);

		// insert if it does not exist!!
		insertOrUpdate ( $table, $values, $checks );

		$timenext = processMetaRevist($metaTags);

		$sql = "UPDATE `domain` SET `nextindex`=FROM_UNIXTIME({$timenext}), `lastindex`=NOW() WHERE `id`='$domainId' LIMIT 1;";
		$ed_result = cacheLink()->query( $sql ) or error_sql( $sql, cacheLink()->error );
	}
  else
	{
		block_domain( $domainId, 'Not enough Meta infomation found' );
		print( 'Error 9, Not enough Meta infomation found'."<br />\n" );
	}

}

function getProperties( $htmlArgs ) {

	$props = array();

	$args = explode( '=', trimQuotes( $htmlArgs ));

	foreach( $args as $key => $line ) {

		$line = trimQuotes( $line );
		$args[$key] = $line;

		$test1 = explode( '" ', $line );
		if( count ( $test1 ) == 2 ) {
			$args[$key] = array( $test1[0], trimQuotes($test1[1]) );
		} else {

			$test2 = explode( "' ", $line );
			if( count ( $test2 ) == 2 ) {
				$args[$key] = array( $test2[0], trimQuotes($test2[1]) );
			} else {

				$test3 = explode( '  ', $line );

				if( count ( $test3 ) == 2 ) {
					$args[$key] = array( $test3[0], trimQuotes($test3[1]) );
				}

			}

		}

	}

	$argCount = count( $args );
	if( $argCount == 2 ) {
		$props[$args[0]] = $args[1];
	} else if( $argCount >2 ) {

		$props[$args[0]] = $args[1][0];

		for( $i=1; $i<($argCount-2); $i++ ) {
			$props[$args[$i][1]] = $args[$i+1][0];
		}

		$props[$args[$argCount-2][1]] = $args[$argCount-1];

	}

	return $props;

}

function get_meta_data($html) {

#	preg_match_all('/<meta[^>]+name=\\[\'"]([^"]*)\\"[^>]+content=["]?([^\\"]*)["]?[^>]+>/i', $html, $out, PREG_PATTERN_ORDER);
	preg_match_all('/<[\s]*meta[\s]*name="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $html, $out);
#	print_r( $out );

	$meta = array();
	for ($i=0;$i < count($out[1]);$i++) {
		$name = strtolower(trimQuotes( $out[1][$i] ));
		$value = trimQuotes( $out[2][$i] );
		$meta[$name] = $value;
	}

	// First one gets priority
#	preg_match_all('/<meta[^>]+http-equiv=\\[\'"]([^"]*)\\"[^>]+content=["]?([^\\"]*)["]?[^>]+>/i', $html, $out, PREG_PATTERN_ORDER);
	preg_match_all('/<[\s]*meta[\s]*http-equiv="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $html, $out);
#	print_r( $out );

	for ($i=0;$i < count($out[1]);$i++) {
		$name = strtolower(trimQuotes( $out[1][$i] ));
		$value = trimQuotes( $out[2][$i] );
		if( !isset( $meta[$name] )) {
			$meta[$name] = $value;
		}
	}

#	print "\nmeta info\n";
#	print_r( $meta );

	return $meta;

/*
	preg_match_all('/<meta(.*)name="?' . '([^>"]*)"?' . '(.*)' . 'content="?([^>"]*)"?[\s]*[\/]?' . '(.*)' . '>/i', $html, $out);
	preg_match_all('/<meta(.*)http-equiv="?' . '([^>"]*)"?' . '(.*)' . 'content="?([^>"]*)"?[\s]*[\/]?' . '(.*)' . '>/i', $html, $out);
*/

}

?>
