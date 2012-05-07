<?

	function windows_xp_ie( $domain, $x, $y ) {

		$outputPath = dirname(__FILE__) . '/' . 'sites' . '/';
		$outputFile = '"' . $outputPath . $domain . '-' . $x . 'x' . $y . '.png' . '"';


		$loc = 'http://192.168.0.50/siteGen/index.php?domain=' . $domain . '&x=' . $x . '&y=' . $y;

		$output = file_get_contents( $loc );

		echo $output;

		$rtn = 'http://192.168.0.50/siteGen/sites/' . $domain . '-' . $x . 'x' . $y . '.png';

		return $rtn;

	}

?>