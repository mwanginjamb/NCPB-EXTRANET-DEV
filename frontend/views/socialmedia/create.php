<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Socialmedia */

$this->title = 'Create Socialmedia';
$this->params['breadcrumbs'][] = ['label' => 'Socialmedia', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socialmedia-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
