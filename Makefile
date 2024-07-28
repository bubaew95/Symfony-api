push:
	symfony console d:d:d --force \
	&& symfony console d:d:c \
	&& symfony console d:m:m

test:
	symfony console d:d:d --force --env=test \
	&& symfony console d:d:c --env=test \
	&& symfony console d:m:m --env=test