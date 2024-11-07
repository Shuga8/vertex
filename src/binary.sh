#!/bin/bash

while true; do
    php artisan binary:calculate
    wait  

    sleep 10
done