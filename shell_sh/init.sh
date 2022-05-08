#!/bin/sh

cd /usr/php7/sbin && ./php-fpm -R


cd /root/demo && ./UI &


mount /dev/sda /mnt/disk1

ln -s /mnt/disk1 datas
