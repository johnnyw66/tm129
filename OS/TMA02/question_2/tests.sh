#!/bin/bash
sudo su nicky
echo "I am $(whoami)"
echo "$(whoami)'s holiday entry" >> /shared/holidays.txt
exit
sudo su kit
echo "I am $(whoami)"
echo "$(whoami)'s holiday entry" >> /shared/holidays.txt
exit
sudo su stark
echo "I am $(whoami)"
echo "$(whoami)'s holiday entry" >> /shared/holidays.txt
exit

sudo su lannister
echo "I am $(whoami)"
echo "$(whoami)'s holiday entry" >> /shared/holidays.txt
exit



# Move nicky to Management Group and check access to members.txt
sudo usermod -aG management nicky
sudo deluser nicky union
sudo chown rep:union /shared/members.txt
sudo su nicky
ls -l /shared/members.txt




