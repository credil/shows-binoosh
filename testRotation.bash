#!/bin/bash

target='www/fetchThis.txt'

sudo chown $1:$1 $target 

while(true); do
	for file in www/slides/*; do 
		file=`basename $file`; 
		address="http://localhost/shows-binoosh/slides/$file" ; 
		echo $address; 
		echo $address > $target; 
		sleep 1; 
	done
done

sudo chown www-data:www-data $target
