#!/bin/bash
dt=$(date +%d_%m_%Y)
backupdir="backups"
for file in $@
do
### Check if directory exists. Ignore and carry on if it does not.	
   if [ -d $file ] 
   then
      echo "Backing up $file to backups/$f.backup_$dt.tgz"
      tar -czvf $backupdir/$file.backup_$dt.tgz $file
      echo "Completed backing up '$file'"
   else 
      echo "Directory does not exist. Ignore '$file'"
   fi
done
