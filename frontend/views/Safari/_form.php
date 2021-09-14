<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 12:13 PM
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$absoluteUrl = \yii\helpers\Url::home(true);






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
                                    <h5><i class="icon fas fa-times"></i> Error!</h5>
                                ';
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}

?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><?= Html::encode($this->title) ?></h3>
            </div>
            <div class="card-body">



        <?php

            $form = ActiveForm::begin([
                    // 'id' => $model->formName()
            ]); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-6">


                                <?= $form->field($model, 'Safari_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Purpose')->textarea(['rows'=> 2, 'maxlength'=> 200]) ?>
                                <?= $form->field($model, 'Expected_Travel_Date')->textInput(['type' => 'date','required' =>  true]) ?>
                                <?= $form->field($model, 'Expected_Date_of_Return')->textInput(['type'=> 'date', 'required'=> true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Imprest_Accoount')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Shortcut_Dimension_1_Code')->dropDownList([$functions,'prompt'=> 'Slect ...', 'required'=>true]) ?>

                        </div>

                        <div class="col-md-6">

                                <?= $form->field($model, 'Shortcut_Dimension_2_Code')->dropDownList($budgetCenters,['prompt'=> 'Select ...', 'required'=>true]) ?>
                                <?= $form->field($model, 'Total_Entitlements')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Mode_of_Transport')->dropDownList([
                                    'Personal_Vehicle' => 'Personal Vehicle',
                                    'Company_Vehicle' => 'Company Vehicle',
                                    'Public_Transport_1st_Class' => 'Public Transport 1st Class',
                                    'Public_Transport_Business' => 'Public Transport Business',
                                    'Public_Transport_Economy' => 'Public_Transport_Economy',

                                ],['prompt'=> 'Select ...', 'required'=>true]) ?>
                                <?= $form->field($model, 'Total_KMs')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Department_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Fleet_Request_No')->dropDownList( $fleet, ['prompt'=> 'Select ...', 'required'=>true]) ?>
                                <?= $form->field($model, 'Key')->hiddenInput(['readonly'=> true])->label(false) ?>


                        </div>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id' => 'submit']) ?>
                    </div>


                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>



    </div>
</div>



    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Safari Management</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>
<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
<?php
$script = <<<JS
 //Submit Rejection form and get results in json    
       /* $('form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });*/

        // Set Cover Type
        
     $('#leave-leave_code').change(function(e){
        const Leave_Code = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'leave/setleavetype';
            $.post(url,{'Leave_Code': Leave_Code,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   
                   $('#leave-leave_balance').val(msg.Leave_balance);
                   $('#medicalcover-key').val(msg.Key);
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-leave_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-leave_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });
     
     
     /*Set Start Date*/
     
      $('#leave-start_date').blur(function(e){
        const Start_Date = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'leave/setstartdate';
            $.post(url,{'Start_Date': Start_Date,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#medicalcover-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });

     
     /*Set Days to go on leave */
     
     $('#leave-days_to_go_on_leave').blur(function(e){
        const Days_To_Go_on_Leave = e.target.value;
        const No = $('#leave-application_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'leave/setdays';
            $.post(url,{'Days_To_Go_on_Leave': Days_To_Go_on_Leave,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                   
                    $('#leave-leave_balance').val(msg.Leave_balance);
                    $('#leave-end_date').val(msg.End_Date);
                    $('#leave-total_no_of_days').val(msg.Total_No_Of_Days);
                    $('#leave-reporting_date').val(msg.Reporting_Date);
                    $('#leave-holidays').val(msg.Holidays);
                    $('#leave-weekend_days').val(msg.Weekend_Days);
                    $('#leave-balance_after').val(msg.Balance_After);                    
                    $('#medicalcover-key').val(msg.Key);
                   
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-leave-days_to_go_on_leave');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                         disableSubmit();
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-leave-days_to_go_on_leave');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = '';
                        enableSubmit();
                        
                    }
                    
                },'json');
        }
     });
     
     
     /* set department */
     
     $('#imprestcard-global_dimension_2_code').change(function(e){
        const dimension = e.target.value;
        const No = $('#imprestcard-no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'imprest/setdimension?dimension=Global_Dimension_2_Code';
            $.post(url,{'dimension': dimension,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-imprestcard-global_dimension_2_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-imprestcard-global_dimension_2_code');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        
                    }
                    
                },'json');
        }
     });
     
     
     /*Set claim-safari_no*/
     
     $('#claim-safari_no').change(function(e){
        const Safari_No = e.target.value;
        const No = $('#claim-claim_no').val();
        if(No.length){
            const url = $('input[name=url]').val()+'claim/setfield?field=Safari_No';
            $.post(url,{'Safari_No': Safari_No,'No': No}).done(function(msg){
                   //populate empty form fields with new data
                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-claim-safari_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-claim-safari_no');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = '';
                        
                         /*$('.modal').modal('show')
                        .find('.modal-body')
                        .html('<div class="alert alert-success"> Update Successful.</div>'); */
                        
                    }

                    // Populate relevant Fields

                    $('#claim-global_dimension_1_code').val(msg.Global_Dimension_1_Code);
                    
                },'json');
        }
     });
     
     
     /* Add Line */
     $('.add-line').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
        function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
     
     
JS;

$this->registerJs($script);
