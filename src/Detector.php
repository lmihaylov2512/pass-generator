<?php

namespace PassGenerator;

/**
 * Detector class which should detect a environment where the script is running.
 * 
 * @property string $env detected environment
 * 
 * @author Lachezar Mihaylov <me@lacho-portfolio.com>
 * @license https://github.com/lmihaylov2512/pass-generator/blob/master/LICENSE.md MIT License
 */
class Detector
{
    /**
     * @var array data like environment and console arguments
     */
    protected $data;
    /**
     * @var array list with all allowed environments
     */
    private $_envs = [
        'console' => 'cli',
        'browser' => 'server',
    ];
    
    /**
     * Initialize current environment and set some useful data.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->detect();
    }
    
    /**
     * Overloading method for getting element value from data array.
     * 
     * @param string $name data storage key name
     * @return mixed|null the value of data key
     */
    public function __get($name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }
    
    /**
     * Detect an environment in which is running the script.
     * 
     * @return void
     */
    public function detect()
    {
        if (php_sapi_name() === $this->_envs['console']) {
            $this->data['env'] = $this->_envs['console'];
        } else {
            $this->data['env'] = $this->_envs['browser'];
        }
    }
}
