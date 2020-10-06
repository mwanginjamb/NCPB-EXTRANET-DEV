<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Pollchoice */

$this->title = 'Create Pollchoice';
$this->params['breadcrumbs'][] = ['label' => 'Pollchoices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


   <div class="card">
       <div class="card-header">
           <h3 class="card-title"><?= 'Poll Choice for: '.$pollmodel->poll_body ?></h3>
       </div>
   </div>
           <?= $this->render('_form', [
               'model' => $model,

           ]) ?>






