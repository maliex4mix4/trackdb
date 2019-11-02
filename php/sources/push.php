<?php

	if($path) {
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

		if( isset($target["meta"]) ) {
			foreach ($target["meta"] as $key => $value) {
				if( !isset($data[$key]) ) {
					# if column type is auto_increment
					if($value==self::DATA_AI) {
						if(sizeof($target)>1){
							$data[$key] = intval(end($target)["id"])+1;
						} else {
							$data[$key] = 1;
						}
					}
				}
			}
			$target[base64_encode(microtime())] = $data;;
		} else if( gettype($target)=='array' ) {
			$target[] = $data;
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