# Done on a raspberry-pi (Raspian) where user 'pi' has sudo privileges

sudo addgroup acme
sudo addgroup union
sudo addgroup management
sudo addgroup workers


# Stark user and groups
sudo adduser --disabled-password stark
sudo addgroup stark acme
sudo addgroup stark management

# Lannister user and groups
sudo adduser --disabled-password lannister
sudo addgroup lannister acme
sudo addgroup lannister management


# Nicky user and groups  (worker with union membership)
sudo adduser --disabled-password nicky
sudo addgroup nicky acme
sudo addgroup nicky union
sudo addgroup nicky workers

# Kit user and groups (worker with union membership)
sudo adduser --disabled-password kit
sudo addgroup kit acme
sudo addgroup kit union
sudo addgroup kit workers


# Add a 'dummy' user 'acme' (user acme belongs to 'nogroup')
sudo adduser --disabled-password --no-create-home  --system acme

# Add a 'dummy' user 'manager' (user acme belongs to 'nogroup')
sudo adduser --disabled-password --no-create-home  --system manager

# Add a 'dummy' user 'rep'
# We need some user to own 'members.txt' - the union file
# when we remove Nicky as the owner
sudo adduser --disabled-password --no-create-home  --system rep

