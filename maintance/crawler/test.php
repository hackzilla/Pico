<?

	include_once('../../crawler2/functions.php');
	include_once('../../crawler2/al.php');

	$page = "<html xmlns=\"http://www.w3.org/1999/xhtml\" xml:lang=\"en\" lang=\"en\">
<head>
		<title>SexeOasis, un oasis de sexe</title>
<meta name=\"description\" content=\"L'oasis du sexe gratuit\">
<meta name=\"keywords\" content=\"modeles, modèles, amatrice, jeunes, filles, teen, young, cul, gratuit, fesses, cul, pipi, france, jeune, girl, hard, video, x, xxx, chat, direct, sm, fellation, pipe, pipe profonde, dilatation anal, défonce anale, cuir, sexe gratuit, fessée, jeune fille au pair, femmes matures, vieilles, nudistes, filles à la plage, lesbiennes, diapers, god ceinture \">
                <meta name=\"Language\" content=\"fr\">
                <meta name=\"Identifier-URL\" content=\"http://www.sexeoasis.com\">
                <meta name='Revisit-after' content='7 days'>
                <meta name=\"Author\" content=\"sexeoasis\">
                <meta name=\"Copyright\" content=\"sexeoasis.com\">
<meta http-equiv=\"Content-Language\" content=\"it\">
<META NAME=\"LANGUAGE\" CONTENT=\"Italian it\">
<meta http-equiv=\"Content-Language\" content=\"it\">

<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">


 <SCRIPT LANGUAGE=Javascript>
function connexion_bol()
{
//window.open('http://www.xponsor.com/bol/dl.cgi?sexeoasis','','width=320,height=195');
}
</SCRIPT>
<SCRIPT Language=Javascript src=\"http://www.xponsor.com/autoinstall.js\">
</SCRIPT>

<SCRIPT SRC=\"http://www.xparade.com/popup.php?id=fredser&source=sexeoasis\"></SCRIPT>
</head>";


	$page = strtolower($page);
	preg_match('/<html[^>](.*)>/i', $page, $bits);

	$htmlArgs = getProperties( $bits[1] );

	list( $lang, $dialect ) = checkForRegionAbbr( $htmlArgs['lang'] );

	echo "( $lang, $dialect )\n";

	//$bits = get_meta_data( );

	//list( $lang, $dialect) = checkMetaLang( $bits );

	//print "$lang, $dialect <br>\n";
	print_r( $bits );


	/*
	preg_match_all("/(<meta[^>]*>)/", $page, $metaTags, PREG_SET_ORDER);

	foreach( $metaTags as $match ) {

		$bits = get_meta_data( $match[0] );
		print_r( $bits );

	}
	*/

	print_r( parse_url( '/www/aslash' ));
	print_r( parse_url( 'http://domain.com' ));
	print_r( parse_url( 'http://www.domain.com?d=h' ));
	print_r( parse_url( 'http://www.domain.com:9001?id=1' ));


?>