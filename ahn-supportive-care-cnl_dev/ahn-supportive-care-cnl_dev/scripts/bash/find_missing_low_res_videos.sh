#!/bin/bash

s3cmd ls s3://ahn_suppcare > videos.txt
cat videos.txt | grep 512k.mp4 | awk '{print $4}' | sed 's/^..................//' | sed 's/.........$//' > response_ids.txt

echo "List of ResponseIDs missing 256k videos"
while read -r RESPONSE_ID
do
	cat videos.txt | grep -q `echo $RESPONSE_ID`_256
	if [ $? -ne 0 ]; then
		echo $RESPONSE_ID
	fi
done < response_ids.txt