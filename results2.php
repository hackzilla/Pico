<?

	function checkSpelling( $str ) {

		$words = preg_split('/[ ,;.]/', $str );

		$incorrectWords = array();
		$int = @pspell_new('en_GB-w-accents');

		if( $int )
		{

			foreach( $words as $word ) {
	
				if( !pspell_check( $int, $word ) ) {
					$suggest = pspell_suggest($int, $word);
					$incorrectWords[$word] = '<strong>'.$suggest[0].'</strong>';
				}
	
			}
	
			$correctWords = array_values( $incorrectWords );
			$incorrectWords = array_keys( $incorrectWords );

			$checkedStr = str_replace( $incorrectWords, $correctWords, $str );

		}
		else
		{
			$checkedStr = $str;
		}

		return $checkedStr;

	}

  function getResults()
  {
  
    $results = '<div id="results">';
    
    $cc = preg_replace( '/[^a-z]/', '', (isset($_REQUEST['cc']) ? $_REQUEST['cc'] : '' ));
    
    //$spelling = $query;
    $spelling = checkSpelling( $query );
    
    if( $spelling != $query ) {
    	$results .= "<p class='spelling'>Did you mean: <a href='{$_SERVER['PHP_SELF']}?q=".strip_tags($spelling)."'>{$spelling}</a>";
    }
    
    $thumbsDir = 'siteGen/images/thumbs/';
    
    $qnow = " AND (keyword='";
    $qnow .= implode( "' OR keyword='", explode(" ", $query));
    $qnow .= "')";
    
    if( strlen( $cc ) == 2 ) {
    	$qnow .= " AND `metadata`.`lang`='$cc'";
    	$join = " LEFT JOIN `metadata` ON `metadata`.`domainId` = `domain`.`id`";
    } else {
    	$join = '';
    }
    
    #
    
    $squirt = "SELECT `domain`.`domain`, SUM(`score`) as rank, COUNT(`domain`) as count
    FROM `keyword2`,`rank2`,`domain`
    $join
    WHERE `domain`.`status`='stored' AND `domain`.`id`=`rank2`.`domainId` AND `keyword2`.`id`=`rank2`.`keyword_id` $qnow
    GROUP BY `domain`.`domain`
    ORDER BY `rank` DESC
    ";
    $result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );
    
    if( $result ) {
    	$totalcount = @mysql_num_rows($result);
    } else {
    	$totalcount = 0;
    }
    $pagestart = ($page - 1)*10;
    $pageend = $pagestart + 9;
    
    if (($pageend + 1) > $totalcount) $pageend = $totalcount - 1;
    if (($pagestart + 1) > $totalcount) $totalcount = 0;
    
    if ($totalcount > 0) {
    
    	$results .= "<p>Showing  " . ($pagestart + 1) . "-" . ($pageend + 1) . " of " . $totalcount . ":</p>\n";
    	$results .= "<ol start='" . ($pagestart + 1) . "'>\n\n";
    
    	$squirt = "SELECT `domain`.`domain`, SUM(`score`) as rank, COUNT(`domain`) as count
    	FROM `keyword2`,`rank2`,`domain`
    	$join
    	WHERE `domain`.`status`='stored' AND `domain`.`id`=`rank2`.`domainId` AND `keyword2`.`id`=`rank2`.`keyword_id` $qnow
    	GROUP BY `domain`.`domain`
    	ORDER BY `rank` DESC
    	LIMIT " . $pagestart . ",10
    	";
    
    	$result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );
    
    	while( $line = mysql_fetch_assoc($result) ) {
    
    //		$squirt = "SELECT domain, id, status, DATE_FORMAT(nextindex,'%D %y %a'),DATE_FORMAT(lastindex'%D %y %a') FROM domain WHERE domain='" . $line['domain'] . "';";
    		$squirt = "SELECT domain.*, metadata.extract FROM domain
    		LEFT JOIN metadata ON metadata.domainId = domain.id
    		WHERE domain='" . $line['domain'] . "' ;";
    		$results = mysql_query($squirt) or error_sql( $squirt, mysql_error() );
    
    		$data = mysql_fetch_assoc($results);
    		mysql_free_result($results);
    
    		// $results .= "<P>" . $line[0] . "-" . $line[1] . "</p>";
    
    		$results .= "<li>\n";
    
    		$filename = $thumbsDir . $line['domain'] . '.png';
    		if( file_exists($filename) && (filesize($filename) > 100000)) {
    			$results .= "<img src='{$filename}' alt='{$line['domain']}' \n";
    		}
    
    		$results .= "<div class='box'><a href='http://" . $line['domain'] . "/'>" . $line['domain'] . "</a><br />\n";
    
    		if ($data['extract']) {
    			$results .= $data['extract'] . " ...<br />\n";
    		} else {
    			$results .= "No extract available ...<br />\n";
    		}
    
    		$rank = $line['rank'];
    		$count = $line['count'];
    
    		$score = ($rank / $count) / 10000;
    		$score = $score * 100;
    
    		if( !$score ) {
    			$score = 0;
    		}
    
    	//	$results .= "<em>Score: $score% - Last Index: " . date("j-M-Y", $data['lastindex']) . " - Next Index: " . date("j-M-Y", $data['nextindex']) . "</em>";
    		$squirt = "SELECT `cacheIndex`.domainId FROM `cacheIndex`
    		LEFT JOIN `domain` ON `domain`.`id`=`cacheIndex`.`domainId`
    		WHERE `domain`.`domain`='" . $data['domain'] . "';";
    		$resultc = mysql_query($squirt) or error_sql( $squirt, mysql_error() );
    
    		$lastIndex = 'Last Index: ' . $data['lastindex'];
    
    		if( $data['nextindex'] ) {
    			$nextIndex = ' Next Index: ' . $data['nextindex'] . ' -';
    		}
    
    		if (@mysql_numrows($resultc)) {
    			$results .= "<em>{$lastIndex} -{$nextIndex} <a href='/pico/cache.php?domain=" . urlencode($data['domain']) . "'>Cached</a></em>\n";
    		} else {
    			$results .= "<em>{$lastIndex} -{$nextIndex} No cache</em>\n";
    		}
    		$results .= "</div>\n</li>\n\n";
    
    		mysql_free_result($resultc);
    
    	}
    
    	mysql_free_result($result);
    
    
    
    	// RECORD SEARCH
    
    	$ipaddress = $_SERVER['REMOTE_ADDR'];
    	$q = $query;
    	$seek = number_format(microtime(),2) . "s";
    
    	$squirt = "INSERT INTO `logSearch` ( `ip` , `datetime` , `q` , `seek` ) VALUES ('" . $ipaddress . "', NOW(), '" . $q . "', '" . $seek . "');";
    	$result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );
    
    	$results .= "\n\n</ol>";
    
    	if ($page == 1) {
    		$lastp = "&nbsp;";
    	} else {
    		$lastp = "<a href='/pico/?q=" . $query . "&p=" . ($page - 1) . "'>Last Page</a>";
    	}
    
    	if (($pageend + 1) < $totalcount) {
    		$nextp = "<a href='/pico/?q=" . $query . "&p=" . ($page + 1) . "'>Next Page</a>";
    	} else {
    		$nextp = "&nbsp;";
    	}
    
    	$results .= "<table border='0' width='100%'><tr><td><p>" . $lastp . "</td><td><p align='right'>" . $nextp . "</td></tr></table>";
    
    } else {
    
    	$results .= '<p>Sorry, <strong>no results</strong> were found in the database. Please try the following:</p>
    <ol>
    <li>Check your spelling carefully</li>
    <li>Try different words with the same meaning</li>
    <li>Be less specific in your search</li>
    <li>Search for something else, like porn</li>
    </ol>
    ';
    
    }
    
    $results .= '</div>
    <br />';

    return $results;

  }

?>
