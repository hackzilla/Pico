<?

function getProtocols() {
	$protocols = array('http','https','ftp','ftps','pop','smtp','mailto');
	return $protocols;
}

function isValidTld( $tld ) {

	static $validTLDs = array();

	if( empty($validTLDs)) {

		$file = @file_get_contents('http://dev.ofdan.com/tlds-alpha-by-domain.txt');

		if( $file !== false ) {
			$validTLDs = explode( "\n", $file );
			unset($validTLDs[0]);
		} else {
			$validTLDs = array(
			'COM',
			'NET',
			'ORG',
			'GOV',
			'MIL',
			'UK',
			'AU',
			'IE'
			);
		}

#		print_r( $validTLDs );

	}

	return in_array(strtoupper($tld), $validTLDs);
}

function isValidDomain( $domain ) {

  $validDomain = true;

  $domainBits = explode( '.', $domain );
  $tld = $domainBits[count($domainBits) -1];
#  echo $tld . "<br>\n";

  if( !isValidTld( $tld )) {
    $validDomain = false;
  }

  // do more checking if still valid

  return $validDomain;
}

function getFilteredDomain( $domain ) {

	echo "Filtered: $domain, ";
	// needs to handle domains with http:// at the front.
	
	$domain = strtolower($domain);
	$protocols = getProtocols();
	
	foreach( $protocols as $protocol ) {
		$pos = strpos( $domain, $protocol );
		if( $pos === 0 ) {
			$domain = substr(0,strlen($protocol));
		}
	}
	
	list($domain) = explode('#', $domain);
	list($domain) = explode('&', $domain);
	list($domain) = explode('?', $domain);
	list($domain) = explode('/', $domain);
	list($domain) = explode(':', $domain);
	
	$domain = crop($domain);
	
	if( isValidDomain($domain)) {
		echo "$domain\n";
		return $domain;
	} else {
		echo "FALSE\n";
		return false;		
	}
}

function crop ( $result )
{
	$result = strtolower($result);
	$result = html_entity_decode($result);

  return trim( preg_replace( '/[^ a-z0-9-()&.,; ]/', '', $result ));
}

function trimQuotes( $str ) {

        $str = trim($str);
        $len = strlen( $str );

        if( $len ) {
                if( $str[$len-1] == "'" || $str[$len-1] == '"') {
                        $str = substr($str, 0, $len-1);
                }
                if( $str[0] == "'" || $str[0] == '"') {
                        $str = substr($str, 1);
                }
        }

        return trim($str);
}

?>
