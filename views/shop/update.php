<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */
/* @var $modelShop \app\models\Shop */
/* @var $modelsBusinessHours array */

$this->title = 'Update Shop: '.$modelShop->shop_name;
$this->params['breadcrumbs'][] = ['label' => 'Shops', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $modelShop->shop_name, 'url' => ['view', 'id' => $modelShop->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="shop-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $modelShop,
        'modelsBusinessHours' => $modelsBusinessHours,
    ]) ?>
</div>
