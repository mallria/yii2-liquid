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
                'mongodb_profiling' => self::getMongodbProfilng(),
            ),
        ];
    }

    private static function getMongodbProfilng(){
        $timings = \Yii::getLogger()->getProfiling(['yii\mongodb\Command::query', 'yii\mongodb\Command::execute']);
        $count = count($timings);
        $time = 0;
        foreach ($timings as $timing) {
            $time += $timing['duration'];
        }
        return [$count, $time];
    }
}