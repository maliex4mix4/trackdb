<?php

	$db = json_decode(base64_decode($this->content[1]), true);
	$tables = [];

	foreach ( $db as $key => $value) {
		$tables[$key]['columns'] = array_flip($value["meta"]);
	}

	return $tables;