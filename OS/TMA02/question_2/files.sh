# 'Top' Directory '/shared' for Acme Company
sudo mkdir /shared
sudo chown acme:acme /shared
sudo chmod u=rwx,g=rwx,o= /shared

# Holiday File - read/write by members of group 'acme'
sudo touch /shared/holidays.txt
sudo chown acme:acme /shared/holidays.txt
sudo chmod u=rw,g=rw,o= /shared/holidays.txt


#Union Members
sudo touch /shared/members.txt
sudo chown nicky:union /shared/members.txt
sudo chmod u=rw,g=r,o= /shared/members.txt

#Management Files
sudo touch /shared/plans.txt
sudo chown manager:management /shared/plans.txt
sudo chmod u=rw,g=rw,o= /shared/plans.txt

sudo touch /shared/pay.txt
sudo chown manager:management /shared/pay.txt
sudo chmod u=rw,g=rw,o= /shared/pay.txt

