<?php

	if( !defined('TdbErrors') ){
		define('TdbErrors', array(
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> '',
			"0x0000"=> array(
				'type'=>'',
				'code'=>'',
				'message'=>'',
				'exit'=>false,
			),
		));
	}

	if( !class_exists('TdbError') ) {
		class TdbError extends Exception {

			function __construct( $index ) {
				$this->message = TdbErrors[$index]['message'];
				$this->code = $index;

				if( TdbErrors[$index]['exit'] ) {
					echo $this->message;
					exit(1);
				}
			}

		}
	}