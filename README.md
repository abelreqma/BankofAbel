# Overview
Bank of Abel is a deliberately vulnerable online banking web application developed for educational and research purposes. The application is backed by a MySQL database and includes user roles, balance displays, and sensitive data fields to demonstrate the potential impact of broken authentication and access control issues. **Again, this application is intentionally insecure and should never be deployed in a production environment.**

# Installation
1. Clone the Repository
```bash
git clone https://github.com/abelreqma/BankofAbel
```
2. Set up the MySQL Database
```bash
sudo systemctl start [mysql, mysqld]
mysql -u <user> -p < bank_of_abel.sql
```
3. Place Project Files in Web Server Directory; i.e., `/var/www/html`
```bash
sudo cp -r /path/to/BankofAbel/* /var/www/html/
```
4. Configure Web Server:
```bash
sudo systemctl start [apache2, nginx, httpd]
sudo systemctl restart [apache2, nginx, httpd]
```
* Modify corresponding configuration page (/etc/x/x.conf) to connect MySQL

5. Run Web Application: log in with the credentials **abel:qwerty123**
```bash
http://localhost/login.php
```

## Login Page

![alt text](https://github.com/abelreqma/BankofAbel/blob/main/pictures/login_page.png)

## Dashboard

![alt text](https://github.com/abelreqma/BankofAbel/blob/main/pictures/dashboard.png)
