<?

	include_once( 'db_connect.php' );
	include_once( 'config.php' );
//	include_once( $config['generatorPath'] . $config['dirSep'] . 'loadGenerator.php' );
	include_once( 'functions.php' );


	function updateThumbs() {

		global $config;

		$x = 120;
		$y = floor(( $x / 4 ) * 3 );
		$sitesPath = $config['sitesPath'] . $config['dirSep'];
		$thumbsPath = $config['thumbsPath'] . $config['dirSep'];

		foreach( glob($sitesPath . "*.png") as $filename) {

//			echo "File: $filename <br>";
			if( $filename != '.' AND $filename != '..' ) {

				$file = basename( $filename, '.png' );

				list( $domain, $size, $platform, $version, $browser ) = explode( '-', $file );

				// 800x600-windows-xp-ie.png

				if( $size == '800x600' && $platform == 'windows' && $version == 'xp' && $browser == 'ie' ) {

					$thumb =	$thumbsPath . $domain . '.png';

					//echo "createthumb( $filename , $thumb , $x , $y );";
					createthumb( $filename, $thumb, $x, $y );

					$domain = findDomain( $domain );

					if( $domainId !== FALSE ) {

						$sql = "UPDATE `edward` SET `thumbsCreated` = NOW() WHERE `id`='{$domain['id']}'";
						$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

					}

				} else {
					//echo "mismatch: createthumb( $filename , $thumb , $x , $y );";
				}

			}

		}

	}

	updateThumbs();

?>