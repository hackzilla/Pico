<?

include_once('PHP/Compat/Function/get_headers1.php');

function checkHeader( $domainId, $url, $page, $format = 0 ) {

	echo "$domainId, '$url', $page, $format \n";
#	print_r( parse_url($url));

	$headers = get_headers1($url, $format);

	if(is_array( $headers ) && count( $headers )) {

#		print_r($headers);
		storeHeader( $domainId, $page, $headers );

		preg_match( "/^HTTP\/\d\.\d (\d+) (.*)$/i",$headers[0], $errorCode );
#		print_r($errorCode);

		if( isset($errorCode[1])) {
			$errorString = $errorCode[2];
			$errorCode = $errorCode[1];
		} else {
			$errorCode = '';
			$errorString = '';
		}

		if(( $errorCode == '404' OR $errorCode == '403' ) && $page != 'robot') {

			return false;

		} else if(isset($headers['Location']) ) {

			$urlinfo = parse_url($headers['Location']);
			if(isset($urlinfo['host'])) {
				add_queue_item( $urlinfo['host'] );
			}

			return false;
		}

		return $headers;
	}

  return ($page == 'robot');
}

function get_page( $domainId, $page, $url ) {

	//open http connection to server, and request $file

	if( $url ) {

		if( checkHeader( $domainId, $url, $page, 1 )) {
//			echo "headers: \n";
//			print_r( $headers );

			echo "\nopened {$url}, ";
			$server_handle = @fopen( $url, 'r' );
	#		echo "closed, ";

			if( $server_handle )
      {
				stream_set_timeout($server_handle, 4);
				$page = '';

				$dotCount = 0;

				while ( !feof( $server_handle ) && ( strlen( $page ) < 1000000 )) {
					if( $dotCount >2 ) {
						break;
					}
					$fetch = fgets($server_handle, 4096);

					if( strlen( $fetch ) == 0 ) {
						echo '.';
						$dotCount++;
					}
					$page .= $fetch;
				}

#				echo " fetched, ";

				fclose( $server_handle );

				$len = strlen( $page );

				if( $len > 100000 ) {
					echo "\nPage length greater than 100000 characters. ({$len}) \n";
				}

				al( $page, $domainId );

				$page = trim($page);

				return $page; //strtolower($page);

			} else {
				return false;
			}

		} else {
			return false;
		}

	}

	// NO file found
	return '';
}
?>
