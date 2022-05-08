#!/bin/sh
while true
do
	ui=`ps -ef | grep "./UI" | grep -v "grep" | wc -l`
	if [ $ui == 0  ]
	then
		cd /root/demo && nohup ./UI > nohup.out &
		sleep 12
	else
		break
	fi
done
