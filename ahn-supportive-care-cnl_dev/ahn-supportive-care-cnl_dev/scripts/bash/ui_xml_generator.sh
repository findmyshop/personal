#!/bin/bash

HELP=':: Usage ::\n./ui_xml_generator.sh [ INPUT_TYPE ] [ OUTPUT_TYPE ] [ RESPONSE_PREFIX|FILE_NAME ] [ NUM_RESPONSES ] [ RESPONSE_WIDTH ] [ CASE_NAME ]\nINPUT_TYPE = [ file | prefix ]\nOUTPUT_TYPE = [ ui | index ]'

if [ "$#" -ne 3 ]; then
	echo -e $HELP
	exit 1
fi

INPUT_TYPE="$1"
OUTPUT_TYPE="$2"
RESPONSE_PREFIX="$3"
FILE_NAME="$3"
NUM_RESPONSES="$4"
RESPONSE_WIDTH="$5"
CASE_NAME="$6"

if [ "$OUTPUT_TYPE" = "ui" ]; then
	if [ "$INPUT_TYPE" = "file" ]; then
		echo "<xml>"
		while IFS='' read -r line || [[ -n "$line" ]];
			do
				CURRENT_RESPONSE="$line"
				cat <<-eof
					<Response id="$CURRENT_RESPONSE">
						<LeftRail>
							<Id>main</Id>
							<Hidden>false</Hidden>
							<ModuleSelected>0</ModuleSelected>
						</LeftRail>
						<VideoControls>
							<Hidden>false</Hidden>
							<PreviousId>PREVIOUS_RESPONSE</PreviousId>
							<NextId>NEXT_RESPONSE</NextId>
						</VideoControls>
						<AskControls>
							<Hidden>false</Hidden>
							<Action>question</Action>
						</AskControls>
						<CaseName>$CASE_NAME</CaseName>
					</Response>
				eof
			done < "$FILE_NAME"
		echo "</xml>"
	elif [ "$INPUT_TYPE" = "prefix"]; then
		echo "<xml>"
		for ((p=0, c=1, n=2; c <= "$NUM_RESPONSES" ; p++,c++,n++))
		do
			PREVIOUS_RESPONSE=$(printf "$(echo $RESPONSE_PREFIX)%0$(echo $RESPONSE_WIDTH)d" $p)
			CURRENT_RESPONSE=$(printf "$(echo $RESPONSE_PREFIX)%0$(echo $RESPONSE_WIDTH)d" $c)
			NEXT_RESPONSE=$(printf "$(echo $RESPONSE_PREFIX)%0$(echo $RESPONSE_WIDTH)d" $n)

			cat <<-eof
				<Response id="$CURRENT_RESPONSE">
					<LeftRail>
						<Id>main</Id>
						<Hidden>false</Hidden>
						<ModuleSelected>0</ModuleSelected>
					</LeftRail>
					<VideoControls>
						<Hidden>false</Hidden>
						<PreviousId>$PREVIOUS_RESPONSE</PreviousId>
						<NextId>$NEXT_RESPONSE</NextId>
					</VideoControls>
					<AskControls>
						<Hidden>false</Hidden>
						<Action>question</Action>
					</AskControls>
					<CaseName>$CASE_NAME</CaseName>
				</Response>
			eof
		done
		echo "</xml>"
	fi
elif [ "$OUTPUT_TYPE" = "index" ]; then
	if [ "$INPUT_TYPE" = "file" ]; then
		echo "<xml>"
		while IFS='' read -r line || [[ -n "$line" ]];
			do
				CURRENT_RESPONSE="$line"
				cat <<-eof
					<Response id="$CURRENT_RESPONSE">
						<ResponseID id="0">$CURRENT_RESPONSE</ResponseID>
						<BaseQuestion id="0"></BaseQuestion>
						<Content id="0"></Content>
					</Response>
				eof
			done < "$FILE_NAME"
		echo "</xml>"
	fi
fi

exit 0