# Clean up

sudo rm -rf /shared

# Note - system users will not have a home

sudo deluser --remove-home stark
sudo deluser --remove-home lannister
sudo deluser --remove-home nicky
sudo deluser --remove-home kit
sudo deluser --remove-home rep
sudo deluser --remove-home manager
sudo deluser --remove-home acme


sudo delgroup union
sudo delgroup management
sudo delgroup workers
sudo delgroup acme

