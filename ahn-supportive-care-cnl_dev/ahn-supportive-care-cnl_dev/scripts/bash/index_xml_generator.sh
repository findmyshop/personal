#!/bin/bash

HELP=':: Usage ::\n./ui_xml_generator.sh [ file|prefix|help ] [ RESPONSE_PREFIX|FILE_NAME ] [ NUM_RESPONSES ] [ RESPONSE_WIDTH ] [ CASE_NAME ]\n:: User Commands :: \nfile \nprefix \nhelp'

if [ "$#" -ne 2 ]; then
	echo -e $HELP
	exit 1
fi

USER_COMMAND="$1"
RESPONSE_PREFIX="$2"
FILE_NAME="$2"
NUM_RESPONSES="$3"
RESPONSE_WIDTH="$4"
CASE_NAME="$5"

if [ "$USER_COMMAND" == "help" ]; then
	echo -e $HELP
	exit 1
fi

if [ "$USER_COMMAND" = "file" ]; then
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

elif [$USER_COMMAND = "prefix"]; then

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


exit 0