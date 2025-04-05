# Overview
Bank of Abel is a deliberately vulnerable online banking web application developed for educational and research purposes. The application is backed by a MySQL database and includes user roles, balance displays, and sensitive data fields to demonstrate the potential impact of broken authentication and access control issues. Again, this application is intentionally insecure and should never be deployed in a production environment.

# Installation
1. Clone the Repository
```bash
git clone https://github.com/abelreqma/cs674
```
2. Set up the MySQL Database
```bash
mysql -u <user> -p < bank_of_abel.sql
```
3. Place Project Files in Web Server Directory; i.e., `/var/www/html`
```bash
sudo cp -r /path/to/cs674/* /var/www/html/
```
4. Configure Web Server:
```bash
sudo systemctl start [apache2, nginx, httpd]
```
* Modify corresponding configuration page (/etc/x/x.conf) to connect MySQL

5. Run Web Application:
```bash
http://localhost/login.php
```
