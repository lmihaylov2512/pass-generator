Simple and elegant PHP password generator
======================

[![Build Status](https://travis-ci.org/lmihaylov2512/pass-generator.svg?branch=master)](https://travis-ci.org/lmihaylov2512/pass-generator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/lmihaylov2512/pass-generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/lmihaylov2512/pass-generator/?branch=master)

Useful tool for generating password which can be running in either browser and console environments. It can be customize in each aspects: symbols types, length, allowed minimum and maximum sizes and patterns for characters group.

----------------------

Requirements
----------------------

 - installed PHP version >= 7.0
 - Composer dependency tool
 - Node.js plus NPM package manager
 - Bower CLI
 - Grunt CLI

----------------------

Demo
----------------------
All demos (for console and browsers) are located in "demo" directory. The examples for each of them are following:

 - [Web browser demo](http://pass-generator.lmihaylov.com){:target="_blank"}
 - [Console demo](demo/console/demo_cli.php)

----------------------

Documentation
----------------------

The package's consumers can modify all kind of configuration options. They may customize password length plus minimum and maximum sizes.
The available configuration options are:

 - upperCase: use alphabet upper letters [A-Z]
 - lowerCase: use alphabet lower letters [a-z]
 - digits: all numbers [0-9]
 - special: special symbols ~, !, @, #, ...
 - brackets: all kind of brackets (, ), {, }, [, ]
 - minus: minus sign -
 - underline: underline sign _
 - space: space character ' '
 - length: define password string size (symbols count)
 
It is allowed to change the characters pattern for specific group type (upperCase, lowerCase, etc) via "Storage" static class.

----------------------

Author
----------------------
Lachezar Mihaylov
E-mail: [me@lacho-portfolio.com](me@lacho-portfolio.com)

----------------------

License
----------------------
[The MIT License (MIT)](LICENSE.md)
