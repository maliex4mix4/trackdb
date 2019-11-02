<?php

	class trackDB {
		// DATA
		const DATA_AI = 'TRACKDB_AUTO_INCREMENT';
		const DATA_ARRAY = 'TRACKDB_ARRAY/';
		const DATA_BOOL = 'TRACKDB_BOOL';
		const DATA_STRING = 'TRACKDB_STRING/';

		// EXTRA
		const FORCE = true;

		// COMMANDS
		const CHANGE_PASSWORD = '2345';

		private $content = [];
		private $credentials = [];
		private $errors = [];

		function __construct( $file='', $password='' ) {
			if( $file && $password ) {
				$this->connect(dirname(__FILE__).'/.tdb.'.$file, $password);
			}
		}
		public function close(){
			include('sources/close.php');
		}
		private function connect( $file, $password ) {
			$this->content = include('sources/connect.php');
		}
		public function crack() {
			include('sources/');
		}
		public function create( $file, $password ) {
			$file = dirname(__FILE__).'/.tdb.'.$file;
			return include('sources/create.php');
		}
		public function delete( $path ) {
			include('sources/delete.php');
		}
		public function errors() {
			return $this->errors;
		}
		public function get( $path ) {
			return include('sources/get.php');
		}
		public function merge( $db_instance ) {
			include('sources/merge.php');
		}
		public function push( $path, $data ) {
			include('sources/push.php');
		}
		public function raw() {
			include('sources/raw.php');
		}
		private function save() {
			include('sources/save.php');
		}
		public function set( $cmd, ...$args ){
			include('sources/set.php');
		}
		public function table( $table_name, $define, $force=false ) {
			include('sources/table.php');
		}
		public function tables() {
			return include('sources/tables.php');
		}

		private class Data {
			$data = ;
			
			function __construct( $data ) {
				$this->data = $data;
			}
			function filter( $filter ) {

			}
		}
	}

	(new trackDB())->create('site', '12345678');
	$tdb = new trackDB('site', '87654321');
	$tdb->merge( new trackDB('brandIn', '12345678') );

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
	# $tdb->delete('admins/MC4zNjczNDIwMCAxNTcxNzc2Mzk2/permissions');
	# $tdb->set(trackDB::CHANGE_PASSWORD, "12345678", "87654321");
	
	$tdb->tables();
	$tdb->raw();
	$tdb->close();