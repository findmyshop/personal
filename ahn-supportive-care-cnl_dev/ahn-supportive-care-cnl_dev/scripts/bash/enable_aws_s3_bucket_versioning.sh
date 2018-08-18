#!/bin/bash
# The one-liner below enables versioning on all s3 buckets.  Note, this must be ran on a machine with the aws CLI tool installed.  When this script was written,
# prod03.medrespond.net was the only server with aws installed.

while read BUCKET; do aws s3api put-bucket-versioning --bucket $BUCKET --versioning-configuration MFADelete=Disabled,Status=Enabled; done < <(aws s3 ls | awk '{print $3}')
