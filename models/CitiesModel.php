<?php

namespace app\models;

use Yii;
use yii\base\Model;

class CitiesModel extends Model
{

    public $areas;

    public function init()
    {
        $this->areas = include Yii::getAlias('@webroot') . '/areas.php';
        parent::init();
    }

    public function getCitiesList()
    {
        $citiesList = array_combine(array_keys($this->areas), array_keys($this->areas));
        ksort($citiesList);

        return $citiesList;
    }

    public function getCities()
    {
        $result = [];

        foreach ($this->areas as $key => $value) {
            $result[] = [
                'area' => $key,
                'latitude' => $value['lat'],
                'longitude' => $value['long']
            ];
        }

        return $result;
    }

    public function getCitiesWithDistance($city)
    {
        $selectedArea = $this->areas[$city];
        if (empty($selectedArea)) {
            return [];
        }
        $result = [];

        foreach ($this->areas as $key => $value) {
            if ($key == $city) {
                continue;
            }

            $result[] = [
                'area' => $key,
                'distance' => $this->calculateDistance($selectedArea['lat'], $selectedArea['long'], $value['lat'], $value['long'])
            ];
        }

        return $result;
    }

    protected function calculateDistance($lat1 = 0, $lng1 = 0, $lat2 = 0, $lng2 = 0)
    {
        $pi80 = M_PI / 180;
        $lat1 *= $pi80;
        $lng1 *= $pi80;
        $lat2 *= $pi80;
        $lng2 *= $pi80;

        $r = 6372.797; // mean radius of Earth in km
        $dlat = $lat2 - $lat1;
        $dlng = $lng2 - $lng1;
        $a = sin($dlat / 2) * sin($dlat / 2) + cos($lat1) * cos($lat2) * sin($dlng / 2) * sin($dlng / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $km = $r * $c;

        return $km;
    }

}