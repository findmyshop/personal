#!/bin/bash

# *************************************************************************
# Generate BQ Responses for Scenarios 1 - 6 (Model, Theo, Leading)
# *************************************************************************
echo {PS,HS}{2..6}BQModel | tr ' ' '\n'
echo PS{2..6}BQ{Theo,Leading} | tr ' ' '\n'
echo HS{2..6}BQ{Theo,Leading}{1,2} | tr ' ' '\n'

# *************************************************************************
# Generate FW Responses - for Scenarios 1 - 6 (Model, Wrong, Theo, Leading)
# *************************************************************************
echo {PS,HS}{1..6}FWModel | tr ' ' '\n'
echo {PS,HS}{1,4}FW{Wrong,Theo,Leading} | tr ' ' '\n'
echo PS3FW{Theo,Leading} | tr ' ' '\n'
echo HS3FW{Theo,Leading}{1,2} | tr ' ' '\n'
echo PS{2,5,6}FW{Wrong,Theo,Leading} | tr ' ' '\n'
echo HS{2,5,6}FW{Wrong,Theo,Leading}{1,2} | tr ' ' '\n'

# *************************************************************************
# Generate MF Responses - for Scenarios 1 - 6 (Model, Vague, Leading)
# *************************************************************************
echo {PS,HS}{1..6}MFModel | tr ' ' '\n'
echo {PS,HS}{1,4}MF{Vague,Leading} | tr ' ' '\n'
echo PS{2,3,5,6}MF{Vague,Leading} | tr ' ' '\n'
echo HS{2,3,5,6}MF{Vague,Leading}{1,2} | tr ' ' '\n'

# *************************************************************************
# Other Responses - for Scenarios 1 - 6 (Shame, Illegal, Brain, Null)
# *************************************************************************
for sequence in $(seq 1 6);
do
	echo {PS,HS}"$sequence"{Shame,Illegal,Impolite,Brain,Null} | tr ' ' '\n'
done
