<?php

namespace mallria\liquid\tags;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\FileSystem;

class JsTag extends FileTag
{
    public function __construct($markup, array &$tokens, FileSystem $fileSystem = null)
    {
        parent::__construct($markup,$tokens,$fileSystem);
    }

    public function render(Context $context)
    {

        $file_path = parent::render($context);

        return '<script src="'. $file_path . '"></script>';

    }
}