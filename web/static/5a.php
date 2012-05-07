<?

	include( dirname(__FILE__) . '/../crawler2/db_connect.php');

?><div id="static">
<h1>Statistics</h1>
<p>Below are a number of raw statistics that have been provided by the database. These are updated once a day
and can be refreshed by pressing F5. Hover over a statistic heading for further information.</p>
<?

// seek time
/*
$squirt = "SELECT  FROM log ORDER BY datetime DESC LIMIT 0,5;";
$result = mysql_query($squirt);
$data = mysql_fetch_array($result);
$seek = number_format($data[0],2);
mysql_free_result($result);
*/
// searches
$squirt = "SELECT COUNT(*) FROM logSearch;";
$result = mysql_query($squirt);
$total = mysql_result($result,0,"count(*)");
mysql_free_result($result);

// searches in 24 hours
$squirt = "SELECT COUNT(*), AVG(seek) FROM logSearch WHERE datetime > DATE_SUB(CURDATE(),INTERVAL 1 DAY);";
$result = mysql_query($squirt);
$data = mysql_fetch_row($result);
$seek = number_format($data[1],2);
$totalday = $data[0];
mysql_free_result($result);

// words
/*
$squirt = "SELECT COUNT(*) FROM keyword;";
$result = mysql_query($squirt);
$words = mysql_result($result,0,"count(*)");
mysql_free_result($result);
*/
// word length
$squirt = "SELECT MIN( @len:= CHAR_LENGTH(`keyword` )), MAX( @len), AVG( @len), COUNT(*) FROM `keyword2`";
$result = mysql_query( $squirt );
list($lenmin,$lenmax,$lenave,$words) = mysql_fetch_row( $result );
@mysql_free_result( $result );

$lenave = number_format($lenave, 2);

// domains
$squirt = "SELECT status, COUNT(*) FROM domain GROUP BY status ORDER BY status ASC;";
$result = mysql_query($squirt);
while( list( $status, $count ) = mysql_fetch_row($result)) {
	if( $status == 'blocked' ) {
		$blocked = $count;
	} else if( $status == 'queue' ) {
		$queue = $count;
	} else if( $status == 'stored' ) {
		$domains = $count;
	}
}

mysql_free_result($result);


// cached
$squirt = "SELECT COUNT(*) FROM `cacheIndex`";
$result = mysql_query($squirt) or die( mysql_error());
$cached = mysql_result($result,0);
mysql_free_result($result);

// robots
$squirt = "SELECT COUNT(*) FROM `cacheRobot`";
$result = mysql_query($squirt) or die( mysql_error());
$robots = mysql_result($result,0);
mysql_free_result($result);


/*
// blocked
$squirt = "SELECT COUNT(*) FROM block;";
$result = mysql_query($squirt);
$blocked = mysql_result($result,0);
mysql_free_result($result);
*/

// lang
$squirt = "SELECT COUNT(*) FROM metadata WHERE `lang` != '';";
$result = mysql_query($squirt) or die( mysql_error());
$lang = mysql_result($result,0);
mysql_free_result($result);
$lang = number_format(($lang/$domains)*100, 2);

/*
// queue
$squirt = "SELECT COUNT(*) FROM queue;";
$result = mysql_query($squirt);
$queue = mysql_result($result,0);
mysql_free_result($result);
*/

// %age updated
$squirt = "SELECT COUNT(*) FROM domain WHERE domain.status = 'stored' AND nextindex < NOW();";
// $squirt = "SELECT COUNT(*) FROM edward WHERE lastindex > " . (time() - (60 * 60 * 24 * 14)) . ";";
$result = mysql_query($squirt);
$updated = mysql_result($result,0);
mysql_free_result($result);

// echo $updated;
$uptodate = number_format(($updated/$domains)*100, 2);

// processor load

?>
<p><strong>Queries</strong></p>

<ul>
	<li><strong><a class="info" title="How long, on average, each search of the database has taken. This is a sample from the last ten web searches.">Average Seek</a>:</strong> <?php echo $seek; ?> seconds</li>
	<li><strong><a class="info" title="The total number of searches performed on this web site. This includes multiple searches from the same computer in the same session.">Total Queries:</a></strong> <?php echo number_format($total); ?></li>
	<li><strong><a class="info" title="The total number of searches performed in the last 24 hours - a subset of the total displayed above.">Last 24 hours:</a></strong> <?php echo $totalday; ?></li>
</ul>

<p><strong>Known Universe</strong></p>

<ul>
	<li><strong><a class="info" title="The percentage of domains that the content language is known.">Known language:</a></strong> <?php echo number_format($lang, 2); ?>% of database</li>
	<li><strong><a class="info" title="How many keywords are currently available in the database to search. Each domain name is scanned for important words and stored in the database.">Known Words:</a></strong> <?php echo number_format($words); ?></li>
	<li><strong><a class="info" title="The length of keywords stored in the database in the format (min, mean, max).">Word Length:</a></strong> <?php echo $lenmin; ?>, <?php echo $lenave; ?>, <?php echo $lenmax; ?></li>
	<li><strong><a class="info" title="The total number of domain names that have been spidered and recognised by the search engine. Blocked domain names are not included in this statistic.">Known Domains:</a></strong> <?php echo number_format($domains); ?></li>
	<li><strong><a class="info" title="The number of domain names in the database that also keep a copy of the home page cached for future reference. You can view the cached entry by clicking 'Cache' on the search result if one is available.">Domains Cached:</a></strong> <?php echo number_format($cached); ?></li>
	<li><strong><a class="info" title="The number of domain names in the database that we hav a copy of the robots file for future reference.">Domains Robots:</a></strong> <?php echo number_format($robots); ?></li>
	<li><strong><a class="info" title="The number of domains blocked from inclusion in the search engine. This may be due to spamming, privacy issues, incorrect or incomplete code, or the inability to determine content. Blocked sites remain in this database for one year.">Domains Blocked:</a></strong> <?php echo number_format($blocked); ?></li>
</ul>

<p><strong>Crawler</strong></p>

<ul>
	<li><strong><a class="info" title="The number of domains currently queued to be spidered and included in the search engine. This also includes sites that are queued to be revisited.">Queue Length:</a></strong> <?php echo number_format($queue); ?></li>
	<li><strong><a class="info" title="Estimated number of days for queue to be cleared (this will probably never happen)">Estimated Crawl Time:</a></strong> Approx. <?php echo intval($queue/7200) + 1; ?> day(s)</li>
	<li><strong><a class="info" title="A percentage of the complete database waiting to be re-spidered. We attempt to visit each domain every two weeks (unless told otherwise in meta tags) to keep our database fresh.">Awaiting Re-visit:</a></strong> <?php echo $uptodate; ?>% of database</li>
</ul>
<?
/*
<p><strong>Available Capacity</strong></p>

<ul>
<li><strong><a class="info" title="Remaining quota for this search engine's database.">Disk Storage:</a></strong>
<?php echo $diskstorage; ?></li>
<li><strong><a class="info" title="Current processor load of the server, as formatted by the Linux uptime
command.">Processor load:</a></strong> <?php echo $processor; ?></li>
</ul>
*/
?>
</div>
<br />