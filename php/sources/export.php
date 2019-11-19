<?php

	$db = json_decode(base64_decode($this->content[1]), true);
	$dir = str_replace( '.tdb.', '', $this->credentials[0] );

	if( $endpoint==trackDB::C_XML ){
		
		function array_to_xml($array, &$xml) {
		    foreach($array as $key => $value) {
		    	if( $key==="meta" ) {
		    		$subnode = $xml->addChild("row");
		    		foreach ($value as $name => $type) {
		    			$subnode->addChild("column", $name)->addAttribute("type", $type);
		    		}
		    	} else if(is_array($value)) {
		            if ( !is_numeric($key) ) {
		                $subnode = $xml->addChild("$key");
		                array_to_xml($value, $subnode);
		            } else {
		                $subnode = $xml->addChild("item$key");
		                array_to_xml($value, $subnode);
		            }
		        } else if( is_numeric($key) ){
		        	$xml->addChild("item$key",htmlspecialchars("$value"));
		        } else {
		            $xml->addChild("$key",htmlspecialchars("$value"));
		        }
		    }
		}

		$xml = new SimpleXMLElement("<?xml version=\"1.0\"?><trackdb></trackdb>");
		array_to_xml($db,$xml);

		$dom = new DOMDocument;
		$dom->preserveWhiteSpace = FALSE;
		$dom->loadXML( $xml->asXML() );
		$dom->formatOutput = TRUE;
		
		(new SimpleXMLElement($dom->saveXML()))->asXML("$dir.xml");
		return True;

	} else if( $endpoint==trackDB::C_CSV ) {

		$dir .= '.csv';
		if( !is_dir($dir) ) {
			mkdir( $dir );
		}

		foreach ($db as $name => $table) {
			$array = $table;
			$tmp = ["AGID"]; $collections = [];

			foreach ($array["meta"] as $key => $value) {
				if( strpos($value, trackDB::DATA_ARRAY)===0 ) {
					$collections[] = $key;
				}
				$tmp[] = $key;
			}
			$array["meta"] = $tmp;

			$output = fopen("$dir/$name.csv", 'w');
			foreach ($array as $agid=>$value) {
				foreach( $collections as $collection ) {
					if( isset($value[$collection]) ) {
						$value[$collection] = implode(';', $value[$collection]);
					}
				}
				if( $agid != 'meta' ) {
					array_unshift($value, $agid);
				}

				fputcsv($output, $value);
			}
			fclose($output);
		}

		return True;

	} else if( $endpoint==trackDB::C_SQL ) {

		$tmp_row = [];
		$sql = '
-- TrackDB SQL Dump
-- version 1.0.01
-- https://github.com/maliex4mix4/trackdb
--
-- Generation Time: '.date('F d, Y \a\t H:i A').'
-- PHP Version: '.phpversion().'
--
--
-- Database: `'.$this->credentials[0].'`
--';
		foreach ($db as $name => $table) {
			$sql .= '

-- ----------------------------------------------------

--
-- Table: `'.$name.'`';
			foreach ($table as $agid => $row) {
				if( $agid == 'meta' ) {
					$tmp_row = array_flip($row);
					$sql .= '
-- 		Table Structure:
--

CREATE TABLE `'.$name.'` ('.table_query($row).'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ';
					if( sizeof($table)>1 ) {
						$sql .= ';

--
-- 		Table Data:
--

INSERT INTO `'.$name.'` (`'.implode('`, `', $tmp_row).'`) VALUES';
					}

				} else {
					$sql .= '
'.insert_query($row, $tmp_row);
				}
			}

			$sql = substr($sql, 0, strlen($sql)-1).';';
		}

		file_put_contents($dir.'.sql', $sql);

	}

	function table_query( $array ) {
		$statement = '';
		$map = array(
			trackDB::DATA_AI.'/'=>'INT UNSIGNED',
			trackDB::DATA_INT=>'INT(`l)',
			trackDB::DATA_ARRAY=>'TEXT',
			trackDB::DATA_STRING=>'VARCHAR(`l)',
			trackDB::DATA_BOOL.'/'=>'BOOLEAN',
		);

		foreach ($array as $key => $value) {
			$data_type = explode('/', $value);
			$data_type[0] = $map[$data_type[0].'/'];

			if( isset($data_type[1]) ) {
				$data_type = str_replace('`l', $data_type[1], $data_type[0]);
			} else {
				$data_type = $data_type[0];
			}

			$statement.='
	`'.$key.'` '.$data_type.' NOT NULL,';
		}

		return substr($statement, 0, strlen($statement)-1);
	}

	function insert_query( $array, $order ) {
		$statement = [];
		foreach ($order as $value) {
			if( isset($array[$value]) ) {
				if( is_array($array[$value]) ) {
					$statement[] = '\''.implode($array[$value], ';').'\'';
				} else if( !is_numeric($array[$value]) ) {
					$statement[] = '\''.$array[$value].'\'';
				} else {
					$statement[] = $array[$value];
				}
			} else {
				$statement[] = '';
			}
		}
		return '('.implode($statement, ', ').'),';
	}