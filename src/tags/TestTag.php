<?php
namespace mallria\liquid\tags;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\FileSystem;
use Liquid\Template;
use mallria\liquid\traits\Templateable;

class TestTag extends AbstractTag{

    use Templateable;

    public $markup;

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
        $params = $this->getArgs($this->markup);

        return $this->template(
            "{{a}} {{b}}",
            $params);
    }
}