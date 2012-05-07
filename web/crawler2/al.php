<?

include_once( 'crawlerFunctions.php' );

function al( $page, $thisDomainId = 0 ) {

	//$page
	$links = Array();

	$urls = '(http)';
	$ltrs = '\w';
	$gunk = '/#~:.?+=&%@!\-';
	$punc = '.:?\-';
	$any = "$ltrs$gunk$punc";
	preg_match_all("{
	                      \b
	                      $urls   :
	                      [$any] +?


	                      (?=
	                        [$punc] *
	                        [^$any]
	                      |
	                        $
	                      )
	                  }x", $page, $links);

	$newdomains = Array();

	$urls = $links[0];
	foreach( $urls as $url ) {

		$urlinfo = @parse_url( urldecode($url));
		if( isset( $urlinfo['host'] )) {

			$domain = urldecode(html_entity_decode($urlinfo['host']));

			if( strpos('@', $domain) !== false ) {
				continue;
			}
#			if( strpos('mailto', $domain) !== false ) {
#				continue;
#			}

#			experimental idea
#			$domain = preg_replace( '/http[s]?:[\/]*/', '', $domain );

			// remove ports
			$domain = getFilteredDomain( $domain );
			#$domain = $domain[0];

			$dotCount = strpos( $domain, '.' );

			if( $dotCount !== FALSE && $dotCount >0 && $dotCount != (strlen($domain)-1)) {
				$newdomains[] = $urlinfo['host'];
			}

		}

	}

	// remove duplicate entries from array
	$newdomains = array_unique($newdomains);
	reset( $newdomains );

	// remove items already queued
	// remove items already in database

#	print_r($newdomains);

	foreach ($newdomains as $domain)
  {
		add_domain_link( $thisDomainId, $domain );
		add_queue_item( $domain );
	}
}

?>
