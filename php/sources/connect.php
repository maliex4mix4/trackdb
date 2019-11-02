<?php

	if( file_exists($file) ) {
		$this->credentials[] = $file;
		$this->credentials[] = $password;
		$content = explode( '/', base64_decode(file_get_contents($file)) );
		if(  $content[0]!=md5($content[1].'/'.$content[2]) ) {
			echo 'Warning: this database has been compromised';
		}
		array_shift($content);
		if( $content[0]!=base64_encode($password)  ) {
			die('Error: access denied');
		} else {
			return $content;
		}
	} else {
		die('Error: file does not exist');
	}