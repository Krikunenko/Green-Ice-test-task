<?php

namespace app\controllers;

use yii\web\Controller;
use yii\data\ArrayDataProvider;
use app\models\CitiesModel;

class TestController extends Controller
{

    public function actionIndex($city = null)
    {
        $citiesModel = new CitiesModel();

        if (empty($city)) {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $citiesModel->getCities(),
                'sort' => [
                    'attributes' => ['area'],
                    'defaultOrder' => [
                        'area' => SORT_ASC
                    ]
                ],
            ]);

            $columns = [
                'area',
                'latitude',
                'longitude'
            ];
        } else {
            $dataProvider = new ArrayDataProvider([
                'allModels' => $citiesModel->getCitiesWithDistance($city),
                'sort' => [
                    'attributes' => ['distance'],
                    'defaultOrder' => [
                        'distance' => SORT_ASC
                    ]
                ],
            ]);

            $columns = [
                'area',
                [
                    'attribute' => 'distance',
                    'label' => 'Distance (km)'
                ]
            ];
        }

        return $this->render('index', [
            'selectedCity' => $city,
            'citiesList' => $citiesModel->getCitiesList(),
            'dataProvider' => $dataProvider,
            'columns' => $columns,
        ]);
    }

}