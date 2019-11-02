## Trackdb
##### store, retrieve & convert data with speed and flexiblity.
### Probable APIs
```
new trackdb()
	->close(); ## close a database connection
	->connect( db_path, password ); ## connect to a database
	->convert( db_type ); ## convert database to another format
	->crack(); ## crack the database for password
	->create( db_path, password ); ## create a database
	->delete( data_path ); ## delete data from database
		->filter( filter ); ## create a filter
	->errors(); ## list all errors
	->fix(); ## repair database
	->get( data_path ); ## retrieve data from database
		->filter( filter ); ## create a filter
	->merge( db_instance ); ## merge databases and query as one
	->push( data_path, data ); ## add or update data in the database
	->query( sql_query ); ## query the database in sql syntax
	->tables(); ## get all tables: all base collection
		->filter( filter ); ## create a filter
		->meta(); ## get table information
	->raw(); ## get the raw data from database
	->set( config ); ## configure the database
```
### Probable Constants
```
trackdb
	::XML_DATA
	::SQL_DATA
	::ARRAY
	::DEV_MODE
	::PROD_MODE
	::REPORTING
	::ERRORS ## all possible errors
```