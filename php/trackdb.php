<?php

	class trackDB {
		const DATA_AI = 'TRACKDB_AUTO_INCREMENT';
		const DATA_ARRAY = 'TRACKDB_ARRAY/';
		const DATA_BOOL = 'TRACKDB_BOOL';
		const DATA_STRING = 'TRACKDB_STRING/';
		const FORCE = true;

		private $content = '';
		private $credentials = [];

		function __construct( $file='', $password='' ) {
			if( $file && $password ) {
				$this->connect(dirname(__FILE__).'/.tdb.'.$file, $password);
			}
		}
		public function close(){
			unset($this->content);
			unset($this);
		}
		private function connect( $file, $password ) {
			$this->content = include('sources/connect.php');
		}
		public function create( $file, $password ) {
			$file = dirname(__FILE__).'/.tdb.'.$file;
			return include('sources/create.php');
		}
		public function dump() {
			echo "<pre>".base64_decode($this->content[1])."</pre>";
		}
		public function push( $path, $data ) {
			include('sources/push.php');
		}
		private function save() {
			$tmp = implode( '/', $this->content );
			file_put_contents($this->credentials[0], base64_encode(md5($tmp).'/'.$tmp));
		}
		public function table( $table_name, $define, $force=false ) {
			include('sources/table.php');
			$this->save();
		}
		public function get( $path ) {
			return include('sources/get.php');
		}
	}

	(new trackDB())->create('site', '12345678');
	$tdb = new trackDB('site', '12345678');

	$tdb->table("users", array(
		"id" => trackDB::DATA_AI,
		"username" => trackDB::DATA_STRING.'100'
	));
	$tdb->table("admins", array(
		"id" => trackDB::DATA_AI,
		"username" => trackDB::DATA_STRING.'100',
		"permissions" => trackDB::DATA_ARRAY.'10'
	));
	
	# $tdb->push( 'users', array( "username"=>'Maliex' ) );
	# $tdb->push( 'users/MC44MzM1NTEwMCAxNTcxNzc1ODIz/id', 2 );
	/* $tdb->push( 'admins', array(
		"username" => "JBells",
		"permissions" => ['I', 'P']
	)); */
	# $tdb->push( 'admins/MC4zNjczNDIwMCAxNTcxNzc2Mzk2/permissions', array('E', 'X', 'E') );
	# print_r( $tdb->get( 'admins' ) );
	
	$tdb->dump();
	$tdb->close();