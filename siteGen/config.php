<?

//	ini_set( 'display_errors', 1 );
//	ini_set('error_reporting', E_ALL );

	set_time_limit( 120 );

	$config = array();
	$config['dirSep'] = '/';
//	$config['dirSep'] = '\\';
	$config['basePath'] = dirname( __FILE__ );
	$config['generatorPath'] = $config['basePath'] . $config['dirSep'] . 'generators';
	$config['imagePath'] = $config['basePath'] . $config['dirSep'] . 'images';
	$config['thumbsPath'] = $config['basePath'] . $config['dirSep'] . 'images' . $config['dirSep'] . 'thumbs';
	$config['sitesPath'] = $config['basePath'] . $config['dirSep'] . 'images' . $config['dirSep'] . 'sites';



?>