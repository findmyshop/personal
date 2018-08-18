#!/bin/bash

echo "List of ResponseIDs defined in index.xml but not ui.xml:"
while read -r RESPONSE_ID
do
	grep -q $RESPONSE_ID ui.xml
	if [ $? -ne 0 ]; then
		echo $RESPONSE_ID
	fi
done < <(grep -E '<ResponseID id=".*">.*</ResponseID>' index.xml | cut -d '>' -f 2 | cut -d '<' -f 1)



