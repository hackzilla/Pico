<?

	$crawlerName = 'Pico';
	$crawlerVersion = '1.0.2';
	$crawlerAgent = $crawlerName . ' ' . $crawlerVersion . ' (http://pico.ofdan.com)';

#	include_once('PHP/Compat/Function/file_put_contents.php');
	include_once("functions.php");
	include_once("crawlerFunctions.php");
	include_once("runFunctions.php");
	include_once("pageFunctions.php");
	include_once("httpFunctions.php");
	include_once("languageFunctions.php");
	include_once("al.php");
	include_once('../fns/database.php');

	ini_set('user_agent', $crawlerAgent );
	ini_set( 'error_reporting', E_ALL );


if( !pidCheck( $crawlerName, $crawlerVersion )) {
	die('');
}

$cacheLink = cacheLink();
#echo "$crawlerName( $crawlerVersion ) \n";


//Get Url from mysql
$sql = "SELECT SQL_NO_CACHE `domain`.`id`, `domain`.`domain`, UNCOMPRESS(`cacheIndex`.`index`) AS `index`
FROM `cacheIndex`,`domain`
WHERE `cacheIndex`.`domainId` = `domain`.`id` AND `domain`.`status` = 'stored'";
$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

if( $result ) {

	echo "Result: " . $result . "\n";

	while( $line = $cacheLink->fetch_assoc()) {
		$id = (int)$line['id'];
		$domain = $line['domain'];

		echo "Starting $domain $id \n";
		flush();

		$page = $line['index'];
		$meta = get_meta_data( $page );

		if( $meta == false ) {
			continue;
		} else {
			processMetaTag( $id, $page, $meta );
		}

		sleep(1);
	}

	$cacheLink->free();

} else {
	# hmm no domains
	$line = false;
}

//@mysql_query( 'OPTIMIZE TABLE `queue`' );

#print "Finished the queue!<br />\n";

//sleep( 200 );

exit();

?>
