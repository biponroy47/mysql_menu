#!/bin/bash

# Run the MySQL command
sudo mysql -nvvf --verbose -pcs3319 < script1.sql > outputscript1.txt 2>&1
