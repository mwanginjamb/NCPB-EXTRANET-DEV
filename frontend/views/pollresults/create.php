<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pollresults */

$this->title = 'Create Pollresults';
$this->params['breadcrumbs'][] = ['label' => 'Pollresults', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pollresults-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
