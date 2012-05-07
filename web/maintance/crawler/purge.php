<?

include_once('../../crawler/db_connect.php');

function remove_queue_item( $id ) {

	if( $id = (int)$id ) {

		$sql = "DELETE FROM `queue` WHERE `id`=$id LIMIT 1";
#		$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

		if( $result ) {

			return true;

		}

	}

	return false;

}

$count = 0;

// Remove blocked domains
$sql = "SELECT `queue`.`id`, `queue`.`domain` FROM `queue` LEFT JOIN `block` ON `queue`.`domain`=`block`.`domain` WHERE `block`.`domain` is not null;";
#$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

if( $result ) {

	while( list( $id, $domain ) = mysql_fetch_row( $result )) {

		echo "removed blocked: $domain <br>\n";
		remove_queue_item( $id );
		$count ++;

	}

	mysql_free_result($result);

}

// Remove blocked domains
$sql = "SELECT `queue`.`id`, `queue`.`domain`
FROM `queue`
LEFT JOIN `queue` as qd ON `queue`.`domain`=`qd`.`domain` AND `queue`.`id`<`qd`.`id`
WHERE `qd`.`domain` is not null;
";
#$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

if( $result ) {

	while( list( $id, $domain, $blkDomain) = mysql_fetch_row( $result )) {

		echo "removed duplicate: $domain <br>\n";
		remove_queue_item( $id );
		$count ++;

	}

	mysql_free_result($result);

}


print "<br>\nFinished the great purge ($count)!\n";

?>
