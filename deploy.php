<?php

require 'recipe/symfony.php';

// Define server for deploy.
// Let's name it "main" and use 22 port.
server('staging', '192.241.178.210', 22)
    ->path('/var/www/Project/RufyApi')      // Define base path to deploy you project.
    ->user('matiux', '281285ma_');          // Define SSH user name and password.
                                            // You can skip password and it will be asked on deploy.
                                            // Also you can connect to server SSH via public keys and ssh config file.

// Specify repository from which to download your projects code.
// Server has to be able clone your project from this repository.
set('repository', 'git@bitbucket.org:rufyteam/rufy-rest-api.git');
