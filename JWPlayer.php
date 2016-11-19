<?php
namespace wadeshuler\jwplayer;

use Yii;
use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\View;

use wadeshuler\jwplayer\JWPlayerAsset;

class JWPlayer extends Widget
{
    public $key;
    public $htmlTag;

    private $_id;
    private $_key;
    private $_htmlTag;

    // Options defined directly in the widget
    public $htmlOptions = [];
    public $playerOptions = [];

    // Options merged, widget defined options override config options
    private $_htmlOptions = [];
    private $_playerOptions = [];

    private $_requiredOptions = ['file'];

    public function init()
    {
        parent::init();

        $this->_id = $this->getId();
        $this->_key = $this->getKey();
        $this->_htmlTag = $this->getHtmlTag();

        $this->_htmlOptions = $this->buildHtmlOptions();
        $this->_playerOptions = $this->buildPlayerOptions();

        $this->requiredCheck();
        $this->registerAssetBundle();
        $this->registerJs();
    }

    private function getHtmlTag()
    {
        if ( isset($this->htmlTag) ) {
            return $this->htmlTag;
        }

        return Yii::$app->jwplayer->htmlTag;
    }

    private function getKey()
    {
        if ( isset($this->key) ) {
            return $this->key;
        }

        return Yii::$app->jwplayer->key;
    }

    private function buildHtmlOptions()
    {
        $options = ArrayHelper::merge(Yii::$app->jwplayer->htmlOptions, $this->htmlOptions);
        $options['id'] = ArrayHelper::getValue($options, 'id', $this->_id);

        return $options;
    }

    private function buildPlayerOptions()
    {
        $options = ArrayHelper::merge(Yii::$app->jwplayer->playerOptions, $this->playerOptions);

        $options['width'] = ArrayHelper::getValue($options, 'width', '100%');
        $options['skin'] = ArrayHelper::getValue($options, 'skin', 'five');

        if ( ! isset($options['height']) && ! isset($options['aspectratio']) ) {
            $options['aspectratio'] = '16:9';
        }

        return $options;
    }

    private function requiredCheck()
    {
        foreach ($this->_requiredOptions as $key)
        {
            if ( ! ArrayHelper::keyExists($key, $this->_playerOptions, false) ) {
                if ( $key == 'file' ) {
                    if ( ! ArrayHelper::keyExists('sources', $this->_playerOptions, false ) ) {

                        throw new InvalidConfigException("JWPlayer Widget: player options missing '$key'");
                   
                    } else if ( empty( $this->_playerOptions['sources'] ) ) {

                        throw new InvalidConfigException("JWPlayer Widget: sources cannot be empty");
                    }
                } else {

                    throw new InvalidConfigException("JWPlayer Widget: player options missing '$key'");
                }
            }
        }
    }

    public function run()
    {
        echo Html::tag($this->_htmlTag, '', $this->_htmlOptions);
    }

    public function registerAssetBundle()
    {
        JWPlayerAsset::register($this->getView());
    }

    public function registerJs()
    {
        $this->getView()->registerJs("jwplayer.key='{$this->_key}';", View::POS_READY, 'jwplayer.key');
        $setup = ! empty($this->_playerOptions) ? Json::encode($this->_playerOptions) : '';
        $this->getView()->registerJs("jwplayer('{$this->_htmlOptions['id']}').setup({$setup});");
    }
}
