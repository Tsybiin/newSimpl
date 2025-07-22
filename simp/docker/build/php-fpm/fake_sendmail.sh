#!/bin/sh
prefix="/var/mail/"
date=`date +%d.%m.%Y---%T`

name="$prefix/$date.txt"
while read line
do
echo $line >> $name
done
chmod 666 $name