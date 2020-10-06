<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Suggestionbox */

$this->title = 'Create Suggestionbox';
$this->params['breadcrumbs'][] = ['label' => 'Suggestionboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="suggestionbox-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
