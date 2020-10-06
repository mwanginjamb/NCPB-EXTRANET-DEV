<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Suggestionbox */

$this->title = 'Update Suggestionbox: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suggestionboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View', 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = ['label' => 'Edit', 'url' => ['update', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="suggestionbox-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
