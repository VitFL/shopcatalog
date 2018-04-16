<?php
use kartik\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<div class="col-md-5">
    <h3><?= Html::encode($model['shop_name']); ?></h3>
    <div class="row">
        <div class="col-sm-4">
            <?=Html::bsLabel("Open ".(($search_params['date'])?$search_params['date']:"Today"),Html::TYPE_SUCCESS);?>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-4">
            <?=$model->businessHoursForWeek[($search_params['dayofweek'])?$search_params['dayofweek']:$model->todayWeekDay]?>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <p align="justify"><?=$model->shop_description; ?></p>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12">
            <p align="justify"><?=$model->shop_address; ?></p>
        </div>

    </div>

    <div class="row">
    <div class="col-sm-4"><?= Html::a(Yii::t('app', 'more info...'), ['view', 'id' =>$model->id], ['class' => 'btn btn-default']) ?></div>

</div>
</div>
