#!/bin/bash

# Define the PHP file to serve
PHP_FILE="/mnt/Project/Office/DotNet/Frontend"


# Start or restart Apache
sudo systemctl enable --now httpd
sudo systemctl restart httpd

php -S localhost:8000 -t $PHP_FILE

# Print message
echo "PHP Closed."
