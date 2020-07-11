<?php
namespace mallria\liquid;

use yii\web\Controller;

class LiquidController extends Controller{
    public $layout = false;
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $theme = 'default';
            \Yii::$app->view->theme = new \yii\base\Theme([
                'basePath' => '@app/web/themes/' . $theme . DIRECTORY_SEPARATOR,
                'pathMap' => ['@app/views' => '@app/web/themes/' . $theme . DIRECTORY_SEPARATOR],
                'baseUrl' => '@web/themes/'.$theme . DIRECTORY_SEPARATOR,
            ]);
            return true;
        } else {
            return false;
        }
    }
}