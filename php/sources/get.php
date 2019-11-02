<?php

	if( $path ) {
		$db = json_decode(base64_decode($this->content[1]), true);
		$target = $db;
		$path = explode('/', $path);

		foreach ($path as $value) {
			if( $value=='meta' ) {
				die('Error: access denied on column `meta`');
			} else if( isset($target[$value]) ) {
				$target = $target[$value];
			} else {
				die('Error: path not found');
			}
		}

		return $target;
	} else {
		die('Error: path not found');
	}