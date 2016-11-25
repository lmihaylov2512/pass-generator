<?php

namespace PassGenerator;

/**
 * Generate random password string according to specific configuration.
 * It can customize password length and minimum and maximum sizes.
 * The allowed configuration options are:
 *  - upperCase: all alphabet upper letters [A-Z]
 *  - lowerCase: all alphabet lower letters [a-z]
 *  - digits: all numbers [0-9]
 *  - special: special symbols ~,!,@,#,...
 *  - brackets: all kind of brackets (,),{,},[,]
 *  - minus: minus sign -
 *  - underline: underline sign _
 *  - space: space character
 *  - length: password string size
 * 
 * @property string $password the generated password
 * 
 * @author Lachezar Mihaylov <me@lacho-portfolio.com>
 */
class Generator
{
    /**
     * @var integer default minimum password size
     */
    const DEFAULT_MIN_LENGTH = 6;
    /**
     * @var integer default maximum password size
     */
    const DEFAULT_MAX_LENGTH = 32;
    
    /**
     * @var Detector environment detector instance
     */
    protected $detector;
    /**
     * @var array default configurations (key: type => value: configuration)
     */
    protected $defaults = [
        'upperCase' => true,
        'lowerCase' => true,
        'digits' => true,
        'special' => false,
        'brackets' => false,
        'minus' => false,
        'underline' => false,
        'space' => false,
        'length' => 12,
    ];
    /**
     * @var array data storage
     */
    protected $data;

    /**
     * Detect environment, apply passed configuration and generate a password, if auto generating is turn on.
     * 
     * @global array $argv passed console arguments
     * @param array $config configurations array
     * @param int $minLength custom password minimum length
     * @param int $maxLength custom password maximum length
     * @param bool $autoGenerate whether generate password after initialization
     * @return void
     */
    public function __construct(array $config = [], int $minLength = 0, int $maxLength = 0, bool $autoGenerate = true)
    {
        global $argv;
        
        //sanitize passed arguments
        $minLength = $minLength == 0 ? self::DEFAULT_MIN_LENGTH : $minLength;
        $maxLength = $maxLength == 0 ? self::DEFAULT_MAX_LENGTH : $maxLength;
        
        //detect environment
        $this->detector = new Detector();
        if ($this->detector->env === 'cli' && count($config) === 0) {
            $config = $argv;
        }
        
        //apply passed configurations
        foreach ($config as $key => $val) {
            if (array_key_exists($key, $this->defaults)) {
                $this->defaults[$key] = !!$val;
            } else if (array_key_exists($val, $this->defaults)) {
                $this->defaults[$val] = true;
            } else if (is_numeric($val) && $val >= $minLength && $val <= $maxLength) {
                $this->defaults['length'] = (int) $val;
            }
        }
        
        if ($autoGenerate) {
            $this->data['password'] = $this->generate();
        }
    }
    
    /**
     * Get storage value according passed key.
     * 
     * @param string $name specific storage key
     * @return mixed the response value
     */
    public function __get(string $name)
    {
        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
    }
    
    /**
     * Change configuration type value.
     * 
     * @param string $name configuration type
     * @param boolean|integer $value the new value
     * @return void
     */
    public function __set(string $name, $value)
    {
        if (array_key_exists($name, $this->defaults)) {
            $this->defaults[$name] = ($name === 'length') ? (int) $value : !!$value;
        }
    }
    
    /**
     * Generate the password based on configuration array.
     * 
     * @return string the generated password
     */
    public function generate(): string
    {
        //initial initilization
        $chars = Storage::getCharacters();
        $pattern = '';
        
        foreach ($this->defaults as $type => $val) {
            if ($val && isset($chars[$type])) {
                $pattern .= $chars[$type];
            }
        }
        
        $pattern = str_shuffle($pattern);
        $max = strlen($pattern) - 1;
        $counter = $this->defaults['length'];
        $password = '';
        
        while ($counter > 0) {
            $password .= $pattern[mt_rand(0, $max)];
            $counter--;
        }
        
        return $password;
    }
}

