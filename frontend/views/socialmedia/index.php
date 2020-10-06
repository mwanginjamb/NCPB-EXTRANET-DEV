<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SocialmediaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Socialmedia';
$this->params['breadcrumbs'][] = ['label' => 'Socialmedia', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socialmedia-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Socialmedia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'subject',
            'post:ntext',
            'created_at',
            'updated_at',
            //'created_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>


</div>
