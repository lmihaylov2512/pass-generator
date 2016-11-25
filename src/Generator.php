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
 * @property boolean $upperCase
 * @property boolean $lowerCase
 * @property boolean $digits
 * @property boolean $special
 * @property boolean $brackets
 * @property boolean $minus
 * @property boolean $underline
 * @property boolean $space
 * @property integer $length
 * 
 * @author Lachezar Mihaylov <me@lacho-portfolio.com>
 * @license https://github.com/lmihaylov2512/pass-generator/blob/master/LICENSE.md MIT License
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
    public function __construct(array $config = [], int $minLength = self::DEFAULT_MIN_LENGTH, int $maxLength = self::DEFAULT_MAX_LENGTH, bool $autoGenerate = true)
    {
        global $argv;
        
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
            $this->generate();
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
        } else if (array_key_exists($name, $this->defaults)) {
            return $this->defaults[$name];
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
        $this->data['password'] = '';
        
        while ($counter > 0) {
            $this->data['password'] .= $pattern[mt_rand(0, $max)];
            $counter--;
        }
        
        return $this->data['password'];
    }
}

