<?php
namespace mallria\liquid\traits;

use Liquid\Template;
use mallria\liquid\tags\CssTag;
use mallria\liquid\tags\FileTag;
use mallria\liquid\tags\JsTag;
use mallria\liquid\tags\TestTag;
use mallria\liquid\tags\UrlTag;

trait Templateable {

    /**
     * @var string $path
     */
    public $path;
    /**
     * @var string $cachePath
     */
    public $cachePath = '@runtime/Liquid/cache';
    /**
     * @var array $cache
     */
    public $cache;
    /**
     * @var Template $liquid_template
     */
    public $liquid_template;

    public function getArgs($string){
        $string = str_replace(' ', '&', $string);
        parse_str($string ,$args);
        return $args;
    }

    public function template($parse, $params){

        $this->path = \Yii::$app->getView()->theme->getBasePath();

        $this->cachePath = \Yii::getAlias($this->cachePath);
        if (!is_dir($this->cachePath)){
            mkdir($this->cachePath,0777, true);
        }

        $this->cache = array(
            'cache' => 'file',
            'cache_dir' => $this->cachePath,
        );

        $this->liquid_template = new Template($this->path, $this->cache);

        $this->liquid_template->registerTag('test',TestTag::class);
        $this->liquid_template->registerTag('url',UrlTag::class);
        $this->liquid_template->registerTag('file',FileTag::class);
        $this->liquid_template->registerTag('css',CssTag::class);
        $this->liquid_template->registerTag('js',JsTag::class);

        $this->liquid_template->parse($parse);
        return $this->liquid_template->render($params);
    }
}