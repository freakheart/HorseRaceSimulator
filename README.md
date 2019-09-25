# HorseRaceSimulator
A horse racing simulator with PHP and Symfony Framework.

# Instructions
- Clone the Repository
  - ```git clone https://github.com/freakheart/HorseRaceSimulator.git```
- Enable pdo_pgsql extension in ```php.ini``` if you are using Windows, run ```sudo apt-get install php-pgsql``` in debian/ubuntu.

- Update the ```DATABASE_URL``` in ```.env``` file.

- Run the following commands
  - ```composer install```
  - ```php bin/console doctrine:database:create```
  - ```php bin/console doctrine:migrations:migrate```
  - ```php bin/console server:run```

# Author
Subash Koutilya Chidipothu(subash.koutilya@gmail.com)

# License
Copyright(c) 2019 MIT License
