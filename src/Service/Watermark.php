<?php

namespace Service;

use ColorThief\ColorThief;
use http\Exception\RuntimeException;
use Yii;


class Watermark {

    const COLOR_RED = 0;
    const COLOR_GREEN = 1;
    const COLOR_BLUE = 2;

    /**
     * @var array
     */
    private $watermarkMap;

    public function __construct(array $watermarkMap)
    {
        $this->watermarkMap = $watermarkMap;
    }

    public function addByMainColor($path)
    {
        $colorKey = $this->getMainColor($path);
        $watermark = $this->getWatermark($colorKey);

        $image = $this->getImageClass()->load($path);
        $image->watermark($watermark, $offset_x = NULL, $offset_y = NULL, $opacity = 30);
        $image->save();
    }


    public function getMainColor($path)
    {
        $mainColor = ColorThief::getColor($path);

        return $this->RGBColor($mainColor);
    }

    private function RGBColor(array $mainColor)
    {
        return array_search(max($mainColor), $mainColor);
    }

    private function getWatermark($colorKey)
    {
        return $this->getImageClass()->load($this->mapToPath($colorKey));
    }

    private function mapToPath($colorKey)
    {
        if (false === isset($this->watermarkMap[$colorKey])) {
            throw new RuntimeException('Please correct map color to watermark');
        }

        return $this->watermarkMap[$colorKey];
    }

    private function getImageClass(): yii\image\ImageDriver
    {
        return Yii::$app->image;
    }
}