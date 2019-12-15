import os
import json
from functions import *

if not os.path.exists('temp/data/'+filename+'.tbd'):
	return 'file doesnt exists'
try:
	f = open('temp/data/'+filename+'.tbd', 'r')
	content = str(f.readlines())
	_final = base_64_decode(content)
	confirm = _final[:_final.index('/')]
	remains = _final[_final.index('/')+1:]
	_password_ = remains[: remains.index('/')]
	_block_content = remains[remains.index('/')+1 :]
	_concat_ = str(md5(_password_+'/'+_block_content))
	if confirm == _concat_:
		if base_64(password) == _password_:
			return base_64_decode(_block_content)
		else:
			return False, 'Incorrect password'
	else:
		return False, 'Unkown error'
except Exception as e:
	raise e