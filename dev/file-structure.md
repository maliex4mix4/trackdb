## Proposed File Structure for TrackDB
The file name would be in the format `.tdb.%DB_NAME%`. Reasons include; prevent access through URL. There can be more that one databases in a project which can be merged together and queried as one database. In this case, its advisable to create a folder named `.trackdb` and add all your db files to this folder.

```
%PROJECT-ROOT% /
	-  .trackdb /
		-  .tdb.Users # Database
		-  .tdb.Categories # Database
```

##### NOTE: _database names should be camel cased with only alphabets_ examples;
```
Users - YES
adminUsers - YES

users0 - NO
admin_users - NO
```

### File Format
The database file contains a base64_encoded text as the root content
```
NjcyYWVlNzlmZWU5MjIzOGQ0YzczNWU4YWE1YWUzNzYvTURBd01EQXcvVzEwPQ==
```
which decoding it becomes
```
672aee79fee92238d4c735e8aa5ae376/MDAwMDAw/W10=
```
splitting at the slashes
```
672aee79fee92238d4c735e8aa5ae376/
MDAwMDAw/
W10=
```
the first part `672aee79fee92238d4c735e8aa5ae376` is the md5 hash of the rest - `MDAwMDAw/W10=`, this is used as an integrity check to determine data breaching.

The second part is the password encoded in base64, `MDAwMDAw` equivalent to `000000` in normal text.

The third part is the real json data encoded in base64, `W10=` equivalent to `{}` (an empty json database) in normal text.