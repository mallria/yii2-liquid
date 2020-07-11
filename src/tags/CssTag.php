<?php

namespace mallria\liquid\tags;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\Exception\ParseException;
use Liquid\FileSystem;
use Liquid\Liquid;
use Liquid\Regexp;

class CssTag extends FileTag
{
    public function __construct($markup, array &$tokens, FileSystem $fileSystem = null)
    {
        parent::__construct($markup,$tokens,$fileSystem);
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
        $file_path = parent::render($context);

        return '<link href="' . $file_path . '" rel="stylesheet">';

    }
}