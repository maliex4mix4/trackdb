<?php

	if( $cmd==self::CHANGE_PASSWORD ) {
		if( sizeof($args)>=2 ) {
			$old = $args[0];
			$new = $args[1];

			if( $this->content[0]==base64_encode($old) ) {
				$this->content[0] = base64_encode($new);
			}
			$this->save();
		}
	}