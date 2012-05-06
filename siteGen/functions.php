<?

	function findDomain( $domain ) {

		$sql = "SELECT * FROM `edward` WHERE domain LIKE '{$domain}' LIMIT 1";
		$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

		if( $result ) {

			$domain =  mysql_fetch_assoc( $result );

			mysql_free_result( $result );

			return $domain;

		} else {

			return false;

		}

	}

	function loadModules() {

		global $config;

		$loadedModules = array();

		$modules = array();
		$modules[0] = array( 'platform'=>'windows', 'version'=>'xp', 'browser'=>'ie' );

		foreach( $modules as $module ) {

			$platform = $module['platform'];
			$version = $module['version'];
			$browser = $module['browser'];

			if( loadGenerator( $platform, $version, $browser )) {
				print "<p>loaded module: $platform $version $browser</p>";
				$loadedModules["{$platform}_{$version}_{$browser}"] = $module;
			} else {
				print "<p>loading module: $platform $version $browser failed</p>";
			}

		}

		return $loadedModules;

	}

	function processDomain( $loadedModules, $domain, $x, $y ) {

		global $config;

		$urls = array();
		foreach( $loadedModules as $func => $module ) {

			$platform = $module['platform'];
			$version = $module['version'];
			$browser = $module['browser'];

			$url = $func( $domain, $x, $y );

			if( $url ) {
				$urls[$func] = $module;
				$urls[$func]['url'] = $url;
			}

		}

		return $urls;

	}

	function savePictures( $urls ) {

		global $config;

		foreach( $urls as $func => $module ) {

			$platform = $module['platform'];
			$version = $module['version'];
			$browser = $module['browser'];
			$url = $module['url'];

			$picture = file_get_contents( $url );

			$filename = $config['sitesPath'] . $config['dirSep'] . basename( $url, '.png' ) . '-' . $platform . '-' . $version . '-' . $browser . '.png';

			if ( !file_exists($filename) || is_writable($filename)) {

			// In our example we're opening $filename in append mode.
			// The file pointer is at the bottom of the file hence
			// that's where $somecontent will go when we fwrite() it.
			if (!$handle = fopen($filename, 'a')) {
//				echo "Cannot open file ($filename)";
				continue;
			}

			// Write $somecontent to our opened file.
			if (fwrite($handle, $picture) === FALSE) {
//				echo "Cannot write to file ($filename)";
				continue;
			}


//				echo "Success, wrote to file ($filename)";

				fclose($handle);
				chmod($filename, 0777);
				//chown($filename, 'dan');

			} else {
//			   echo "The file $filename is not writable";
			}

		}

	}

function createthumb($name,$filename,$new_w,$new_h){

	$gd = "YES";
	$system=explode(".",$name);

	$ext = $system[(count( $system ) -1)];
	unset( $system );

	if (preg_match("/jpg|jpeg/", $ext )){
	    $src_img=imagecreatefromjpeg($name);

	} else if (preg_match("/png/", $ext)){
	    $src_img=imagecreatefrompng($name);

	} else if (preg_match("/gif/", $ext)){
	    $src_img=imagecreatefromgif($name);

	}

	$old_x=imageSX($src_img);
	$old_y=imageSY($src_img);
	if ($old_x > $old_y) {
	    $thumb_w=$new_w;
	    $thumb_h=$old_y*($new_h/$old_x);
	}
	if ($old_x < $old_y) {
	    $thumb_w=$old_x*($new_w/$old_y);
	    $thumb_h=$new_h;
	}
	if ($old_x == $old_y) {
	    $thumb_w=$new_w;
	    $thumb_h=$new_h;
	}

	if ($gd2==""){
	    $dst_img=ImageCreate($thumb_w,$thumb_h);
	    imagecopyresized($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	}else{
	    $dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	    imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
	}

	if (preg_match("/png/", $ext)){
	    imagepng($dst_img,$filename);
	} else if(preg_match("/jpeg|jpg/", $ext)) {
	    imagejpeg($dst_img,$filename);
	} else if(preg_match("/gif/", $ext)) {
	     imagegif($dst_img,$filename);
	}

	@imagedestroy($dst_img);
	@imagedestroy($src_img);

}


?>