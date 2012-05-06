<?

	include_once( 'functions.php' );
	include_once( 'config.php' );
	include_once( $config['generatorPath'] . $config['dirSep'] . 'loadGenerator.php' );

	$domains = array();
	$domains[] = 'www.retronimo.com';
	$domains[] = 'www.referencement-fr.com';
	$domains[] = 'www.referland.com';
	$domains[] = 'www.asp-php.net';
	$domains[] = 'www.weborama.fr';

//	$x = 640;	$y = 480;
	$x = 800;	$y = 600;
//	$x = 1024;	$y = 768;

	foreach( $domains as $domain ) {

		$loadedModules = loadModules();
		$urls = processDomain( $loadedModules, $domain, $x, $y );

		sleep( 20 );
		echo "<p>Fetching Pictures</p>";

		savePictures( $urls );

		foreach( $urls as $func => $module ) {

			$platform = $module['platform'];
			$version = $module['version'];
			$browser = $module['browser'];
			$url = $module['url'];

			echo "<p>
	{$platform} {$version} {$browser}<br>
	<img src='/siteGen/images/sites/{$domain}-{$x}x{$y}.png' alt='{$platform} {$version} {$browser}'>
</p>";

		}

	}

?>