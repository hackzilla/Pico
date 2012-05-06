<?

#	session_start();

#	echo "<html><head></head><body>\n";

	$path =  dirname(__FILE__) . '/';

#	include_once( $path . '../../crawler2/db_connect.php' );
#	include_once( $path . '../../crawler2/functions.php' );
#	include_once( $path . '../../crawler2/crawlerFunctions.php' );
#	include_once( $path . '../../crawler2/pageFunctions.php' );
#	include_once( $path . '../../crawler2/languageFunctions.php' );

	$stats = eval('include("' . $path . '../../static/5a.php' . '");');
	
	$fp = fopen( $path . '../../static/5.php', 'w');

	fwrite($fp, $stats);

	fclose($fp);

?>