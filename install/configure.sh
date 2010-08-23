#!/bin/bash

vim ../conf/site.php
vim ../conf/sql.php


RETURN=1
while [ "x$RETURN" != "x0" ]; do
	php conf-test.php
	RETURN="$?"
	if [ "x$RETURN" == "x11" ]; then
                echo "The normal conf-file is not set up right. Please double check. Hit enter."
                read foo
		vim ../conf/site.php
	fi
        if [ "x$RETURN" == "x12" ]; then
		echo "SQL is not set up right. Please double check. Hit enter to get down."
		read foo
                vim ../conf/sql.php
        fi
done

