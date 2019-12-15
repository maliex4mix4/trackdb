import os
import json
from functions import *


if not os.path.exists('temp/data'):
	os.makedirs('temp/data')
try:
	open('temp/data/'+filename+'.tbd', 'r')
except Exception as e:
	f = open('temp/data/'+filename+'.tbd', 'w+')
	content = base_64(json.dumps({}))
	password = base_64(password)
	_concat_ = str(password)+'/'+str(content)
	md_pass_cont = md5(_concat_)
	_db_content_ = base_64(str(md_pass_cont)+'/'+str(password)+'/'+str(content))
	f.write(_db_content_)
	f.close()
	return True