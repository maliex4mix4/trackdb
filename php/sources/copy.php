<?php

	if( $from_path && $to_path ) {
		$this->push($to_path, $this->get($from_path)->show());
	}