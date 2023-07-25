![mercury-banner](https://user-images.githubusercontent.com/79598596/210885191-14c6a07e-fbc8-443a-ba22-59c02cff9fe4.svg)
<p align="center">
 <img src="https://img.shields.io/github/license/90N45-d3v/Mercury.svg">
 <img src="https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg">
 <img src="https://img.shields.io/badge/PHP-%3E%3D8.0-blue.svg">
</p>

<p align="center">
Mercury is a DIY communication system. It acts as a web-based group chat. The project is open source and can be hosted at home on a Raspberry Pi or at an online hosting service of your choice.
</p>

# Installation on a homeserver (ex. Raspberry Pi)
#### *Quik run with PHP's developer server*
````
php -S <LOCAL IP-ADDRESS>:<PORT>
````
###### *PHP's built-in webserver may have (security-)issues and is not intended to be a full-featured web server.*

#### 1. Install a web server of your choice and PHP
Popular servers:
- [Apache2](https://httpd.apache.org/)
- [Nginx](https://www.nginx.com/resources/glossary/nginx/)

PHP (Version 8 or above)
- [Homepage](https://www.php.net/)

#### 2. Download this repository
- With Git from terminal
````
git clone https://github.com/90N45-d3v/Mercury
````

- From the webpage: `<> Code` --> `local` --> `Download ZIP`

#### 3. Setup up your webserver with Apache2, Nginx...
- Set 777 file permission to `raw_msgs.txt`, `token.txt`, `admin/token.txt` and `admin/blacklist.txt` (UNIX: `chmod 777 <FILE>`)
- Enable PHP on web-server
  ##### For the Mercury Messenger webserver
- Change root directory in web-server config to `mercury/root`
  ##### For the Mercury Admin-Panel webserver (If the Admin-Panel is not needed, you can skip this)
- Change root directory in second web-server config to `mercury/admin/root`

#### 4. Configure last things and start your webserver
- Just as your choosen webserver describes it
###### Keep in mind, that if you want to communicate over WAN (Not only in your own local network) and you are hosting Mercury at home, you need to do Port-Forwarding ([Tutorial](https://www.lifewire.com/how-to-port-forward-4163829))
