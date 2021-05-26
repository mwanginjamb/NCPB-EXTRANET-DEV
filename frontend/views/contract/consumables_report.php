<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 10:59 PM
 */



/* @var $this yii\web\View */

$this->title = 'Extranet -  Consumables Report';
$this->params['breadcrumbs'][] = ['label' => 'Cpntracts List', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Consumables Report', 'url' => ['#']];
?>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Consumables Reports</h3>

                </div>
                <div class="card-body">
                    
                       
                            <form method="post" class="form-inline" action="<?= Yii::$app->recruitment->absoluteUrl().'contract/consumables-report'?>">

                                 <div class="form-group row  mx-sm-3 mb-2">
                                        <?= \yii\helpers\Html::Input('date','balanceAtDate','',['class' => 'form-control','required' => true]) ?>
                                 </div>

                                 <div class="form-group row mx-sm-3 mb-2">

                                 <?= \yii\helpers\Html::dropDownList('itemNo',null,$items,['class' => 'form-control item','prompt' => 'Select Item ...']) ?>
                                 </div>

                                 <div class="form-group row mx-sm-3 mb-2">

                                 <?= \yii\helpers\Html::dropDownList('locationCode',null,$locations,['class' => 'form-control location','prompt' => 'Select Store ...']) ?>

                                </div>

                                <div class="form-group row mx-sm-3 mb-2">
                                <?= \yii\helpers\Html::submitButton('Generate Report',['class' => 'btn btn-primary']); ?>
                                </div>
                            </form>
                        
                    
                    <!--<iframe src="data:application/pdf;base64,<?/*= $content; */?>" height="950px" width="100%"></iframe>-->
                    <?php
                    if(isset($message)){
                        print '<p class="alert alert-info">'.$message.' . </p>';
                    }
                    if($report && !isset($message)){ ?>

                        <iframe src="data:application/pdf;base64,<?= $content; ?>" height="950px" width="100%"></iframe>
                   <?php } ?>



                </div>
            </div>
        </div>
    </div>

<?php
$script  = <<<JS
    $('.location, .item').select2();
JS;

$this->registerJs($script, yii\web\View::POS_READY);










