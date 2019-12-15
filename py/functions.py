import hashlib
import base64

def md5(victim):
	word = hashlib.md5(victim.encode())
	return word.hexdigest()

def base_64(victim):
	word = base64.b64encode(victim.encode())
	return str(word.decode("utf-8"))

def base_64_decode(victim):
	word = base64.b64decode(victim)
	return str(word.decode("utf-8"))