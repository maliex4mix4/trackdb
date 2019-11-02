<?php

	require_once('trackdb.php');

	(new trackDB())->create('brandIn', '12345678');
	$tdb = new trackDB('brandIn', '12345678');

	$tdb->table("files", array(
		"id" => trackDB::DATA_AI,
		"user" => trackDB::DATA_STRING.'100',
		"uri" => trackDB::DATA_STRING.'200'
	));