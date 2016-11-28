<?php

namespace demo\browser;

//import composer autoload file
require_once dirname(__DIR__) . implode(DIRECTORY_SEPARATOR, ['.', '..', 'vendor', 'autoload.php']);

use PassGenerator\Generator;

/**
 * @author Lachezar Mihaylov <me@lacho-portfolio.com>
 * @license https://github.com/lmihaylov2512/pass-generator/blob/master/LICENSE.md MIT License
 */
class App
{
    /**
     * @var integer whether the app is in debug mode
     */
    const DEBUG_MODE = 0;
    
    /**
     * @var array options with title and description
     */
    protected static $options = [
        'upperCase' => [
            'title' => 'upper case',
            'desc' => 'use alphabet upper letters [A-Z]',
        ],
        'lowerCase' => [
            'title' => 'lower case',
            'desc' => 'use alphabet lower letters [a-z]',
        ],
        'digits' => [
            'title' => 'digits',
            'desc' => 'all numbers [0-9]',
        ],
        'special' => [
            'title' => 'special',
            'desc' => 'special symbols ~, !, @, #, ...'
        ],
        'brackets' => [
            'title' => 'brackets',
            'desc' => 'all kind of brackets (, ), {, }, [, ]',
        ],
        'minus' => [
            'title' => 'minus',
            'desc' => 'minus sign -',
        ],
        'underline' => [
            'title' => 'underline',
            'desc' => 'underline sign _',
        ],
        'space' => [
            'title' => 'space',
            'desc' => 'space character \' \'',
        ],
    ];
    /**
     * @var Generator password generator instance
     */
    protected static $generator;
    
    /**
     * Check whether the current request is ajax.
     * 
     * @return boolean the result from checking
     */
    public static function isAjaxRequest()
    {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
    
    /**
     * Return post variable, if exists, or specific default value.
     * 
     * @param mixed $default default value, if post doesn't exist
     * @return mixed
     */
    public static function getPost($default = null)
    {
        return isset($_POST) ? $_POST : $default;
    }
    
    /**
     * Get all options array.
     * 
     * @return array options array
     */
    public static function getOptions()
    {
        return static::$options;
    }
    
    /**
     * Create password generator, if necessary and return it.
     * 
     * @return Generator password generator instance
     */
    public static function getGenerator()
    {
        if (static::$generator === null) {
            static::$generator = new Generator();
        }
        return static::$generator;
    }
    
    /**
     * If is ajax request and post exists, generate password and cancel script execution.
     * 
     * @return string|null if is ajax request, returns the generated password
     */
    public static function run()
    {
        if (static::isAjaxRequest() && ($data = static::getPost()) !== null) {
            foreach ($data as $option => $value) {
                static::getGenerator()->$option = $value;
            }
            
            return static::getGenerator()->generate();
        }
    }
}

//run the app
if (($password = App::run()) !== null) {
    die($password);
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Demo password generator</title>
    <link href="./assets/bootstrap/css/<?= App::DEBUG_MODE ? 'bootstrap.css' : 'bootstrap.min.css' ?>" rel="stylesheet" />
    <style>.margin-top-20{margin-top:20px}.loader{border:4px solid #eee;border-top:4px solid #337ab7;border-radius:50%;width:32px;height:32px;animation:spin 2s linear infinite;display:inline-block;vertical-align:middle}@keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}</style>
</head>
<body>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="https://packagist.org/packages/lmihaylov/pass-generator" class="navbar-brand" target="_blank">Pass-Generator</a>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="input-group">
                                    <span class="input-group-addon">Password length</span>
                                    <input type="text" class="form-control" placeholder="Password length" value="<?= App::getGenerator()->length ?>" id="input-length">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" type="button" id="btn-generate">Generate</button>
                                    </span>
                                </div>
                                <div id="password-output" class="well lead hide margin-top-20"></div>
                                <div class="list-group margin-top-20">
                                    <?php foreach (App::getOptions() as $group => $option): ?>
                                    <a href="#" class="list-group-item<?= App::getGenerator()->$group ? ' active' : '' ?>" data-option="<?= $group ?>">
                                        <h4 class="list-group-item-heading"><span class="glyphicon glyphicon-<?= App::getGenerator()->$group ? 'ok' : 'remove' ?>" aria-hidden="true"></span> <?= $option['title'] ?></h4>
                                        <p class="list-group-item-text"><?= $option['desc'] ?></p>
                                    </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="./assets/jquery/<?= App::DEBUG_MODE ? 'jquery.js' : 'jquery.min.js' ?>"></script>
    <script>
        (function (w, d, $) {
            //attach click event handler on list elements
            $('.list-group > a').on('click', function (e) {
                e.preventDefault();
                var isActive = $(this).hasClass('active');
                
                if (isActive) {
                    $(this).toggleClass('active').find('span.glyphicon').removeClass('glyphicon-ok').addClass('glyphicon-remove');
                } else {
                    $(this).toggleClass('active').find('span.glyphicon').removeClass('glyphicon-remove').addClass('glyphicon-ok');
                }
            });

            //attach event handler on generate button for generating a new password string
            $('#btn-generate').on('click', function (e) {
                var data = { length: $('#input-length').val() };

                //prepare request data
                $('#password-output').html('<span class="loader"></span> Generating...').removeClass('hide');
                $('.list-group-item').each(function () {
                    data[$(this).data('option')] = $(this).hasClass('active') ? '1' : '';
                });
                
                $.ajax({
                    type: 'POST',
                    data: data,
                    success: function (res) {
                        $('#password-output').html(res === '' ? 'Please choose the at least one or more symbols types' : res);
                    }
                });
            });
        })(window, document, jQuery);
    </script>
</body>
</html>
