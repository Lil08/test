ngnix config:


server {

        listen 80;
        index index.php index.html;
        server_name basic.localhost;
        error_log /var/log/nginx/basic.error.log;
        access_log /var/log/nginx/basic.access.log combined if=$loggable;
        root /var/www/lil08/basic/web;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
            # admin:12345
            auth_basic "Restricted";
            auth_basic_user_file /etc/nginx/conf.d/.htpasswd;
        }

        location ~ \.php$ {
            try_files $uri =404;
            fastcgi_split_path_info ^(.+\.php)(/.+)$;
            fastcgi_pass php-7.3:9000;
            fastcgi_index index.php;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_script_name;
        }
}

