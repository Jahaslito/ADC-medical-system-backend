#! /bin/bash

for file in ./database/migrations/*
do
echo $file;
php artisan migrate:refresh --path="$file";
done
