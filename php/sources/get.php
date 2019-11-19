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

		$ref_columns = [];
		if( isset($target["meta"]) ) {
			foreach ($target["meta"] as $name=>$column) {
				if( strpos($column, trackDB::DATA_REF)===0 ) {
					$column = explode('_ON_', $column);
					$ref_columns[$name] = $column;
				}
			}
			unset($target["meta"]);
		}
		foreach ($target as $key=>$value) {
			foreach ($ref_columns as $refi=>$ref) {
				$target[$key][$refi] = $this->get($ref[1])->keys([$value[$refi]])->show()[$value[$refi]];
				$target[$key][$refi]['->'] = $value[$refi];
			}
		}
		return $target;
	} else {
		die('Error: path not found');
	}