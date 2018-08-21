### What is?

A simple Rest API with the following features
* List Recipients
* Add Recipients
* Delete Recipients
* List Special Offers
* Add Special Offers
* Delete Special Offers
* List Vouchers
* Show Vouchers on HTML Page 
* Assign Special Offers and a Voucher Code to Recipients
* Reedim Voucher Code
* Delete Voucher Code

### How was it done?

I used the php Slim framework, with MVC standard, no ORM has been used, only a PDO connection 
oriented object. Twig has been used with a template engine.

* Slim Framework 3.x
* Twig Template Engine
* Bootstrap 4 - Purple Admin Template
* IDE Notepad++
* MySQL
* PHP 7.1
* Postman - To execute the Rest API

### How to execute

For the project to work correctly, it is necessary to have:
* PHP >= 5.5
* MySQL 

Follow these steps:
1. Access "src/settings" - here you inserts your mysql connection configs in define args
2. Import database smil.sql (placed in root path) in your MySQL
3. In root path "/" execute 
        
        composer install
4. And start your php server

        php -S localhost:8080 -t public public/index.php
    
5. Access your browser http://localhost:8080
6. Postman Document URL: https://documenter.getpostman.com/view/4979269/RWToQyFr
7. Refer to screenshots: public/images/screenshots

### Dashboard Screenshot
![Alt text](/public/images/screenshots/Dashboard.png?raw=true "Dashboard")