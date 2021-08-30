<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = Yii::$app->params['generalTitle'].' - Supplier Details'
?>
<h2 class="title">Supplier : <?= $model->Name ?></h2>

<?php


if(Yii::$app->session->hasFlash('success')){
    print ' <div class="alert alert-success alert-dismissable">
                 <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Success!</h5>
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}else if(Yii::$app->session->hasFlash('error')){
    print ' <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                    <h5><i class="icon fas fa-check"></i> Error!</h5>
                                 ';
    echo Yii::$app->session->getFlash('success');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(); ?>
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">General Details</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Blocked')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Qualified')->checkbox([$model->Qualified, 'Qualified']) ?>
                            <?= $form->field($model, 'Last_Date_Modified')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Balance_LCY')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Balance_Due_LCY')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Document_Sending_Profile')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Search_Name')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Purchaser_Code')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Responsibility_Center')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'Vendor_Type')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                            <?= $form->field($model, 'KRA_Pin_No')->textInput(['readonly' =>  true, 'diasbled' => true]) ?>
                           
                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Address</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">

                            <?= $form->field($model, 'Address')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Address_2')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Country_Region_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Phone_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'E_Mail')->textInput(['readonly' => true]) ?>
                            <?= $form->field($model, 'Home_Page')->dropDownList(['readonly'=> true, 'disabled'=>true]) ?>
                           



                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Procurement Details</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            



                        </div>
                        <div class="col-md-6">
                            

                        </div>
                    </div>
                </div>







            </div>
        </div>

       



        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Invoicing</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'VAT_Registration_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Prices_Including_VAT')->checkbox([$model->Prices_Including_VAT, 'Prices_Including_VAT']) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Payments</h3>


                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>


            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Payment_Terms_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Payment_Method_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Preferred_Bank_Account_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Receiving</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Location_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                           

                        </div>
                        <div class="col-md-6">
                           
                            <?= $form->field($model, 'Shipment_Method_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            


                        </div>
                    </div>
                </div>

            </div>
        </div>

        

        <?php ActiveForm::end(); ?>
    </div>
</div>
