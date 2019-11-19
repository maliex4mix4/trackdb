<?php

	final class trackDB {
		// DATA
		const DATA_AI = 'TRACKDB_AUTO_INCREMENT';
		const DATA_ARRAY = 'TRACKDB_ARRAY/';
		const DATA_BOOL = 'TRACKDB_BOOL';
		const DATA_STRING = 'TRACKDB_STRING/';
		const DATA_INT = 'TRACKDB_INTEGER/';
		const DATA_REF = 'TRACKDB_REFERENCE_ON_';

		// EXTRA
		const FORCE = true;

		// COMMANDS
		const CHANGE_PASSWORD = '2345';

		// FILTER
		const O_DESC = '12378';
		const O_ASC = '12326';
		const O_RAND = '90034';

		// CONVERSION
		const C_XML = '600934';
		const C_SQL = '600935';
		const C_CSV = '600936';

		private $content = [];
		private $credentials = [];
		private $errors = [];

		function __construct( $file='', $password='' ) {
			include('sources/filter.php');
			include('sources/error.php');

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
		public function copy( $from_path, $to_path ) {
			return include('sources/copy.php');
		}
		public function crack() {
			return include('sources/crack.php');
		}
		public function create( $file, $password ) {
			$file = dirname(__FILE__).'/.tdb.'.$file;
			return include('sources/create.php');
		}
		public function delete( $path ) {
			include('sources/delete.php');
		}
		private function error( $index ) {
			$this->errors[] = new TdbError( $index );
		}
		public function errors() {
			return $this->errors;
		}
		public function export( $endpoint ) {
			return include('sources/export.php');
		}
		public function get( $path ) {
			return $this->data( include('sources/get.php') );
		}
		public function import( $path, $type ) {
			include('sources/import.php');
		}
		public function merge( $db_instance ) {
			include('sources/merge.php');
		}
		public function move( $from_path, $to_path ) {
			return include('sources/move.php');
		}
		public function push( $path, $data ) {
			include('sources/push.php');
		}
		public function rename( $from_path, $to_path ) {
			include('sources/rename.php');
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
			return $this->data( include('sources/tables.php') );
		}

		private function data( $data ) {
			if( class_exists('TdbFilter') ) {
				return new TdbFilter( $data );
			} else {
				return $data;
			}
		}
	}

	(new trackDB())->create('site', '12345678');
	$tdb = new trackDB('site', '87654321');
	# $tdb->merge( new trackDB('brandIn', '12345678') );

	# $tdb->table("users", array(
	#	"id" => trackDB::DATA_AI,
	#	"username" => trackDB::DATA_STRING.'100'
	# ));
	# $tdb->table("admins", array(
	#	"id" => trackDB::DATA_AI,
	#	"username" => trackDB::DATA_STRING.'100',
	#	"permissions" => trackDB::DATA_ARRAY.'10'
	# ));
	# $tdb->table('files', array(
	#	"id" => trackDB::DATA_AI,
    #    "user" => trackDB::DATA_REF."users",
    #    "uri" => trackDB::DATA_STRING."100",
	# ), trackDB::FORCE);
	
	# $names = ['james', 'john', 'peter', 'luku', 'sulaimon', 'abdulbasit', 'quareeb', 'barakat', 'shile', 'sewa'];
	# for($x=0; $x<10; $x++) {
	#	$tdb->push( 'users', array( "username"=>$names[$x] ) );
	# }
	# $tdb->push( 'users/MC44MzM1NTEwMCAxNTcxNzc1ODIz/id', 2 );
	# $tdb->push( 'files', array(
	#	'user' => 'MC42NzY0MTYwMCAxNTczNDkzNjgy',
	#	'uri' => 'http://kora.com.ng'
	# ));
	# $tdb->push( 'admins', array(
	#	"username" => "JBells",
	#	"permissions" => explode('.', 'A.B.D.C.E.F.G.H')
	# ));
	# $tdb->push( 'admins/MC43Mjg5MzcwMCAxNTczMzE3Mjk3/permissions', ['E', 'X', 'E'] );
	# print_r( $tdb->get( 'admins' ) );
	# $tdb->delete('users/MC4zMjkxNjEwMCAxNTczNDkzNjUx');
	# $tdb->set(trackDB::CHANGE_PASSWORD, "12345678", "87654321");

	# echo '<pre>'; print_r($tdb->get('users')->filter([
	#	'limit'=>[
	#		[0, 5],
	#	],
	#	'order'=>[
	#		'by'=>['username'],
	#		'order'=>trackDB::O_DESC
	#	]
	# ])); echo '</pre>';
	# echo '<pre>'; print_r(
	#	$tdb->get('admins')
			# ->where([
			#	'permissions'=>'P'
			# ])
			# ->exkeys([
			#	'MC41ODAzMTgwMCAxNTczMzE5MDM4',
			#	'MC41MDQ2ODQwMCAxNTczMzE5MDM4'
			# ])
			# ->where([
			#	'id'=>[12,10,8],
			#	'username'=>['john']
			# ])
	#		->order([
	#			'id'
	#		], trackDB::O_DESC)
	#		->show([0,5], 10)
	# ); echo '</pre>';
	# echo '<pre>'; print_r($tdb->get('files')->show()); echo '</pre>';

	# print_r( 
	#	$tdb->tables()
	#		->where([
	#			'columns'=>['uri']
	#		])
	#		->show()
	# );
	# $tdb->rename('admins', 'admin');
	# $tdb->rename('users/meta/username', 'users/meta/uname');
	# $tdb->move('users/MC41MDQ2ODQwMCAxNTczMzE5MDM4', 'users/MC41MTg5MTIwMCAxNTczMzE5MDM4');
	# $tdb->export(trackDB::C_SQL);
	 $tdb->raw();
	# echo $tdb->crack();
	$tdb->close();