<?php

	$db = json_decode(base64_decode($this->content[1]), true);
	$tables = [];

	foreach ( $db as $key => $value) {
		$tables[$key] = $value["meta"];
	}

	return $tables;