<?php

	if( file_exists( $file ) ) {
		# Change to die at production
		echo('Warning: trying to create database that already exists');
	} elseif ( !preg_match( '/[A-Za-z]+/', $file ) ) {
		die('Error: Invalid database name');
	} else {
		$content = base64_encode($password).'/'.base64_encode(json_encode(array(), JSON_PRETTY_PRINT));
		$content = base64_encode(md5($content).'/'.$content);
		file_put_contents($file, $content);

		return True;
	}