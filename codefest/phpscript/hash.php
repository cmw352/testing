<?php 

function generate_salt($len)
{
	$seed = str_split(	'abcdefghijklmnopqrstuvwxyz'
						.'ABCDEFGHIJKLMNOPQRSTUVWXYZ'
						.'0123456789');
	$output = '';
	for($x = 0; $x < $len; $x++)
	{
		shuffle($seed);
		$output .= $seed[0];
	}
	
	return $output;
}

function hashpass($pass, $salt)
{
	return SHA1($pass . $salt);
}


function make_sql_safe($item)
{
	$item = str_replace("\\","\\\\",$item);
	$item = str_replace("\"","\\\"",$item);
	$item = str_replace("'","\\'",$item);
	return $item;
}

?>