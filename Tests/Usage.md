# Using the EllinghamTech library tests
Most tests uses PHPUnit 8.

File names that begin with an underscore do not use any testing framework.

## Installation of PHPUnit 8
Visit the PHPUnit 8 website: https://phpunit.de/getting-started/phpunit-8.html

To install on macOS via the terminal:
```
curl https://phar.phpunit.de/phpunit.phar -L -o phpunit.phar
chmod +x phpunit.phar
sudo mv phpunit.phar /usr/local/bin/phpunit
```

## Configuration
Copy config.php.example to config.php and alter the required lines.

## Command Line
Using the command line, the following command will execute the relevant file:

```
./phpunit --bootstrap Tests/PHPUnitBootstap.php Tests/folder/file.php
```

Adjust the file locations as necessary.