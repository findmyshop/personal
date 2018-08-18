#!/bin/bash
# Cleans and formats the index.xml, resources.xml, and ui.xml config files by calling clean_xml_config_files.sh which doing the following:
# 1. Removes leading and trailing whitespace from attribute and element values
# 2. Removes non-printable characters
# 3. Properly indents XML

SCRIPT_DIRECTORY="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
CONFIG_DIRECTORY=$(dirname $(dirname $SCRIPT_DIRECTORY))/httpdocs/config

# Clean index.xml files
while read FILE; do
	$SCRIPT_DIRECTORY/clean_xml_file.sh $FILE
done < <(find $CONFIG_DIRECTORY -type f -name index.xml)

# Clean resources.xml files
while read FILE; do
	$SCRIPT_DIRECTORY/clean_xml_file.sh $FILE
done < <(find $CONFIG_DIRECTORY -type f -name resources.xml)


# Clean ui.xml files
while read FILE; do
	$SCRIPT_DIRECTORY/clean_xml_file.sh $FILE
done < <(find $CONFIG_DIRECTORY -type f -name ui.xml)

exit 0