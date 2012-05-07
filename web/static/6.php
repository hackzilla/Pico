<div id="static">

<h1>Live Search Spy</h1>
<p>This is an uncensored list of all searches currently taking place.</p>

<ul>

<?php

	$squirt = "SELECT q, UNIX_TIMESTAMP(datetime) as datetime, ip FROM logSearch ORDER BY id DESC LIMIT 0,10;";
	$result = mysql_query($squirt, $con);

	$counter = 0;
	$counttop = mysql_num_rows($result);
	while ($counter < $counttop) {
		$data = mysql_fetch_array($result);
		$user = gethostbyaddr($data['ip']);

		$userbits = explode( '.', $user );
		$userCount = count( $userbits ) -1;

		if( strlen( $userbits[$userCount] ) == 2 ) {
			$user = "{$userbits[$userCount-2]}.{$userbits[$userCount-1]}.{$userbits[$userCount]}";
		} else {
			$user = "{$userbits[$userCount-1]}.{$userbits[$userCount]}";
		}

		echo "<li><a href='/q/" . urlencode($data['q']) . "/'>" . $data['q'] . "</a> by " . $user . " on " . date("d-M-Y", $data['datetime']) 
. 
"</li>";
		$counter++;
	}

?>

</ul>

</div>

<br />

