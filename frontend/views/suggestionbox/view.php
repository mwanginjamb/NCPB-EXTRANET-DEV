<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Suggestionbox */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Suggestionboxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Suggestion', 'url' => ['view','id'=>$this->title]];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="suggestionbox-view">

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

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'subject',
            'suggestion_body:ntext',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
