# Image Placeholder

This is a simple tool for placeholder images that you can use in your webdesigns. There are many similar services online, however none of them you can host on your own server. 

## Installation
First of all, make sure you met all requirements mentioned below.

### Requirements
+ PHP => 7.1
+ GD library
+ Apache with mod_rewrite or Nginx

### Installation steps
Clone this repository to folder on your computer or server.
```
git clone https://github.com/silencesys/image-placeholder.git image-placeholder
```

Application does not require any other configuration. However, before you'll be able too generate your own placeholder images, last few steps remain. It is required to have Apache or Nginx on your machine and you should have set a virtual host pointing to the cloned directory. Then simply copy and modify following configuration snippets to the `sites-available` directory in Apache or Nginx, enable it and voila! 🔮


#### Basic Apache configuration
```Apache
<VirtualHost *:80>
    ServerName   yourdomain.name
    ServerAdmin  admin@yourdomain.name
    DocumentRoot /where/is/the/repo/clonned

    <Directory /where/is/the/repo/clonned>
        Options FollowSymLinks MultiViews
        AllowOverride FileInfo
        Order allow,deny
        Allow from All
    </Directory>
</VirtualHost>
```

#### Basic Nginx configuration
```nginx
server {
    listen 80;
    listen [::]:80;

    server_name yourdomain.name;
    root /where/is/the/repo/clonned;

    index index.php index.html index.htm index.nginx-debian.html;

    location / {
            try_files $uri $uri/ /index.php?data=$query_string;
    }

    location ~ \.php$ {
            sendfile on;
            sendfile_max_chunk 1m;
            try_files $uri /index.php = 404;

            # ... phpconf (usually fastcgi)
    }


    location ~ /\.ht {
            deny all;
    }
}
```

## How it works?
If the installation was successfull you should be able to visit domainname you set and see welcome image. Then follow rules described below to generate placeholders for your amazing webdesign! 😉 🖼

### Basic URL structure
```
https://yourdomain.name/width-height?color=hex&text-color=hex&text=string
```

### Requests should look like
+ `img.example.com/300` - this will generate image with default colours and size 300x300px
+ `img.example.com/300x250` - width will be 300px and height 250px
+ `img.example.com/300?color=fcfcfc` - background color will be `#fcfcfc`
+ `img.example.com/300?text-color=fcfcfc` - text color will be `#fcfcfc`
+ `img.example.com/300?text=Hello` - instead of image size, there will be "hello" on the picture.

## Too lazy to install it on your own? 
That's OK! I made it also available online, just visit `img.silencesys.dev`.
