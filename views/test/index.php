<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\grid\GridView;

?>

<div class="row">
    <?php ActiveForm::begin([
        'action' => ['test/index'],
        'method' => 'get'
    ]); ?>

    <div class="col-md-4">
        <div class="form-group">
            <?php echo Html::dropDownList('city', $selectedCity, $citiesList, ['prompt' => '', 'class' => 'form-control']); ?>
        </div>
        <?php echo Html::submitButton('Search', ['class' => 'btn btn-success']); ?>
        <?php echo Html::a('Reset', ['test/index'], ['class' => 'btn btn-danger']); ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>

<br>

<?php echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
]); ?>