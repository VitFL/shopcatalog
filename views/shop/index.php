<?php

/* @var $this yii\web\View */
/* @var $searchModel \app\models\ShopSearch */
/* @var $dataProvider \yii\data\ActiveDataProvider */
/* @var $search_params array|bool */

use app\models\Shop;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\TimePicker;
use yii\widgets\ListView;
use yii\data\ActiveDataProvider;


$this->title = 'Shops Catalog';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Shops Catalog</h1>
    </div>


</div>

    <div class="container">
        <?php $form = ActiveForm::begin(['method' => 'post']); ?>

        <div class="row justify-content-center">
            <div class="col-sm-5">
                <?= $form->field($searchModel, 'shop_name', [

                    'addon' => [
                        'append' => [
                            'content' => Html::submitButton('Go', ['class'=>'btn btn-primary']),
                            'asButton' => true
                        ]
                    ]
                ])->label('Search'); ?>

            </div>
            <div class="col-sm-3">
               <?php
               echo '<label class="control-label">Date Filter</label>';

               echo $form->field($searchModel,'date_picker')->widget(DatePicker::classname(),[
                   'type' => DatePicker::TYPE_COMPONENT_PREPEND,
                   'name' => 'date_picker',
               //    'options' => ['value' => date("d-n-Y")],
                   'pluginOptions' => [
                       'autoclose'=>true,
                       'format' => 'dd-m-yyyy',
                   ]
               ])->label(false);
               ?>
            </div>
            <div class="col-sm-2">
            <?php

            echo '<label class="control-label">Time Filter</label>';
            echo $form->field($searchModel,'time_picker')->widget(TimePicker::classname(),[
                'name' => 'time_picker',
                'pluginOptions' => [
                   // 'showSeconds' => true,
                    'showMeridian' => false,
                    'minuteStep' => 10,
                    'defaultTime' => false,
                ]
            ])->label(false);
            ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>


        <?= ListView::widget([
            'dataProvider' => $dataProvider,
            'itemView' => function ($model, $key, $index, $widget) use ($search_params) {
                return $this->render('_list_item',['model' => $model,'search_params'=>$search_params]);
 },
            'itemOptions' => ['tag' => false],
            'layout' => "<div>{summary}</div>\n<div class=\"row justify-content-center\">{items}</div>\n<div>{pager}</div>",
            'summary' => "Found {totalCount} shops for you ".
                (($search_params['date'])?"that are open ".$search_params['date']:"").
                (($search_params['time'])?" at ".$search_params['time']:""),
            'summaryOptions' => [
                'tag' => 'span',
                'class' => 'my-summary'
            ],



            'emptyText' => '<p>No results</p>',
            'emptyTextOptions' => [
                'tag' => 'p'
            ],

            'pager' => [
                'nextPageLabel' => Html::icon('glyphicon glyphicon-chevron-right'),
                'prevPageLabel' => Html::icon('glyphicon glyphicon-chevron-left'),
                'maxButtonCount' => 5,
            ],
        ]);?>
            </div>

    </div>

