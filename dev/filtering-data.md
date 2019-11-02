## Data Filtering
Data can be filtered where necessary, the filter class takes an array as argument in the form
```
{
	"where": {
		"w": {
			"id": 3,
			"&class": [3, 4],
		},
		"&w": {
			"id": 4,
			"&class": [5, 6],
		}
	},
	"limit": [
		[0, 2],
		[45, 2]
	],
	"order": {
		"by": [ "time", "id" ],
		"order": trackDB::O_DESC
	}
}
```
#### Understanding the `where` property
The where property is used to condition your data, is consists of rules for example:
```
"where": {
	"id": 3,
	"class": 4,
	"&status": 1
}
```
by default, the rules are concatenated with or which can be changed by adding & to the column name thus, the above is interpreted as `where id=3 or class=4 and status=1`. Some case may arise where you have to use multiple rules somewhat like `where (id=3 and class=10) or (id=4 and class=15)` that's where the `w` property comes in like:
```
"where": {
	"w": {
		"id": 3,
		"&class": 10
	},
	"w": {
		"id": 4,
		"&class": 15,
	}
}
```
or sometimes more simpler than this `where (id=3 or id=4) and (class=10 or class=15)` interpreting:
```
"where": {
	"id": [3, 4],
	"&class": [10, 15]
}
```
where also supports regular expression for strings by starting the column value with asterik(`*`):
```
"where": {
	"title": "*\w+d" # Regular expressions supported
}
```

#### Understanding the `limit` property
The limit property is used to control the amount of results returned. This implies let's say you have a result of 100 rows after filtering and you want just the first 20, the last 50 or even rows from 20-50, that's `limit`. The limit property takes as many limits as possible example:
```
limit: [
	20, # Limit 1
	[10, 5] # Limit 2
]
```
each limit can be either an array or integer. While the integer denotes just one row, the array defines multiple rows. From the above limit it means: `select the 20th row from our result then start from 10 then select the next 5 rows`

#### Ordering Constants
```
trackDB
	::O_DESC
	::O_ASC
	::O_RAND
```