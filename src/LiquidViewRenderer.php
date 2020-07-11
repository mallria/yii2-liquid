<?php
namespace mallria\liquid;

use Liquid\Liquid;
use Liquid\StandardFilters;
use Liquid\Template;
use mallria\liquid\tags\FileTag;
use mallria\liquid\tags\TestTag;
use mallria\liquid\tags\UrlTag;
use mallria\liquid\traits\Templateable;
use yii\db\Exception;
use mallria\liquid\params\App;
use mallria\liquid\tags\CssTag;
use mallria\liquid\tags\JsTag;
use yii\web\View;
use \yii\base\ViewRenderer as BaseViewRenderer;

Liquid::set('INCLUDE_SUFFIX', 'liquid');
Liquid::set('INCLUDE_PREFIX', '');


class LiquidViewRenderer extends BaseViewRenderer {

    use Templateable;

    public function init()
    {
        parent::init();
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

        $params = array_merge($params,App::get());

        if (!is_file($file)){
            throw new Exception('Invalid view file: ' . $file);
        }

        $view_content = file_get_contents($file);

        return $this->template($view_content, $params);
    }
}