<?php

	$tmp = implode( '/', $this->content );
	file_put_contents($this->credentials[0], base64_encode(md5($tmp).'/'.$tmp));