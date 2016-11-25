<?php

require_once dirname(__FILE__) . implode(DIRECTORY_SEPARATOR, ['.', '..', 'vendor', 'autoload.php']);

$pg = new PassGenerator\Generator($argv);

echo $pg->password;

