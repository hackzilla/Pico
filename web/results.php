<?

	function checkSpelling( $str ) {

		$words = preg_split('/[ ,;.]/', $str );

		$incorrectWords = array();
		$int = pspell_new('en_GB-w-accents');

		if( $int )
		{
			foreach( $words as $word ) {

				if( !pspell_check( $int, $word ) ) {
					$suggest = pspell_suggest($int, $word);
					if( isset($suggest[0]) )
					{
						$incorrectWords[$word] = '<strong>'.$suggest[0].'</strong>';
					}
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

  function getResults($query, $page, $cc = '')
  {
#    $cacheLink = cacheLink();
    $mysqlLink = db_link();
  
    $results = '<div id="results">';
        
    //$spelling = $query;
    $spelling = checkSpelling( strip_tags($query) );
    
    if( $spelling != $query ) {
    	$results .= "<p class='spelling'>Did you mean: <a href='/q/".urlencode(strip_tags($spelling))."/'>{$spelling}</a>";
    }

    $thumbsDir = 'siteGen/images/thumbs/';
    $sqlQuery = $mysqlLink->real_escape_string($query);

    $qnow = " AND (keyword='";
    $qnow .= implode( "' OR keyword='", explode(" ", $sqlQuery));
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
    $result = $mysqlLink->query($squirt) or error_sql( $squirt, $mysqlLink->error );
    
    if( $result ) {
    	$totalcount = $result->num_rows;
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
    
    	$result = $mysqlLink->query($squirt) or error_sql( $squirt, $mysqlLink->error );
    
    	while( $line = $result->fetch_assoc() ) {
    
    //		$squirt = "SELECT domain, id, status, DATE_FORMAT(nextindex,'%D %y %a'),DATE_FORMAT(lastindex'%D %y %a') FROM domain WHERE domain='" . $line['domain'] . "';";
    		$squirt = "SELECT domain.*, metadata.extract FROM domain
    		LEFT JOIN metadata ON metadata.domainId = domain.id
    		WHERE domain='" . $line['domain'] . "' ;";
    		$result2 = $mysqlLink->query($squirt) or error_sql( $squirt, $mysqlLink->error );
    
    		$data = $result2->fetch_assoc();
    		$result2->free();

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
    		$resultc = $mysqlLink->query($squirt) or error_sql( $squirt, $mysqlLink->error );
    
    		$lastIndex = 'Last Index: ' . $data['lastindex'];
    
    		if( $data['nextindex'] ) {
    			$nextIndex = ' Next Index: ' . $data['nextindex'] . ' -';
    		}
    
    		if ($resultc->num_rows) {
    			$results .= "<em>{$lastIndex} -{$nextIndex} <a href='/pico/cache.php?domain=" . urlencode($data['domain']) . "'>Cached</a></em>\n";
    		} else {
    			$results .= "<em>{$lastIndex} -{$nextIndex} No cache</em>\n";
    		}
    		$results .= "</div>\n</li>\n\n";
    
    		$resultc->free();
    
    	}
    
    	$result->free();
    
    
    
    	// RECORD SEARCH
    
    	$ipaddress = preg_replace('/[^0-9.:A-Fa-f]/','',$_SERVER['REMOTE_ADDR']);
#    	$seek = '?s';#number_format(microtime(),2) . "s";
	$seek = number_format(preg_replace('/[ ]/', '', microtime()),2) . "s"; 

    	$squirt = "INSERT INTO `logSearch` ( `ip` , `datetime` , `q` , `seek` ) VALUES ('" . $ipaddress . "', NOW(), '" . $sqlQuery . "', '" . $seek . "');";
    	$result = $mysqlLink->query($squirt) or error_sql( $squirt, $mysqlLink->error );
    
    	$results .= "\n\n</ol>";
    
    	if ($page == 1) {
    		$lastp = "&nbsp;";
    	} else {
    		$lastp = "<a href='/q/" . urlencode($query) . "/p/" . ($page - 1) . "/'>Last Page</a>";
    	}
    
    	if (($pageend + 1) < $totalcount) {
    		$nextp = "<a href='/q/" . urlencode($query) . "/p/" . ($page + 1) . "/'>Next Page</a>";
    	} else {
    		$nextp = "&nbsp;";
    	}
    
    	$results .= "<table border='0' width='100%'><tr><td>" . $lastp . "</td><td align='right'>" . $nextp . "</td></tr></table>";
    
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
