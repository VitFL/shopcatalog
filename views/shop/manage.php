<?php

/* @var $this yii\web\View */
/* @var $searchModel \app\models\ShopSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $search_params array|bool */

use app\models\Shop;
use kartik\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Shops Catalog';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Shops Catalog</h1>
    </div>
</div>

<div class="container">
    <?php \yii\widgets\Pjax::begin(['id' => 'shops_catalog','clientOptions' => ['method' => 'POST']]); ?>
    <?=// Generate a bootstrap responsive striped table with row highlighted on hover
     GridView::widget([
    'dataProvider'=> $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
     [
        'class' => '\kartik\grid\CheckboxColumn'
    ],
        'id',
        'shop_name',
        'shop_description',
        'shop_address',
        [
                'attribute' => 'business_hours',
            'label' => 'Business Hours',
            'format' => 'raw',
            'contentOptions'=>['style'=>'width: 200px;'],
            'value' => function ($model) {
                    $business_hours_table = "";
                for ($weekday=1;$weekday<=7;$weekday++)
                {
                    $businessHoursForWeekDay = isset($model->businessHoursForWeek[$weekday])?$model->businessHoursForWeek[$weekday]:false;
                    $business_hours_table .= "<div class=\"row\">";

                    $business_hours_table .="<div class=\"col-sm-3\">";
                    $business_hours_table .=Html::bsLabel(jddayofweek($weekday-1,2),$businessHoursForWeekDay?Html::TYPE_SUCCESS:Html::TYPE_DANGER);
                    $business_hours_table .="</div>";
                    $business_hours_table .="<div class=\"col-sm-6\">";
                    $business_hours_table .=$businessHoursForWeekDay?$businessHoursForWeekDay:"Closed";
                    $business_hours_table .="</div>";
                    $business_hours_table .= "</div>";

                }

                return $business_hours_table;


            },

        ],
        [
            'class' => '\kartik\grid\ActionColumn',
         //    'deleteOptions' => ['label' => '<i class="glyphicon glyphicon-remove"></i>']
        ]
    ],
    'responsive'=>true,
    'hover'=>true
    ]);?>
    <?php \yii\widgets\Pjax::end(); ?>
</div>

