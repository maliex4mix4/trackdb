<?php

	if($path) {
		$db = json_decode(base64_decode($this->content[1]), true);
		$target = $db;
		$path = explode('/', $path);
		$replace_collection = false;

		if( end($path) == '*' ) {
			$replace_collection = true;
			array_pop($path);
		}

		foreach ($path as $value) {
			if( $value=='meta' ) {
				die('Error: access denied on column `meta`');
			} else if( isset($target[$value]) ) {
				$target = $target[$value];
			} else {
				die('Error: path not found');
			}
		}

		if( isset($target["meta"]) ) {
			$tmp = [];
			foreach ($target["meta"] as $key => $value) {
				if( !isset($data[$key]) ) {
					# if column type is auto_increment
					if($value==self::DATA_AI) {
						if(sizeof($target)>1){
							$data[$key] = intval(end($target)["id"])+1;
						} else {
							$data[$key] = 1;
						}
					} else {
						die('Column `'.$key.'` undefined');
					}
				}
				$column = explode('/', $value);
				if( strpos($column[0], trackDB::DATA_REF)===0 && !is_string($data[$key]) ) {
					die('Expected `string`, `'.gettype($data[$key]).'` given on column `'.$key.'`');
				} else if( $column[0]==str_replace('/','',self::DATA_STRING) && !is_string($data[$key]) ) {
					die('Expected `string`, `'.gettype($data[$key]).'` given on column `'.$key.'`');
				} else if( $column[0]==str_replace('/','',self::DATA_INT) && !is_numeric($data[$key]) ) {
					die('Expected `numeric`, `'.gettype($data[$key]).'` given on column `'.$key.'`');
				} else if( $column[0]==str_replace('/','',self::DATA_BOOL) && !is_bool($data[$key]) ) {
					die('Expected `boolean`, `'.gettype($data[$key]).'` given on column `'.$key.'`');
				}

				if( isset($column[1]) && intval($column[1]) && sizeof($data[$key])>$column[1] ) {
					die('Index out of bonds for `'.$key.'`=...');
				}
				
				$tmp[$key] = $data[$key];
			}
			$target[base64_encode(microtime())] = $tmp;
		} else if( is_array($target) ) {
			if( $replace_collection ) {
				if( !is_array($data) ) {
					$target = [$data];
				} else {
					$target = $data;
				}
			} else {
				$target = array_merge($target, $data);
			}
		} else {
			$target = $data;
		}

		$n_target  = $db;
		$nn_target = $target;
		foreach( array_reverse($path) as $key => $value ) {
			foreach ($path as $key2 => $value2) {
				if( $value2 == $value ) {
					break;
				}
				$n_target = $n_target[$value2];
			}
			$n_target[$value] = $nn_target;
			$nn_target = $n_target;
			$n_target = $db;
		}
		$this->content[1] = base64_encode(json_encode($nn_target, JSON_PRETTY_PRINT));
		$this->save();
	}