<?php
namespace mallria\liquid\params;

use mallria\liquid\interfaces\IParam;

class App implements IParam {

    public static function get(){

        return [
            'app' => array(
                'language' => \Yii::$app->language,
                'charset' => \Yii::$app->charset,
                'theme' => \Yii::$app->theme,
                'csrf' => array(
                    'param' => \Yii::$app->getRequest()->csrfParam,
                    'token' => \Yii::$app->getRequest()->csrfToken,
                ),
                'elapsed_time' => \Yii::getLogger()->getElapsedTime(),
                'db_profiling' => \Yii::getLogger()->getDbProfiling(),
            ),
        ];
    }
}