<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:31 PM
 */


use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\AgendaDocument */

$this->title = 'Update Contract Document.';
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Update Contract', 'url' => ['update','Key' => $model->Key]];

?>
<div class="agenda-document-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form',[
        'model' => $model,
        'tenderTypes' => $tenderTypes,
        'procurementMethods' => $procurementMethods,
        'contractors' => $contractors,
        'function' => $function,
        'budgetCenter' => $budgetCenter,
        'HrDepartments' => $HrDepartments
    ]) ?>

</div>
