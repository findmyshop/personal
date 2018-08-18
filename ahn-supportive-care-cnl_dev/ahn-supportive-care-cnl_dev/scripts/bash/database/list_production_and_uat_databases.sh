#!/bin/bash

/usr/bin/mysqlshow -u root -p'ct&sb1rt$$fun' | grep '_production\|_uat' | awk '{print $2}' | grep '_production$\|_uat$'