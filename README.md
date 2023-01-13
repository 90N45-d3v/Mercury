![mercury-banner](https://user-images.githubusercontent.com/79598596/210885191-14c6a07e-fbc8-443a-ba22-59c02cff9fe4.svg)
<p align="center">
 <img src="https://img.shields.io/github/license/90N45-d3v/Mercury.svg">
 <img src="https://img.shields.io/badge/Ask%20me-anything-1abc9c.svg">
 <img src="https://img.shields.io/badge/PHP-%3E%3D8.0-blue.svg">
</p>

<p align="center">
Mercury is a DIY communication system. It's a webserver, and works like a web based group chat.<br>Of course it is not as secure as Telegram or similar messengers (at least I hope so), but I still try to make it as secure as possible. Mercury is open source. You can host it at home on a Raspberry Pi or with the online hoster of your choice.<br>You have full control of it.
</p>

## Installation guide on debian linux with apache2
````
git clone https://github.com/90N45-d3v/Mercury
cd Mercury/mercury
sudo bash install.sh
````
#### If you want to host it on another system/server, you need to do the following manually:
- Set 777 file permission to `raw_msgs.txt` and `token.txt` (UNIX: `chmod 777 <FILE>`)
- Change root directory in web-server config to `Mercury/mercury/root`
- Enable PHP on web-server
