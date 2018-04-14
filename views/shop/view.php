<?php
use kartik\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Shop */

$this->title = $model->shop_name;
$this->params['breadcrumbs'][] = ['label' => 'Manage Shops', 'url' => ['manage']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="shop-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Shop information</h3>
        </div>
        <div class="panel-body">

            <p align="justify">Address: <?=Html::a($model->shop_address,"https://www.google.com/maps/search/".urlencode($model->shop_address))?></p>
            <div class="row">
                <div class="col-sm-6">
                    <p align="justify"><?=$model->shop_description?></p>
                </div>
            </div>

            <?php for ($i=1;$i<=7;$i++) : ?>
                <div class="row">
                    <div class="col-sm-2">
                        <span><?=jddayofweek($i-1,1).":"?> </span>
                    </div>
                    <div class="col-sm-3">
                        <span><?=isset($model->getBusinessHoursForWeek()[$i])?$model->getBusinessHoursForWeek()[$i]:"Closed";?> </span>
                    </div>


                </div>
            <?php endfor;?>
        </div>
    </div>



</div>
