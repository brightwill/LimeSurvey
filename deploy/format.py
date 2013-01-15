import os

BASE_PATH = "../../limesurvey"

def read_file(path):
	f = open(path, 'r')
	content = f.read()
	f.close()
	return content

def write_file(path, content):
	f = open(path, 'w')
	f.write(content)
	f.close()

def format_content(content):
	pass

def format_file(path):
	content = read_file(path)
	print 'formating', path
	content = format_content(content)
	write_file(path, content)

def format_all():
	for root, dirs, files in os.walk(BASE_PATH):
		for name in files:
			if name.endswith('.php'):
				format_file(os.path.join(root, name))

if __name__ == '__main__':
	format_all()
