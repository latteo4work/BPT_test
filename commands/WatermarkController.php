<?php
namespace app\commands;

use Service\Watermark;
use Yii;
use yii\console\Controller;
use yii\helpers\FileHelper;

/**
 * Class TestController
 * @package commands
 */
class WatermarkController extends Controller
{
    public function actionAddByMainColor()
    {
        $inputDirFileName = Yii::getAlias('@app/images/in/');
        $files = FileHelper::findFiles($inputDirFileName);

        $watermarkMap = [
            Watermark::COLOR_RED => Yii::getAlias('@app/images/watermark/black.jpg'),
            Watermark::COLOR_GREEN => Yii::getAlias('@app/images/watermark/red.jpg'),
            Watermark::COLOR_BLUE => Yii::getAlias('@app/images/watermark/yellow.jpg'),
        ];
        $watermark = new Watermark($watermarkMap);
        foreach ($files as $file) {
            $watermark->addByMainColor($file);
        }
    }
}
