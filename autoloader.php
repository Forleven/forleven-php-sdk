<?php

/**
 * @see https://github.com/renanpalmeira/agil-framework/blob/master/autoload.php#L9
 */

if(file_exists(__DIR__ . '/guzzle'))
{
    include 'guzzle/autoloader.php';
}

$mapping = array(
    'Forleven\Core\Http\Client\Client'	=> __DIR__ . '/src/Core/Http/Client.php',
    'Forleven\Forleven'					=> __DIR__ . '/src/Forleven.php',
);

spl_autoload_register(function ($class) use ($mapping) {
    if (isset($mapping[$class])) {
        include $mapping[$class];
    }
    else
    {
		$class = preg_replace('/^(Forleven)/', 'src', $class);
		$class = dirname(__FILE__) . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, $class). '.php';

	    if(file_exists($class))
	    {
	        include $class;
	    }
    }
});