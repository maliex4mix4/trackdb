<?php

	/* $db2 = [];
	foreach ($db_instance->tables() as $key=>$value ) {
		$data = $db_instance->get($key);
		$db2[$key] = $data;
	}

	$db1 = json_decode(base64_decode($this->content[1]), true);
	$db = array_merge($db1, $db2);
	$this->content[1] = base64_encode(json_encode($db, JSON_PRETTY_PRINT)); */

	$this->merge[] = $db_instance;