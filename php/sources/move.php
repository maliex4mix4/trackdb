<?php

	if( $from_path && $to_path ) {
		$get = $this->get($from_path)->show();
		if( $this->delete($from_path)!==false ){
			$this->push($to_path, $get);
		}
	}