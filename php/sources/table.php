<?php
	
	if( is_string($table_name) ) {
		$db = json_decode(base64_decode($this->content[1]), true);
		if( !isset($db[$table_name]) || $force===self::FORCE ) {
			$db[$table_name] = array();
			$db[$table_name]["meta"] = $define;
			$this->content[1] = base64_encode(json_encode($db, JSON_PRETTY_PRINT));
		} else {
			return false;
		}
	} else {
		die('Error: expected type STRING, '.strtoupper(gettype($table_name)).' given trackDB::table');
	}
	
	$this->save();