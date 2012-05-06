<?

$sql = "SELECT DISTINCT `metadata`.lang, `languages`.`nameEng` FROM `domain`
LEFT JOIN `metadata` ON `metadata`.`domainId` = `domain`.`id`
LEFT JOIN `languages` ON `metadata`.`lang` = `languages`.`cc`
WHERE `lang` != '' AND `languages`.`nameEng` is not null
GROUP BY `lang`
ORDER BY `nameEng` ASC
";

$res = mysql_query( $sql ) or error_sql( $sql, mysql_error() );

if( $res ) {

	$match = '';

	if( isset( $_REQUEST['cc'] )) {
		$cc = $_REQUEST['cc'];

		$len = strlen( $cc );

		if( $len == 2 || $len == 0 ) {
			$match = $cc;
		}

	} else {
		$cc = '';
	}

	$select = '<select name="cc" id="cc">'."\n";

	if( $match == $cc ) {
		$selected = ' selected="selected"';
	} else {
		$selected = '';
	}

	$select .= '	<option value=""' . $selected . '>Unfiltered</option>'."\n";

	while( list( $cc, $nameEng ) = mysql_fetch_row( $res )) {

		if( $match == $cc ) {
			$selected = ' selected="selected"';
		} else {
			$selected = '';
		}

		$select .= '	<option value="' . $cc . '"' . $selected . '>'. $nameEng .'</option>'."\n";

	}

	$select .= '</select>'."\n";

	mysql_free_result( $res );

} else {
	$select = '';
}

?><div id="main">
<form action="/pico/" method="get">
<input type="text" size="25" name="q" value="<? echo $query; ?>" />
<? echo $select ?><input type="submit" value="Search" />
</form>
</div>
<br />
<?
/*
<script type="text/javascript"><!--
google_ad_client = "pub-0109556305060333";
google_alternate_color = "ffffFF";
google_ad_width = 728;
google_ad_height = 90;
google_ad_format = "728x90_as";
google_ad_type = "text_image";
//2007-05-04: pico
google_ad_channel = "8381966071";
google_color_border = "FFFFFF";
google_color_bg = "FFFFFF";
google_color_link = "0000FF";
google_color_text = "000000";
google_color_url = "008000";
//-->
</script>
<script type="text/javascript"
  src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
*/
?>
