<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\field\FieldRange;
use kartik\checkbox\CheckboxX;


/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $modelBusinessHourss app\models\BusinessHours */
/* @var $form kartik\widgets\ActiveForm */
/* @var $modelsBusinessHours  */
?>

<div class="shop-form">
    <?php $form = ActiveForm::begin([
        'id' => 'shop-form',
    ]); ?>

    <?= $form->field($model, 'shop_name')->textInput(['maxlength' => true]) ?>



    <h3>Business Hours:</h3>

   <?php
    foreach ($modelsBusinessHours as $weekday => $modelBusinessHours)
    {

        echo '<div class="row"><div class="col-sm-4">';
       if (!$modelBusinessHours->isNewRecord) {
           echo Html::activeHiddenInput($modelBusinessHours, "[{$weekday}]id",['id'=>'id'.$weekday,'disabled' => $modelBusinessHours->isNewRecord]);
       }
        echo  $form->field($modelBusinessHours, "[{$weekday}]weekday")->hiddenInput(['id' => 'weekday_'.$weekday,'value' => $weekday, 'disabled' =>  $modelBusinessHours->isNewRecord])->label(false);
        echo CheckboxX::widget([
            'name'=>'weekday_checkbox',
            'value' => $modelBusinessHours->isNewRecord?0:1,
            'labelSettings' => [
                'label' =>  jddayofweek($weekday,1),
                'position' => CheckboxX::LABEL_RIGHT
            ],
        'options'=>['weekday'=>$weekday],
        'pluginOptions'=>['threeState'=>false],
         ]);

        echo FieldRange::widget([
                'form' => $form,
                'model' => $modelBusinessHours,
                'options'=>['id'=>'time_range_div'.$weekday],
                //'label' => 'Enter time range',
                'widgetOptions1' => [
                    'disabled'=> $modelBusinessHours->isNewRecord,
                    'pluginOptions'=> ['showMeridian' => false, 'defaultTime'=>'00:00', //'showSeconds' => true,
    ]
                ],
                'widgetOptions2' => [
                    'disabled'=> $modelBusinessHours->isNewRecord,
                    'pluginOptions'=> ['showMeridian' => false, 'defaultTime'=>'00:00', //'showSeconds' => true,
                    ]
                ],
                'attribute1' => "[{$weekday}]start_hour",
                'attribute2' => "[{$weekday}]close_hour",
                'type' => FieldRange::INPUT_TIME,
            ]);

        echo '</div></div>';
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$this->registerJs( <<< EOT_JS_CODE

$('[name="weekday_checkbox"]').on('change', function() { 
              
               if ($(this).val() == 1)
               {
                 $("#time_range_div"+$(this).attr("weekday")).find("span").attr("class", "input-group-addon picker");
                 $("#time_range_div"+$(this).attr("weekday")).find("#businesshours-"+$(this).attr("weekday")+"-start_hour").attr("disabled", false);
                 $("#time_range_div"+$(this).attr("weekday")).find("#businesshours-"+$(this).attr("weekday")+"-close_hour").attr("disabled", false);
                 $("#weekday_"+$(this).attr("weekday")).prop('disabled', false);
                    $("#id"+$(this).attr("weekday")).prop('disabled', false);
               }
               else
               {
                $("#time_range_div"+$(this).attr("weekday")).find("span").attr("class", "disabled-addon input-group-addon picker");
                $("#time_range_div"+$(this).attr("weekday")).find("#businesshours-"+$(this).attr("weekday")+"-start_hour").attr("disabled", true);
                $("#time_range_div"+$(this).attr("weekday")).find("#businesshours-"+$(this).attr("weekday")+"-close_hour").attr("disabled", true);
                $("#weekday_"+$(this).attr("weekday")).prop('disabled', true);
                $("#id"+$(this).attr("weekday")).prop('disabled', true);
               }
             });

EOT_JS_CODE
);
?>