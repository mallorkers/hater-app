#!/bin/bash

NGINX_DIR=/etc/nginx
NGINX_NEW_CONFIG_FILE="$NGINX_DIR/sites-avaiable/$1"
NGINX_CONFIG="server {listen 80; root $(pwd); index index.php index.html index.htm; server_name $1.localhost; location / {try_files \$uri \$uri/ /index.php?\$args; } location ~ \.php$ {try_files \$uri \$uri/ /index.php?\$args; fastcgi_split_path_info ^(.+\.php)(/.+)$; fastcgi_pass unix:/var/run/php5-fpm.sock; fastcgi_index index.php; include fastcgi_params; } }";

#echo $NGINX_CONFIG

#echo "127.0.0.1 $1.localhost" >> /etc/hosts
#echo "$1.localhost 127.0.0.1" >> /etc/hosts

if [[ ! -f $NGINX_NEW_CONFIG_FILE ]]
	then
	echo "$NGINX_CONFIG" >> "$NGINX_NEW_CONFIG_FILE";
fi

#ln -s "$NGINX_DIR/sites-avaiable/$1" "$NGINX_DIR/sites-enabled/$1"
#nginx -t
#service nginx reload
