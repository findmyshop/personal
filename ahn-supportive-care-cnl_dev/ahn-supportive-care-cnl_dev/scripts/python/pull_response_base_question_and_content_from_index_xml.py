# print the response_id, base_question, and content for each response in the given index.xml file

import os, sys
import xml.etree.ElementTree as ET

# check to make sure that the index.xml filename was passed in as an argument
if len(sys.argv) != 2:
    sys.exit('Error: Please specify the index.xml file to parse!')

index_xml_file = sys.argv[1]

# check to make sure that the specified index.xml file exists
if not os.path.exists(index_xml_file) or not os.path.isfile(index_xml_file):
    sys.exit('Error: ' + index_xml_file + ' file not found!')

# index.xml elements
index_xml_tree = ET.parse(index_xml_file)
index_xml_root = index_xml_tree.getroot()

for response in index_xml_root.findall('Response'):
    base_question = response.find('BaseQuestion')
    content = response.find('Content')
    print "%s|%s|%s" % (response.attrib['id'], base_question.text, content.text.replace('\n', ' ').strip())

