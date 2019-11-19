<?php
	
	if( !class_exists('TdbFilter') ) {
		class TdbFilter {
			private $data = [];
			
			function __construct( $data ) {
				$this->data = $data;
			}

			public function exkeys( $array_keys ) {
				foreach ($array_keys as $key) {
					unset($this->data[$key]);
				}

				return new TdbFilter($this->data);
			}

			public function keys( $array_keys ) {
				$data = [];
				foreach ($array_keys as $key) {
					$data[$key] = $this->data[$key];
				}

				return new TdbFilter($data);
			}

			public function where( $equals_array ) {
				if( empty($equals_array) ) {
					return new TdbFilter($this->data);					
				}

				foreach ($this->data as $ikey=>$value) {

					$remove = true;
					foreach ($equals_array as $key=>$equals) {
						if( !isset($value[$key]) ) {
							die("Error: `$key` does not exist");
						}

						if( !is_array($equals) ) {
							$equals = [$equals];
						}

						if( is_array($value[$key]) ) {
							foreach ($equals as $equals_each) {
								if( in_array($equals_each, $value[$key]) ) {
									$remove = false;
									break 2;
								}
							}
						} else {
							if( in_array($value[$key], $equals) ) {
								$remove = false;
								break;
							}
						}
					}

					if($remove) {
						unset($this->data[$ikey]);
					}
				}

				return new TdbFilter($this->data);
			}

			public function order( ...$order ) {
				if( isset($order) && is_array($order) && sizeof($this->data)>1 ) {

					if( !(isset($order[1]) && isset($order[0])) ) {
						die('Invalid order parameter');
					}
					$order_by = $order[0];
					$order = $order[1];

					if( is_string($order_by) ) {
						$order_by = [$order_by];
					} else if( !is_array($order_by) ) {
						die('Invalid order:by parameter');
					}

					foreach ($order_by as $by) {
						$temp = array_slice($this->data, 0, 1);
						if( !isset(end($temp)[$by]) ) {
							die("Invalid order:by parameter: column `$by` does not exist:");
						} else if( !is_string($by) ) {
							die("Invalid order:by parameter: column `$by` must be a typeof string");
						}

						for ($x=0;$x<sizeof($this->data);$x++) {
							for ($i=0;$i<sizeof($this->data)-1;$i++) {
								$c = [
									$this->atIndex($this->data, $i)[$by], # current
									$this->atIndex($this->data, $i+1)[$by], # next
								];

								if($order==trackDB::O_DESC) {
									if( $c[1] > $c[0] ) {
										$c[0] = array_slice($this->data, $i+1, 1);
										$c[1] = array_slice($this->data, $i, 1);

										$c = array_merge($c[0], $c[1]);
										$this->data = $this->insertAtIndex($this->data, $i, $c);
									}
								} else if($order==trackDB::O_RAND) {
									$ind = [$i, $i+1]; shuffle($ind);
									$c[0] = array_slice($this->data, $ind[0], 1);
									$c[1] = array_slice($this->data, $ind[1], 1);

									$c = array_merge($c[0], $c[1]);
									$this->data = $this->insertAtIndex($this->data, $i, $c);
								} else {
									if( $c[1] < $c[0] ) {
										$c[0] = array_slice($this->data, $i+1, 1);
										$c[1] = array_slice($this->data, $i, 1);

										$c = array_merge($c[0], $c[1]);
										$this->data = $this->insertAtIndex($this->data, $i, $c);
									}
								}
							}
						}
					}
				}

				return new TdbFilter($this->data);
			}

			public function show( ...$limits ) {
				$filtered = [];

				if( isset($limits) && is_array($limits) && !empty($limits) ) {
					foreach ($limits as $limit) {
						if( is_array($limit) && sizeof($limit)>1 ) {
							$filtered = array_merge( $filtered, array_slice($this->data, $limit[0], $limit[1]) );
						} else if( is_int($limit) ) {
							$filtered = array_merge( $filtered, array_slice($this->data, $limit, 1) );
						} else {
							die('Invalid Limit parameter');
						}
					}
				} else {
					return $this->data;
				}

				return $filtered;
			}

			function atIndex( $array, $index ) {
				$temp = array_slice($array, $index, 1);
				return end($temp);
			}

			function insertAtIndex( $array, $index, $insertion ) {
				$head = array_slice($array, 0, $index);
				$tail = array_slice($array, $index+sizeof($insertion));
				$end = $head+$insertion+$tail;
				return $end;
			}
		}
	}