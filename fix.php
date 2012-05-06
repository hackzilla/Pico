<?

include_once('db_connect.php');

/*
		if (eregi ("<meta name=\"keywords\" content=[^>]*", $page, $descresult))
		{
			$explod = explode("<meta name=\"keywords\" content=", $descresult[0]);
			$keyword = preg_replace( '/[^a-z0-9 -]/', ' ', crop( $explod[1] ));

			// filter list and the etc
			// and block list www.microsoft.com

			if( strlen( $keyword ) < 3 ) {

				$keyword = '';

			}
		}
*/

function remove_keyword( $id ) {

	if( $id ) {

		$sql = "DELETE FROM `keyword` WHERE `id` = '$id';";
		$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

		$sql = "DELETE FROM `rank` WHERE `keyword_id` = '$id';";
		$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

	}

}

/*
function remove_rank( $id ) {

	if( $id ) {

		$sql = "DELETE FROM `rank` WHERE `id` = '$id';";
		$result = mysql_query( $sql ) or die( mysql_error() );

	}

}
*/
function update_keyword( $id, $keyword ) {

	$sql = "UPDATE `keyword` SET `keyword`='$keyword' WHERE `id` = '$id' LIMIT 1;";
	$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

	if( !$result ) {

		// keyword probably already exist.

		$sql = "SELECT `id` FROM `keyword` WHERE `id`='$id' LIMIT 1;";
		$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

		$line = mysql_fetch_array( $result );

		if( $org_id = $line['id'] ) {

			$sql = "UPDATE `rank` SET `keyword_id`='$org_id' WHERE `keyword_id`='$id'";
			$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

			$sql = "DELETE FROM `keyword` WHERE `id` = '$id';";
			$result = mysql_query( $sql ) or error_sql( $squirt, mysql_error() );

		} else {

			echo "Error can't update and can't get org id ( $id, $keyword ).\n";

		}

	} else {

		print "$result\n";

	}

}

if( $id = $_GET['keyword_id'] ) {

	remove_keyword( $id );

}

	$sql = "SELECT `id` FROM `keyword` WHERE LENGTH(`keyword`) > 100;";
	$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );
	while( $line = @mysql_fetch_array( $result ) ) {
		remove_keyword( $line['id'] );
	}

// remove words with crap chars
	$sql = "SELECT `id`,`keyword` FROM `keyword` WHERE `keyword`LIKE'%(%' OR `keyword`LIKE'%)%' OR `keyword`LIKE'%;%' OR CHAR_LENGTH(`keyword`)<3;";
	$result = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

	while( $line = @mysql_fetch_array( $result ) ) {

		$id = $line['id'];

		$org = $line['keyword'];

		$keyword = preg_replace( '/[^a-z0-9 -]/', '', strtolower( trim( $org )) );

		if( !$keyword ) {

			remove_keyword( $id );

		} else if( strlen( $keyword ) < 3 ) {

			remove_keyword( $id );

		} else if( $org != $keyword) {

			update_keyword( $id, $keyword );

		}

		print "$keyword - $org \n";

	}

	@mysql_free_result( $result );

	die();

?>
