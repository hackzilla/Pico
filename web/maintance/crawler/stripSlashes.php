<?

  include_once('../../fns/database.php');

  set_time_limit(0);
die();
  $cacheLink = cacheLink();
/*  
  $sql = "SELECT domainId, `page`, `header` FROM cacheHeader";
  $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  if( $res )
  {
    list($domainId, $page, $header) = $res->fetch_row();
  
    $header = $cacheLink->real_escape_string(stripslashes($header));
  
    $sql = "UPDATE cacheHeader SET header = '{$header}' WHERE domainId = '{$domainId}' AND `page` = '{$page}' LIMIT 1";
    $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  }
*/  
  $sql = "SELECT domainId, `index` FROM cacheIndex";
  $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  if( $res )
  {
    list($domainId, $index) = $res->fetch_row();
  
    $index = $cacheLink->real_escape_string(stripslashes($index));
  
    $sql = "UPDATE cacheIndex SET index = '{$index}' WHERE domainId = '{$domainId}' LIMIT 1";
    $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  }
  
  
  $sql = "SELECT domainId, `robot` FROM cacheRobot";
  $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  if( $res )
  {
    list($domainId, $robot) = $res->fetch_row();
  
    $robot = $cacheLink->real_escape_string(stripslashes($robot));
  
    $sql = "UPDATE cacheRobot SET robot = '{$robot}' WHERE domainId = '{$domainId}' LIMIT 1";
    $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  }

  /*
  $sql = "SELECT domainId, `lang`, `dialect`, `extract` FROM metadata";
  $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  if( $res )
  {
    list($domainId, $extract) = $res->fetch_row();
  
    $extract = $cacheLink->real_escape_string(stripslashes($extract));
  
    $sql = "UPDATE metadata SET extract = '{$extract}' WHERE domainId = '{$domainId}' LIMIT 1";
    $res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  }
  */

  
?>
