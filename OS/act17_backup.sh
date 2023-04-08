#!/bin/bash
dt=$(date +%d_%m_%Y)
tar -czvf $1.backup_$dt.tgz $1

