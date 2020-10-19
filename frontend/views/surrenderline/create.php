<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:29 PM
 */

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Imprest  Surrender Line Request';
$this->params['breadcrumbs'][] = ['label' => 'Imprest Line', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$model->isNewRecord = true;
// Yii::$app->recruitment->printrr($glAccounts);
?>
<div class="leave-document-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
        'functions' => $functions,
        'glAccounts' => $glAccounts,
        'budgetCenters' => $budgetCenters,
        'locations' => $locations,
        'currencies' => $currencies,
    ]) ?>

</div>
