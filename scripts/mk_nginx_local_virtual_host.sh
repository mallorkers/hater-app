#!/bin/bash

NGINX_DIR="/etc/nginx"
NGINX_NEW_CONFIG_FILE="$NGINX_DIR/sites-available/$1"
NGINX_CONFIG="server
{
	listen 80;
	root $(pwd);
	index index.php index.html index.htm;
	server_name $1.localhost;

	location / {
		try_files \$uri \$uri/ /index.php?\$args;
	} 

	location ~ \.php$ {
		try_files \$uri \$uri/ /index.php?\$args;
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		fastcgi_pass unix:/var/run/php5-fpm.sock;
		fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
		fastcgi_index index.php;
		include fastcgi_params;
	}
}";

#TODO: Make reversible actions (remove configs)
#TODO: check if the current config is already present
#TODO: Atomic operations

#echo $NGINX_CONFIG

if [[ $1 == 'help' ]]
	then
	printf 'This script creates the configuration needed to run a slim app
in nginx as a subdomain of localhost, you have to provide a name
as first parameter for the app that will be used as a name for the
subdomain, and for the configuration of nginx and the settings in /etc/hosts \n'
	exit 1
fi

if [ -z "$1" ]
	then
	echo "USAGE"
	echo "You have to provide a name for the app as a first parameter:"
	echo "sudo $0 [name]"
	exit 1
fi

if [[ ! $(whoami) == "root" ]]
	then
	echo "You have to run $0 as root"
	exit 1
fi

echo "127.0.0.1 $1.localhost" >> /etc/hosts
echo "$1.localhost 127.0.0.1" >> /etc/hosts
echo $NGINX_CONFIG > $NGINX_NEW_CONFIG_FILE
ln -s $NGINX_NEW_CONFIG_FILE "$NGINX_DIR/sites-enabled/$1"
nginx -t
service nginx reload
