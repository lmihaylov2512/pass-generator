#!/usr/bin/env php
<?php

//import composer autoload file
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['.', '..', 'vendor', 'autoload.php']);

//create new instance and generate random password with default settings
//the default settings are: upperCase, lowerCase and digits
$pg = new PassGenerator\Generator($argv);

//print the generated password
echo $pg->password;
exit(1);
