<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Socialmedia */

$this->title = 'Update Socialmedia: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socialmedia', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'View Post', 'url' => ['update', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = 'Update';
?>
<div class="socialmedia-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
