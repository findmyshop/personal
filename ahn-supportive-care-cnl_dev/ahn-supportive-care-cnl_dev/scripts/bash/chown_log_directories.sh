#!/bin/bash

while read LOG_DIR; do chown www-data:www-data $LOG_DIR; done < <(find . -type d -name logs | grep 'codeigniter/application/logs')