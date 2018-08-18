#!/bin/bash
# Cleans and formats XML files by doing the following:
# 1. Removes leading and trailing whitespace from attribute and element values
# 2. Removes non-printable characters
# 3. Properly indents XML
#
# Argument - Fully qualified file name of the target XML file

FILE="$1"

if [ ! -f "$FILE" ]; then
	echo "Error : File not found!"
	exit 1
fi

TEMP=$(mktemp "${FILE}.tmp")

cat $FILE | tr -dc '[:print:]' |  tr -d '†' | tidy -iq -xml -utf8 -wrap 0 >| $TEMP

cp $TEMP $FILE
rm $TEMP
exit 0

