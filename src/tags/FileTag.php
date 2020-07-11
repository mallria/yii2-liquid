<?php
namespace mallria\liquid\tags;

use Liquid\AbstractTag;
use Liquid\Context;
use Liquid\Exception\ParseException;
use Liquid\FileSystem;
use Liquid\Regexp;

class FileTag extends AbstractTag
{

    public $file;

    public function __construct($markup, array &$tokens, FileSystem $fileSystem = null)
    {

        $regex = new Regexp('/("[^"]+"|\'[^\']+\')?/');

        if ($regex->match($markup) && isset($regex->matches[1])) {
            $this->file = substr($regex->matches[1], 1, strlen($regex->matches[1]) - 2);
        }

        parent::__construct($markup, $tokens, $fileSystem);
    }

    /**
     * Render the tag with the given context.
     *
     * @param Context $context
     *
     * @return string
     *
     */
    public function render(Context $context)
    {

        $theme = \Yii::$app->theme;
        if (empty($theme)) {
            $theme = 'basic';
        }

        if (substr($this->file, '0', '1') === '/') {
            $this->file = '/themes/' . $theme . $this->file;
        } else {
            $this->file = '/themes/' . $theme . '/' . $this->file;
        }

        $file_path = \Yii::getAlias('@app/web') . $this->file;
        if (is_file($file_path)) {
            $this->file .= '?v=' . filemtime($file_path);
        }

        return $this->file;
    }
}