<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Pollresults */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pollresults-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'poll_id')->textInput() ?>

    <?= $form->field($model, 'poll_choice_id')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
