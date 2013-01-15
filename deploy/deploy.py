import os
import shutil

SRC_PATH = "../../limesurvey"
DST_PATH = "/srv/http/limesurvey"


def deploy():
	if os.path.exists(DST_PATH):
		shutil.rmtree(DST_PATH)
	shutil.copytree(SRC_PATH, DST_PATH)

if __name__ == '__main__':
	deploy()
