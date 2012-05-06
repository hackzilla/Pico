<?

	function loadGenerator( $platform, $version, $browser ) {

		global $config;
		$dirSep = $config['dirSep'];

		//try {

			include_once( $config['generatorPath'] . $dirSep . stripslashes( $platform ) . $dirSep . stripslashes( $version ) . $dirSep . stripslashes( $browser ) . $dirSep . 'gen.php' );

		//} catch (Exception $e) {
			//echo 'Caught exception: ',  $e->getMessage(), "\n";
		//	return false;
		//}

		return true;

	}

?>