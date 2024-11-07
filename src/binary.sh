#!/bin/bash

while true; do
    php artisan binary:calculate
    wait  

    sleep 100
done