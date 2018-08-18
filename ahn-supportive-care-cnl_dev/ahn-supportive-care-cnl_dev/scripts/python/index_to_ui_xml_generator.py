# outputs a basic ui.xml file based on the responses contained in the index.xml file provided
# Responses elements within for the ui.xml file are created in the following format

# <Response id="response_id">
#    <LeftRail>
#        <Id>main</Id>
#        <Hidden>false</Hidden>
#    </LeftRail>
#    <VideoControls>
#        <Hidden>false</Hidden>
#        <PreviousId><PreviousId/>
#        <NextId></NextId>
#    </VideoControls>
#    <AskControls>
#        <Hidden>false</Hidden>
#        <Action>analyze</Action>
#    </AskControls>
#    <CaseName>Case_Name</CaseName>
# </Response>

import os, sys
import xml.etree.ElementTree as ET
import xml.dom.minidom

# check to make sure that the case name and index.xml file name was passed in as an argument
if len(sys.argv) != 3:
    sys.exit('Error: Please specify the case name to use and index.xml file to parse!')

case_name = sys.argv[1]
index_xml_file = sys.argv[2]

# check to make sure that the specified index.xml file exists
if not os.path.exists(index_xml_file) or not os.path.isfile(index_xml_file):
    sys.exit('Error: ' + index_xml_file + ' file not found!')

# index.xml elements
index_xml_tree = ET.parse(index_xml_file)
index_xml_root = index_xml_tree.getroot()

# ui.xml Root Element
ui_xml_root = ET.Element('xml')

for response in index_xml_root.findall('Response'):
    # Response Element
    response_element = ET.Element('Response');
    response_element.attrib['id'] = response.attrib['id']

    # Left Rail Elements
    left_rail_element = ET.SubElement(response_element, 'LeftRail')
    left_rail_id_element = ET.SubElement(left_rail_element, 'Id')
    left_rail_hidden_element = ET.SubElement(left_rail_element, 'Hidden')
    left_rail_id_element.text = 'main'
    left_rail_hidden_element.text = 'false'

    # Video Controls Element
    video_controls_element = ET.SubElement(response_element, 'VideoControls')
    video_controls_hidden_element = ET.SubElement(left_rail_element, 'Hidden')
    video_controls_previous_id_element = ET.SubElement(video_controls_element, 'PreviousId')
    video_controls_next_id_element = ET.SubElement(video_controls_element, 'NextId')
    video_controls_hidden_element.text = 'false'
    video_controls_previous_id_element.text = ''
    video_controls_next_id_element.text = ''

    # Ask Controls Element
    ask_controls_element = ET.SubElement(response_element, 'AskControls')
    ask_controls_hidden_element = ET.SubElement(ask_controls_element, 'Hidden')
    ask_controls_action_element = ET.SubElement(ask_controls_element, 'Action')
    ask_controls_hidden_element.text = 'false'
    ask_controls_action_element.text = 'analyze'

    # Case Name Element
    case_name_element = ET.SubElement(response_element, 'CaseName')
    case_name_element.text = case_name

    # Add Response Element to the ui.xml root element
    ui_xml_root.append(response_element)

xmlstring = xml.dom.minidom.parseString(ET.tostring(ui_xml_root, encoding = 'us-ascii', method = 'xml'))
print(xmlstring.toprettyxml())










