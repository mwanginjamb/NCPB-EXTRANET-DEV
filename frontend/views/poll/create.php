<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Poll */

$this->title = 'Create Poll';
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Add Survey', 'url' => ['create']];
?>
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Add New Survey</h3>
    </div>
    <div class="card-body">
        <div class="poll-create">

            <!--<h1><?/*= Html::encode($this->title) */?></h1>-->

            <?= $this->render('_form', [
                'model' => $model,
            ]) ?>

        </div>
    </div>
</div>
