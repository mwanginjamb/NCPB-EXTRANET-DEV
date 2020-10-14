<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:41 AM
 */




use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = 'AAS - Employee Profile'
?>
<h2 class="title">Employee : <?= $model->No.' - '. $model->First_Name. ' '. $model->Last_Name?></h2>

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
        <?php $form = ActiveForm::begin(['action'=> ['leave/create']]); ?>
        <div class="card card-success collapsed-card">
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
                            <?= $form->field($model, 'Title')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'First_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Middle_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Last_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Initials')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'National_ID_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Gender')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Nationality')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Place_of_Birth')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Religion')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Marital_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Ethnic_Group')->dropDownList([$ethnicity,['readonly' =>  true, 'diasbled' => true]]) ?>
                            <?= $form->field($model, 'Supervisor_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Supervisor_User_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'HOD_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'HOD_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Employee_is_Supervisor')->checkbox([$model->Employee_is_Supervisor,'Employee_is_Supervisor',['readonly' =>  true]]) ?>
                            <?= $form->field($model, 'Employee_is_HR')->checkbox([$model->Employee_is_HR,'Employee_is_HR',['readonly' =>  true]]) ?>
                            <?= $form->field($model, 'Employee_is_HOD')->checkbox([$model->Employee_is_HOD,'Employee_is_HOD',['readonly' =>  true]]) ?>
                            <?= $form->field($model, 'Is_Training_Manager')->checkbox([$model->Is_Training_Manager,'Is_Training_Manager',['readonly' =>  true]]) ?>
                            <?= '<p><span>Disciplinary Cases</span> '.Html::a($model->Disciplinary_Cases,'#'); '</p>'?>



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

                            <?= $form->field($model, 'Line_1')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Line_2')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Post_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'City')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Station_Region')->dropDownList($regions, ['readonly' => true]) ?>
                            <?= $form->field($model, 'Current_Station')->dropDownList($stations,['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Custom_County')->dropDownList($counties,['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Sub_County')->dropDownList([$subCounties,'readonly'=> true, 'disabled'=>true]) ?>




                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Communication</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Extension')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Mobile_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Phone_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'E_Mail')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Office_E_Mail')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>







            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Important Dates</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Employment_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Current_Experience')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_of_Experience_Starts')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Total_Experience')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_of_Birth')->textInput(['readonly'=> true, 'disabled'=>true]) ?>



                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Age')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Medical_Aid_Join')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Time_on_Medical_Aid_Scheme')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Retirement_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Service_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>







            </div>
        </div>



        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Contract</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>

            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Job_Position')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Position_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'Contract_Duration')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Payment Details</h3>


                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>


            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Contract_Permanent')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Employee_Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= '<p><span>Employee Dimension</span> '.Html::a($model->Employee_Dimension,'#'); '</p>'?>
                            <?= $form->field($model, 'Imprest_Account')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Job_Group')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Cost_Center_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'New_Band_Effective_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Position')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Job_Position_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Currency')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Effective_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="card card-success collapsed-card collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Separation Details</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">

                <div class="row">
                    <div class=" row col-md-12">
                        <div class="col-md-6">
                            <?= $form->field($model, 'Termination_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <p><b>Separation/ Termination / Death/ </b></p>
                            <?= $form->field($model, 'Reason_for_Seperation')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Notice_Period_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Notice_Period_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Date_of_Leaving_the_Company')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>
                        <div class="col-md-6">
                            <p><b>Pensioner </b></p>
                            <?= $form->field($model, 'Pension_Scheme_Join')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Time_on_Pension_Scheme')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
