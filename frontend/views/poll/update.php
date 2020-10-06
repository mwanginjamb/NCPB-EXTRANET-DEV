<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Poll */

$this->title = 'Update Poll: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Polls', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View Survey', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Update Survey', 'url' => ['update', 'id' => $model->id]];
?>
<div class="poll-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
