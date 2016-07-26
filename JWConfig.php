<?php

/**
 * @package   yii2-jwplayer
 * @author    Wade Shuler
 * @copyright Copyright &copy; Wade Shuler 2016
 * @version   1.0.0
 */

namespace wadeshuler\jwplayer;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Object;

class JWConfig extends Object
{
    public $key;
    public $htmlTag = 'div';
    public $playerOptions = [];
    public $htmlOptions = [];

    public function init()
    {
        parent::init();

        if ( ! isset($this->key) ) {
            throw new InvalidConfigException('JWPlayer: License key missing!');
        }

    }
}
