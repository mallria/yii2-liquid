<?php
namespace mallria\liquid\tags;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\FileSystem;
use Liquid\Liquid;
use Liquid\Regexp;
use mallria\liquid\traits\Templateable;
use yii\helpers\Url;

class UrlTag extends AbstractTag{

    use Templateable;

    public $markup;

    public $route = [];

    public $args = [];

    public function __construct($markup, array &$tokens, FileSystem $fileSystem = null)
    {
        parent::__construct($markup, $tokens, $fileSystem);

        $this->markup = trim($markup);


    }
    /**
     * Render the tag with the given context.
     *
     * @param Context $context
     *
     * @return string
     */
    public function render(Context $context)
    {
        $regex = new Regexp('/"(.*?)"\s([\s\S]*)?/');

        if ($regex->match($this->markup) && isset($regex->matches[1])) {
            $this->route = $regex->matches[1];
        }
        if (isset($regex->matches[2])){
            $this->args = $this->getArgs($regex->matches[2]);
        }else{
            $this->args = [];
        }

        if (empty($regex->matches)){
            $this->route = $context->get($this->markup);
        }

        if (is_array($this->route)){
            return Url::to(array_merge($this->route,$this->args));
        }else{
            return Url::to(array_merge([$this->route],$this->args));
        }
    }
}