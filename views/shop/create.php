<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $businessHoursModels app\models\BusinessHours */
/* @var $modelShop \app\models\Shop */
/* @var $modelsBusinessHours array */

$this->title = 'Create Shop';
$this->params['breadcrumbs'][] = ['label' => 'Manage Shops', 'url' => ['manage']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="shop-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $modelShop,
        'modelsBusinessHours' => $modelsBusinessHours,
    ]) ?>

</div>
