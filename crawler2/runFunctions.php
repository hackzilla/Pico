<?

function isPidRunning( $pid )
{

#	global $ps_opt;

	if( $pid )
	{

#		$cmd = "ps ".$ps_opt." -p ". (int)$pid;
		$cmd = "ps -p ". (int)$pid;
		$ps=shell_exec( $cmd );
		$ps=explode("\n", $ps);

		if(count($ps) >= 3)
		{
			return true;
		}

	}

	return false;
}

function pidCheck( $crawlerName, $crawlerVersion )
{
	$pid = getmypid();

	if( $pid !== false ) {

		$pidFile = dirname( __FILE__ ) . '/pid/' . $crawlerName . '-' . $crawlerVersion . '.pid';
		if( file_exists( $pidFile )) {
			$oldPid = file_get_contents( $pidFile );
		} else {
			$oldPid = '';
		}

		if( !isPidRunning( $oldPid ) ) {
			file_put_contents( $pidFile, $pid );

		} else {
			return false;
		}

	} else {
		return false;

	}

	return true;
}


?>