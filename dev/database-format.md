## Proposed Database Format
Database is formatted like an sql database in the sense that all root properties are tables
```
{
	"users": {}, # Table users
	"files": {} # Table files
}
```
each table must a contain a compulsory and uneditable property `meta` describing the table
```
{
	"users": {
		"meta": {
			"id": "TRACKDB_AI", # Column id
			"username": "TRACKDB_STRING\100" # Column username
		}
	}, # Table users
	"files": {
		"meta": {
			"id": "TRACKDB_AI", # Column id
			"user": "TRACKDB_ON" # Column user (referencing users.username),
			"uri": "TRACKDB_STRING\500", # Column uri
		}
	} # Table files
}
```
data are stored into tables with auto generated id
```
{
	"users": {
		"meta": {
			"id": "TRACKDB_AI", # Column id
			"username": "TRACKDB_STRING\100" # Column username
		},
		"MC42NzM0NDUwMCAxNTcxNzc1Nzk5": {
			"id": 1,
			"username": "john_doe"
		}
	}
}
```
#### NOTES
_adding data with an extra property not specified in the meta throws error_<br/>
_tables cannot be pushed, they can only be created_

### Data Types
- Numbers `100`, `23.45`, `24E10`
- String `The quick brown fox jumps over the lazy dog`
- Boolean `true`, `false`
- Primitive collections, array `['D', 0, 'C', 23.15]`
- References
	- Single: a reference to a single entity `MC42NzM0NDUwMCAxNTcxNzc1Nzk5`
	- Plenty: collection of references `['MC42NzM0NDUwMCAxNTcxNzc1Nzk5', 'MC42NzM0NDFghjsAxNTcxNzc1NIsL7']`

### Data Extra
- Auto Increment
- Unique
- Time
- Timestamp