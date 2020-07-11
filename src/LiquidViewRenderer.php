<?php
namespace mallria\liquid;

use Liquid\Liquid;
use Liquid\StandardFilters;
use Liquid\Template;
use mallria\liquid\tags\FileTag;
use mallria\liquid\tags\TestTag;
use mallria\liquid\tags\UrlTag;
use yii\db\Exception;
use mallria\liquid\params\App;
use mallria\liquid\tags\CssTag;
use mallria\liquid\tags\JsTag;
use yii\web\View;
use \yii\base\ViewRenderer as BaseViewRenderer;

Liquid::set('INCLUDE_SUFFIX', 'liquid');
Liquid::set('INCLUDE_PREFIX', '');


class LiquidViewRenderer extends BaseViewRenderer {


    /**
     * @var Template $liquid_template
     */
    protected $liquid_template;


    public $path;
    /**
     * @var $cache array
     * $cache = array('cache' => 'apc');
     * $cache = array('cache' => 'file', 'cache_dir' => $protectedPath . 'cache' . DIRECTORY_SEPARATOR);
     */
    public $cache;

    public $cachePath = '@runtime/Liquid/cache';

    public function init()
    {
        parent::init();

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

    }

    /**
     * Renders a view file.
     *
     * This method is invoked by [[View]] whenever it tries to render a view.
     * Child classes must implement this method to render the given view file.
     *
     * @param \yii\base\View $view the view object used for rendering the file.
     * @param string $file the view file.
     * @param array $params the parameters to be passed to the view file.
     * @return string the rendering result
     * @throws Exception
     */
    public function render($view, $file, $params)
    {
        $this->liquid_template->registerTag('test',TestTag::class);
        $this->liquid_template->registerTag('url',UrlTag::class);
        $this->liquid_template->registerTag('file',FileTag::class);
        $this->liquid_template->registerTag('css',CssTag::class);
        $this->liquid_template->registerTag('js',JsTag::class);

        $params = array_merge($params,App::get());

        if (!is_file($file)){
            throw new Exception('Invalid view file: ' . $file);
        }

        $view_content = file_get_contents($file);

        $this->liquid_template->parse($view_content);

        return $this->liquid_template->render($params);
    }
}