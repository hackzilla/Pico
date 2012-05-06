<?

error_reporting( E_ALL );

/*

	Consider using

	parse_url()
Array
(
    [scheme] => http
    [host] => hostname
    [user] => username
    [pass] => password
    [path] => /path
    [query] => arg=value
    [fragment] => anchor
)

*/
        $path = dirname(__FILE__) . '/';

	$crawlerName = 'Pico';
	$crawlerVersion = '1.0.1';
	$crawlerAgent = $crawlerName . ' ' . $crawlerVersion . ' (http://pico.ofdan.com)';

	include_once('PHP/Compat/Function/file_put_contents.php');
	include_once("functions.php");
	include_once("crawlerFunctions.php");
	include_once("runFunctions.php");
	include_once("pageFunctions.php");
	include_once("httpFunctions.php");
	include_once("languageFunctions.php");
	include_once("al.php");
	include_once($path.'../fns/database.php');

	ini_set('user_agent', $crawlerAgent );
	ini_set( 'error_reporting', E_ALL );


if( !pidCheck( $crawlerName, $crawlerVersion )) {
	die('');
}


#echo "$crawlerName( $crawlerVersion ) \n";

$count = 20;
while( ($domain=fetchNextReCrawlDomain()) && $count-- ) {

#	echo print_r( $domain, true );

	$domainId = (int)$domain['id'];
	$domain = trim($domain['domain']);
	$url = 'http://' . $domain;

	echo "$url \n";

	list($page, $meta) = checkPage( $domainId, $domain );

	if( $page !== false && $meta !== false ) {

		storeCache( $domainId, $page );
		update_domain_store( $domainId );

		print( 'Error 0, Complete' ."<br />\n" );

	}

	flush();

}

//@mysql_query( 'OPTIMIZE TABLE `queue`' );

#print "Finished the queue!<br />\n";

//sleep( 200 );

exit();

?>
