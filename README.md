# Dinamiot
![alt text](https://images.pexels.com/photos/3691907/pexels-photo-3691907.png?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940)
Dinamiot is a web dashboard and web server for monitoring realtime IoT devices. By adding a new device on the website, users will get an API endpoint to be used as an IoT device access to the web server. On this website, each device has its own dashboard. There are two categories of device components, namely component with analog and digital types, for example: The generator has three components to be monitored are: Temperature (analog), Fuel (analog), cooling fan (digital). On the Generator dashboard, the temperature and fuel components will be displayed in the form of a Chart Line and Gauge Chart, while the cooling fan components will be displayed in a panel that shows the status of ON or OFF.

- [Dinamiot](#dinamiot)
    - [Installation](#installation)
        - [Clone Project](#clone-project)
        - [Update Composer](#update-composer)
        - [Install NPM Package](#install-npm-package)
        - [Configure Env](#configure-env)
        - [Finishing](#finishing)
    - [Useage](#useage)
        - [Run Project](#run-project)
        - [Listen Queue](#listen-queue)
        - [Run server.js](#run-server.js)
        - [Create Cron Job](#create-cron-job)
        
## Installation
Make sure you have installed MongoDB, MongoDB PHP Driver, and NPM. If you don't have it, please see the installation instructions on the following links:
- MongoDB (https://docs.mongodb.com/manual/installation/)
- MongoDB PHP Driver (http://php.net/manual/en/mongodb.installation.php)
- NPM (https://www.npmjs.com/get-npm)

### Clone Project
```
$ git clone https://github.com/jeffsuto/dinamiot.git
```
### Update Composer
After cloning the project, enter the dinamiot project directory. After entering the directory, run the following command to update the laravel package.

Make sure you have installed composer. If you have not installed it, please see the installation instructions at https://getcomposer.org/doc/00-intro.md.
```
$ composer update
```
### Install NPM Package
Some node.js packages are needed in this project for the process of displaying data in realtime. The required node.js packages include:
```
$ npm install socket.io

$ npm install redis

$ npm install dotenv
```
### Configure Env
Rename ```.env.example``` file to ```.env```
#### Configure App Url
Fill in the APP_URL value according to your project host.
```
APP_URL=
```
#### Configure database
Configure the database in the ```.env``` file if there is a conflict with the database configuration on your operating system.
```
DB_CONNECTION=mongodb
DB_HOST=127.0.0.1
DB_PORT=27017
DB_DATABASE=db_dinamiot
DB_USERNAME=
DB_PASSWORD=
```
#### Configure redis
Configure the redis if there is a conflict with the redis configuration on your operating system.
```
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379
```
#### Configure socket port
You can change the port value at ```SOCKET_PORT``` if the port value in this ```.env``` file is already used in your operating system.
```
SOCKET_PORT=3030
```
### Finishing
After configuring the ```.env``` file, run the following command in the command line:
- Clear config and cache laravel
```
$ php artisan config:cache

$ php artisan config:clear
```
- Migrating database
```
$ php artisan migrate
```
## Useage
### Run Project
To run this project, you can use virtual host or run command ```serve``` in the Artisan command as below:
```
$ php artisan server
```
### Listen Queue
After the project can be ran, the next step is activating Queue on the Laravel framework with run the following command:
```
$ php artisan queue:listen
```
### Run server.js
In order for the data to be displayed directly in real time, run the ```server.js``` file with the following command:
```
$ node server.js
```
### Create Cron Job
A cron job is required to check the status of the device. if the device does not make a request during a predetermined time interval with an additional tolerance of 30 seconds, then the status of the device will be changed to disconnected.
```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
