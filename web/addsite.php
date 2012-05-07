<h1>Add Site</h1>
<?

include_once('config.php');

if ( isset($_POST['domain']) && $_POST['domain']) {
	$code = strtoupper($_POST['confirm']);
	$codemd = $_POST['md5'];
	$codetest = md5($code);

	if ($codetest != $codemd) {

		echo "<p>Sorry you didn't enter the validation code correctly. Please type in the random characters EXACTLY as
	they are displayed in the image. This prevents spammers taking advantage of this feature. Thank you for your
	patience.</p>";

	} else {

		$squirt = "SELECT * FROM `domain` WHERE `domain`='" . $_REQUEST['domain'] . "';";
		$result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );

		if (mysql_num_rows($result)) {
			echo "<p>This domain is already queued for crawling. Please be patient.</p>";
		} else {
			$squirt = "SELECT * FROM domain WHERE domain='" . $_REQUEST['domain'] . "';";
			$result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );

			if (mysql_num_rows($result)) {
				echo "<p>This domain has already been added to the database.</p>";
			} else {

				$domain = $_REQUEST['domain'];
				$domain = str_replace("http://", "", $domain);

				$sock = fsockopen("$domain", 80, $errno, $errstr, 10);

				if ($sock) {

				$squirt = "INSERT INTO `domain` ( `domain`,`status` ) VALUES ('" . $domain . "', 'queue');";
				$result = mysql_query($squirt) or error_sql( $squirt, mysql_error() );

				mysql_close();

				echo "<p>Your site has been successfully added.</p>";
				fclose($sock);

				} else {

				echo "<p>We could not connect to that address. Please specify web sites in the format 'www.domain.com' or 'domain.com'. It may have timed out, I'm afraid the script has little patience.</p>";
				echo "<p>Error Number: " . $errno . "<br>";
				echo "<p>Error: " . $errstr . "</p>";

				}

			}

		}

	}

} else {

	// make up a random string of chars
	$randstr = "";
	srand((double)microtime()*1000000);
	$randchars = Array("A","B","C","D","F","G","H","J","K","M","N","P","Q","R","S","T","W","X","Y","2","3","4","6","7","8","9");
	for ($rand = 0; $rand <= 6; $rand++) {
		$random = rand(0, count($randchars) -1);
		$randstr .= $randchars[$random];
	}
	$randomfile = "confirm/" . $randstr . ".png";

	$randstr = "";
	for ($rand = 0; $rand <= 8; $rand++) {
		$random = rand(0, count($randchars) -1);
		$randstr .= $randchars[$random];

		#randomly add a space to move around the characters.
		if( rand(0,1) ) {
			$randstr .= ' ';
		}
	}

	$randomstring = $randstr;
	
	// save the image
	include("image.php");

	// encrypt answer and store in form
	$encrypted = md5($randomstring);

// display image of random string
?>

<p>Fill in the form below to add your site to the search engine:</p>

<form action="/pico/s/4/" method="post">
<p>Domain: &nbsp;&nbsp;&nbsp;
<input type="text" name="domain"></p>

<p>Below is a code that prevents spammers from submitting rogue sites. Please enter the code carefully - if you can't read it just hit F5 and fill in the form again.</p>
<p align="center"><img src="/<?php echo $randomfile; ?>"></p>
<p>Code: &nbsp;&nbsp;&nbsp;&nbsp;
<input type="text" name="confirm"></p>
<input type="hidden" name="md5" value="<?php echo $encrypted; ?>">

<input type="submit">
</form>

<?

}

?>

</div>
<br />
