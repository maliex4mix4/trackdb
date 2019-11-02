<?php

	if($path) {
		$db = json_decode(base64_decode($this->content[1]), true);
		$target = $db;
		$path = explode('/', $path);
		$check = [];

		foreach ($path as $index=>$value) {
			if( $value=='meta' ) {
				die('Error: access denied on column `meta`');
			} else if( isset($target[$value]) ) {
				if ($index == sizeof($path)-1) {
					break;
				} else if($index == sizeof($path)-3) {
					$check = $target[$value];
				}
				$target = $target[$value];
			} else {
				die('Error: path not found');
			}
		}

		if( isset($check["meta"]) ) {
			echo "<br/>Error: trying to delete a column";
			return;
		} else {
			unset($target[end($path)]);
			array_pop($path);
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