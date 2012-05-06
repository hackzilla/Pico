<?php

// Name of Skin Folder to use
$skin = "/default/";

//error_reporting(0);
#include("crawler2/db_connect.php");
include("config.php");
include("fns/database.php");

function showAds( $content )
{
  $showAds = true;
  
  $content = strtolower($content);
  
  $banned = array('xxx','shemale','heshe','tranny','porn','ladyboy','dick','cock','transvestite','hermaphrodite','fuck');#,'','','','','','','','','','',''
  
  foreach( $banned as $word )
  {
    if( strpos( $content, $word ) !== false )
    {
      $showAds = false;
      break;
    }
  }
  
  return $showAds;
}

/* Old Method.. */

if( isset( $_REQUEST['q']) )
{
	$query = trim($_REQUEST['q']);
}
else
{
	$query = '';
}

if( isset( $_REQUEST['p']) )
{
	$page = (int)$_REQUEST['p'];
} else {
	$page = '';
}

if( isset( $_REQUEST['s'])) {
	$static = (int)$_REQUEST['s'];
} else {
	$static = '';
}

if( isset($_REQUEST['cc']) )
{
  $cc = $_REQUEST['cc'];
}
else
{
  $cc = '';
}
/* End old method */


/* New method */
$args = explode('/', $_SERVER['REQUEST_URI'] );

$count = count($args);

for( $i = 1; $i < $count; $i += 2 )
{
  if( isset($args[$i]) && isset($args[$i+1]) )
  {
    switch( $args[$i] )
    {
      case 'q':
        $query = trim($args[$i+1]);
        break;
        
      case 'p':
        $page = (int)($args[$i+1]);
        break;
        
      case 's':
        $static = (int)($args[$i+1]);
        break;
        
      case 'cc':
        $cc = trim($args[$i+1]);
        break;
        
    }
  }
}
/* End new method */

$query = urldecode($query);
$cc = preg_replace( '/[^a-z]/', '', $cc);


if( isset($_REQUEST['debug'] ) )
{
  phpinfo();
}



if ($page <= 0) $page = 1;

if( $query )
{
  $title = 'Your Search: '.strip_tags($query);
}
else
{
  switch( $static )
  {
    case 1:
      $title = 'About';
      break;
    
    case 2:
      $title = 'Licence';
      break;
    
    case 3:
      $title = 'Download';
      break;
    
    case 4:
      $title = 'Add Your Site';
      break;
    
    case 5:
      $title = 'Statistics';
      break;
    
    case 6:
      $title = 'Spy';
      break;
    
    case 7:
      $title = 'Words';
      break;
    
    default:
      $title = 'The Internet underbelly Search';
  }
}

// display header
include("header.php");


// show logo
$logoid = rand(1,20);
include("logo.php");

// show search box
include("box.php");

// show results
if ($query) {
	include("results.php");

	$results = getResults($query, $page, $cc);

	$showAds = false; #showAds( $results );
	
	if( $showAds )
	{
    //<!--/* OpenX Local Mode Tag v2.6.0 */-->
  
    define('MAX_PATH', '/www/sites/ofdan.com/htdocs/openads');
    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
      if (!isset($phpAds_context)) {
        $phpAds_context = array();
      }
      $phpAds_raw = view_local('', 4, 0, 0, '', '', '0', $phpAds_context, '');
    }
    echo $phpAds_raw['html'];
    echo '<br />
<br />
';  
  }

	echo $results;

	if( $showAds )
	{
    //<!--/* OpenX Local Mode Tag v2.6.0 */-->
  
#    define('MAX_PATH', '/www/sites/ofdan.com/htdocs/openads');
    if (@include_once(MAX_PATH . '/www/delivery/alocal.php')) {
      if (!isset($phpAds_context)) {
        $phpAds_context = array();
      }
      $phpAds_raw = view_local('', 5, 0, 0, '', '', '0', $phpAds_context, '');
    }
    echo $phpAds_raw['html'];
    echo '<br />
<br />
';  
  }

} else {

	if ($static) {
		include("static.php");
	}

}

// show footer
include("footer.php");

?>
