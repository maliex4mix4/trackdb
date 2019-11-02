## Trackdb
##### store, retrieve & convert data with speed and flexiblity.
### Probable APIs
```
new trackdb()
	V->close(); ## close a database connection
	V->connect( db_path, password ); ## connect to a database
	->convert( db_type ); ## convert database to another format
	->crack(); ## crack the database for password
	V->create( db_path, password ); ## create a database
	V->delete( data_path ); ## delete data from database
	V->errors(); ## list all errors
	->fix(); ## repair database
	V->get( data_path ); ## retrieve data from database
		->filter( filter ); ## create a filter
	V->merge( db_instance ); ## merge databases and query as one
	V->push( data_path, data ); ## add or update data in the database
	->query( sql_query ); ## query the database in sql syntax
	V->tables(); ## get all tables: all base collection
		->filter( filter ); ## create a filter
	V->raw(); ## get the raw data from database
	V->set( config ); ## configure the database
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