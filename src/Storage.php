<?php

namespace PassGenerator;

/**
 * The storage for all kinds characters and types string mapping.
 * 
 * @author Lachezar Mihaylov <me@lacho-portfolio.com>
 * @license https://github.com/lmihaylov2512/pass-generator/blob/master/LICENSE.md MIT License
 */
class Storage
{
    /**
     * @var array list with all allowed characters and their type (type key => characters string)
     */
    protected static $characters = [
        'upperCase' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
        'lowerCase' => 'abcdefghijklmnopqrstuvwxyz',
        'digits' => '0123456789',
        'special' => '~!@#$%^&*=+/?.,\|\';:',
        'brackets' => '()[]{}<>',
        'minus' => '-',
        'underline' => '_',
        'space' => ' ',
    ];
    
    /**
     * Pull and return the array with all characters.
     * 
     * @return array the characters list
     */
    public static function getCharacters(): array
    {
        return static::$characters;
    }
    
    /**
     * Return the characters pattern for specific group type.
     * 
     * @param string $group passed specific group type
     * @return string the group characters
     */
    public static function getGroup(string $group): string
    {
        if (array_key_exists($group, static::$characters)) {
            return static::$characters[$group];
        }
    }
    
    /**
     * Change characters pattern for specific group.
     * 
     * @param string $group specific group
     * @param string $pattern new characters pattern
     * @return void
     */
    public static function setGroup(string $group, string $pattern)
    {
        if (array_key_exists($group, static::$characters)) {
            static::$characters[$group] = $pattern;
        }
    }
}
