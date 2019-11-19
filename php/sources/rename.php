<?php

	$rename_data_columns = function( $column, $data ) {
		$clone = [];
		$column = explode('---', $column);
		if( !isset($data['meta']) ) {
			return $data;
		} else {
			foreach ($data as $key => $value) {
				if( $key!='meta' ) {
					$value[$column[1]] = $value[$column[0]];
					unset($value[$column[0]]);
				}
				$clone[$key] = $value;
			}
		}

		return $clone;
	};

	if( $from_path && $to_path ) {
		$db = json_decode(base64_decode($this->content[1]), true);
		$nn_target = $db;
		$from_path = explode('/', $from_path);
		$to_path = explode('/', $to_path);
		if( sizeof($from_path)!=sizeof($to_path) ) {
			die('Rename path are not the same level');
		}

		foreach ($from_path as $index=>$value) {
			if( $value=='meta' && $to_path[$index] !=='meta' ) {
				die('Cannot rename `meta`');
			} else if( isset($nn_target[$value]) ) {
				$nn_target = $nn_target[$value];
			} else {
				die('Error: path not found');
			}
		}

		$n_target  = $db;
		$to_path = array_reverse($to_path);
		$renamed_column = false;
		foreach( array_reverse($from_path) as $key => $value ) {
			foreach ($from_path as $key2 => $value2) {
				if( $value2 == $value ) {
					break;
				}
				$n_target = $n_target[$value2];
			}
			if( $value!=$to_path[$key] ) {
				if( isset($to_path[$key+1]) && $to_path[$key+1]=='meta' ) {
					$renamed_column = $value.'---'.$to_path[$key];
				}
				unset($n_target[$value]);
				$value = $to_path[$key];
			}
			if( isset($n_target['meta']) && $renamed_column ) {
				$n_target = $rename_data_columns($renamed_column, $n_target);
				$renamed_column = false;
			}
			$n_target[$value] = $nn_target;
			$nn_target = $n_target;
			$n_target = $db;
		}
		$this->content[1] = base64_encode(json_encode($nn_target, JSON_PRETTY_PRINT));
		$this->save();
	}