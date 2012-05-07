<?

function check_rights( $domainId, $server ) {

	$url = $server.'robots.txt';

	$page = get_page( $domainId, 'robot', $url );

	if( $page !== false ) {
		storeRobot( $domainId, $page );
	}

	return true;

}

function storeHeader( $domainId, $page, $headers ) {

	if( is_array( $headers ) && count( $headers ))
  {
    $cacheLink = cacheLink();
		$headers = $cacheLink->real_escape_string(serialize( $headers ));

		$sql = "SELECT `domainId` FROM `cacheHeader` WHERE `page` = '{$page}' AND `domainId` = '$domainId'";
		$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		if( $res && ( $res->num_rows >0 )) {

			$res->free() or error_sql( $sql, $cacheLink->error );

			$sql = "UPDATE `cacheHeader` SET `date` = NOW(), `header` = compress('{$headers}') WHERE `page` = '{$page}' AND `domainId` = '$domainId'";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		} else {

			$sql = "INSERT INTO `cacheHeader` (`domainId`,`date`,`page`,`header`) VALUES ('$domainId', NOW(), '{$page}', compress('{$headers}'))";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		}
	} else {
		echo "No headers \n";
	}
}

function storeCache( $domainId, $page )
{
	if( $page != '' )
  {
    $cacheLink = cacheLink();
		$page = $cacheLink->real_escape_string( $page );

		$sql = "SELECT `domainId` FROM `cacheIndex` WHERE `domainId` = '$domainId'";
		$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		if( $res && ( $res->num_rows >0 ))
    {
			$res->free() or error_sql( $sql, $cacheLink->error );

			$sql = "UPDATE `cacheIndex` SET `date` = NOW(), `index` = compress('{$page}') WHERE `domainId` = '$domainId'";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}
    else
    {
			$sql = "INSERT INTO `cacheIndex` (`domainId`, `date`,`index`) VALUES ('$domainId', NOW(), compress('{$page}'))";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}
	}
}

function storeRobot( $domainId, $page ) {

	if( $page != '' ) {
    $cacheLink = cacheLink();
		$page = $cacheLink->real_escape_string( $page );

		$sql = "SELECT `domainId` FROM `cacheRobot` WHERE `domainId` = '$domainId'";
		$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		if( $res && ( $res->num_rows >0 ))
    {
			$res->free() or error_sql( $sql, $cacheLink->error );

			$sql = "UPDATE `cacheRobot` SET `date` = NOW(), `robot` = compress('{$page}') WHERE `domainId` = '$domainId'";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}
    else
    {
			$sql = "INSERT INTO `cacheRobot` (`domainId`, `date`,`robot`) VALUES ('$domainId', NOW(), compress('{$page}'))";
			$res = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}
	}
}
/*
function delay_domain( $domainId )
{
	if( $domainId = (int)$domainId )
  {
    $cacheLink = cacheLink();

		$sql = "UPDATE `domain` SET `lastindex`=NOW() WHERE id = {$domainId} LIMIT 1";
		$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		return $result;

	} else {
		return false;
	}
}
*/
function block_domain( $domainId, $reason = 'none', $info = '' )
{
	if( $domainId = (int)$domainId )
  {
    $cacheLink = cacheLink();

		$reason = $cacheLink->real_escape_string($reason);
		$info =   $cacheLink->real_escape_string($info);

		$table = 'logBlock';
		$check = array('domainId'=>$domainId);
		$values = array();
		$values['date'] = date('Y-m-d H:i:s');
		$values['reason'] = $reason;
		$values['info'] = $info;

		insertOrUpdate ( $table, $values, $check );

		$sql = "UPDATE `domain` SET `status`='blocked', `lastindex`=NOW() WHERE id = {$domainId} LIMIT 1";
		$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		return $result;

	} else {
		return false;
	}

}
function update_domain_store( $domainId )
{
  $cacheLink = cacheLink();
  
	$sql = "UPDATE `domain` SET `status` = 'stored', `lastindex`=NOW() WHERE id ='{$domainId}'";
	$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	return $result;
}

function update_domain_pause( $domainId )
{
  $cacheLink = cacheLink();

	$sql = "UPDATE `domain` SET `status` = 'paused', `lastindex`=NOW() WHERE id ='{$domainId}'";
	$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	return $result;
}

function getDomainId( $domain )
{
  $cacheLink = cacheLink();
	
	$sql = "SELECT `id` FROM `domain` WHERE `domain`.`domain` = '{$domain}'";
	$result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
	
	if( $result && $result->num_rows ) {
		list($domainId) = $result->fetch_row();
		return $domainId;
	} else {		
		return false;
	}
}

function add_domain_link( $domainId, $fromDomain )
{
	if( $domainId && $fromDomain )
  {
    $cacheLink = cacheLink();
		# get domain Id for both
		
#		$domainId = getDomainId($domain);
		$fromDomainId = getDomainId($fromDomain);
		
		if( $domainId && $fromDomainId ) {
			
			$sql = "INSERT INTO cacheLinks(`domainId`,`linkDomainId`) VALUES ($domainId, $fromDomainId)";
      $result = $cacheLink->query( $sql );# or error_sql( $sql, $cacheLink->error );

			return $result;
			
		} else {
			return false;	
		}
		
	} else {
		return false;
	}

}

function add_queue_item( $domain ) {

	if($domain = getFilteredDomain( $domain )) {

		if( getDomainId( $domain ) === false )
		{
      $cacheLink = cacheLink();
      
			$nextindex = processMetaRevist( array() );
			$sql = "INSERT INTO `domain` ( `domain`, `status`,`nextindex`,`lastindex` ) VALUES ('" . $domain . "', 'queue', {$nextindex}, NOW() );";
      $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}
	}
}

function remove_queue_item( $domainId ) {

	if( $domainId = (int)$domainId ) {

    $cacheLink = cacheLink();

		$sql = "UPDATE `domain` SET `status`='paused', `lastindex`=NOW() WHERE `id`={$domainId} LIMIT 1";
    $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

		return $result;
	}

	return false;
}

function addKeyword( $domainId, $word, $rank = 2500 )
{
  if( strlen($word) < 101 )
  {
    $cacheLink = cacheLink();

  	$sql = "LOCK TABLES `keyword2` WRITE";
    $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
  
  
  	$sql = "SELECT `id` FROM `keyword2` WHERE `keyword`='{$word}' LIMIT 1;";
    $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
  
  	if( $result ) {
  
  		$line = $result->fetch_array();
  		$result->free();
  
  		$id = $line['id'];
  	}
  
  	if( !$id ) {
  
  		$sql = "INSERT INTO `keyword2` VALUES ( '', '{$word}');";
      $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
  
  		$id = $cacheLink->insert_id;
  	}
  
  	if( $id ) {
  
  		$sql = "INSERT INTO `rank2` VALUES ( '$id', '$domainId', $rank );";
      $result = $cacheLink->query( $sql );# or error_sql( $sql, $cacheLink->error );
  	}
  
  	$sql = "UNLOCK TABLES";
    $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
  }

	return true;
}

function removeKeyword( $keywordId )
{
  $cacheLink = cacheLink();

	// remove keyword
	$sql = "DELETE FROM `keyword2` WHERE `id` = '{$keywordId}'";
  $result = $cacheLink->query( $sql );# or error_sql( $sql, $cacheLink->error );

	// remove rank
	$sql = "DELETE FROM `rank2` WHERE `keyword_id` = '{$keywordId}'";
  $result = $cacheLink->query( $sql );# or error_sql( $sql, $cacheLink->error );

	return $result && $result2;
}

function fetchNextReCrawlDomain()
{
  $cacheLink = cacheLink();

	$sql = "LOCK TABLES `domain` WRITE";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	//Get Url from mysql
	$sql = "SELECT `domain`.`id`, `domain`.`domain`
	FROM `domain`
	WHERE `domain`.`status` = 'stored' AND `domain`.`nextindex` < NOW()
	ORDER BY `domain`.`nextindex` ASC, `domain`.`lastindex` ASC, `domain`.`id` ASC LIMIT 1;";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	if( $result ) {

		$line = $result->fetch_assoc();

		if(!empty($line)) {
			$id_queue = (int)$line['id'];
			$line['url'] = 'http://' . $line['domain'];
			$domain = $line['domain'];

			$sql = "UPDATE `domain` SET `lastindex` = NOW(), status = 'processing' WHERE `id` = '{$id_queue}'";
      $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}

		$result->free();

	}
  else
  {
		$line = array();
	}

	$sql = "UNLOCK TABLES";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	return $line;

}

function fetchNextQueueDomain()
{
  $cacheLink = cacheLink();

	$sql = "LOCK TABLES `domain` WRITE";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	//Get Url from mysql
	$sql = "SELECT `domain`.`id`, `domain`.`domain`
	FROM `domain`
	WHERE `domain`.`status` = 'queue'
	ORDER BY `domain`.`id` ASC,`domain`.`lastindex` ASC LIMIT 1;";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	if( $result ) {

		$line = $result->fetch_assoc();

		if(!empty($line)) {
			$id_queue = (int)$line['id'];
			$line['url'] = 'http://' . $line['domain'];
			$domain = $line['domain'];

			$sql = "UPDATE `domain` SET `lastindex` = NOW(), status = 'processing' WHERE `id` = '{$id_queue}'";
      $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );
		}

		$result->free();

	} else {
		$line = array();
	}

	$sql = "UNLOCK TABLES";
  $result = $cacheLink->query( $sql ) or error_sql( $sql, $cacheLink->error );

	return $line;

}

?>
