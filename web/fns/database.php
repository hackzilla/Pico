<?php

  function db_link()
  {
    static $link = false;
    
    if( !$link )
    {
      $link = mysqli_connect('localhost','pico','pico', 'pico');
    }
    
    return $link;
  }

  function cacheLink()
  {
    static $link = false;
    static $called = false;
    
    if( !$link && !$called )
    {
      $called = true;
      $link = @mysqli_connect('localhost','pico','pico', 'pico');
    }
    
    return $link;
  }



 /* mysql_query( $sql ) or error_sql( $sql, mysql_error() ); */
  function error_sql( $sql, $error )
  {
    $cacheLink = cacheLink();
  
  	// error_sql( $sql, mysql_error() );
  
  	$sql = $cacheLink->real_escape_string( $sql );
  	$URLerror = $cacheLink->real_escape_string( $error );
  
  	$sta= "INSERT INTO `error_sql` VALUES ( '', NOW(), '$sql', '$URLerror', '" . str_replace("'", '"', print_r( debug_backtrace(), true )) . "' )";
  	$result = $cacheLink->query( $sta ) or die( "error: " . $cacheLink->error); // or die(mysql_error() );
  	die( 'Error: ' . $sql . "<br>\n" . $error );
  }
  
  function whereMake( $values )
  {
  	$str = '1';
  	foreach( $values as $col => $value ) {
  		$str .= " AND `$col`='$value'";
  	}
  
  	return $str;
  }
  
  function setMake( $values )
  {
  	$sets = array();
  	foreach( $values as $col => $value ) {
  		$sets[] = "`$col`='$value'";
  	}
  
  	return implode( ',', $sets );
  }
  
  function insertMake( $values )
  {
  	$cols = "`" . implode( "`,`", array_keys($values)) . "`";
  	$values = "'" . implode( "','", $values ) . "'";
  
  	return array($cols, $values);
  }
  
  function insertOrUpdate ( $table, $values, $checks )
  {
    $cacheLink = cacheLink();
    
  	$where = whereMake( $checks );
  
  	$sql = "SELECT 1 FROM `{$table}` WHERE " . $where . " LIMIT 1";
  	$res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  	if( $res ) {
  
  		if( $res->num_rows ) {
  			$set = setMake( $values );
  			$sql = "UPDATE `{$table}` SET $set WHERE " . $where . " LIMIT 1";
  		} else {
  
  			list( $cols, $values ) = insertMake( $values + $checks );
  			$sql = "INSERT INTO `{$table}` ({$cols}) VALUES ({$values})";
  
  		}
  
  #		die( $sql );
  
  		$res = $cacheLink->query($sql) or error_sql( $sql, $cacheLink->error );
  
  	} else {
  		return false;
  	}
  
  }

?>
