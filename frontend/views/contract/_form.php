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

            $form = ActiveForm::begin(); ?>
                <div class="row">
                    <div class="row col-md-12">



                        <div class="col-md-6">
                            <?= $form->field($model, 'Key')->textInput(['readonly'=> true]) ?>
                            <?= $form->field($model, 'Code')->textInput(['readonly'=> true]) ?>

                            <?= $form->field($model, 'Costing_Type')->dropDownlist(['Purchase' => 'Purchase','Sales' => 'Sales'],['prompt' => 'Select ...']) ?>
                            
                            <?= $form->field($model, 'Contract_Type')->dropDownlist($tenderTypes,['prompt'=> 'Select ...']) ?>

                             <?= $form->field($model, 'Quarter')->dropDownlist([
                                '_x0031_st_Quarter' => '1_st_Quarter',
                                '_x0032_nd_Quarter' => '2_nd_Quarter',
                                '_x0033_rd_Quarter' => '3_rd_Quarter',
                                '_x0034_th_Quarter' => '4_th_Quarter',
                            ],['prompt' => 'Select ...']) ?>
                          
                            <?= $form->field($model, 'Procurement_Method')->dropDownlist($procurementMethods,['prompt'=> 'Select ...']) ?>

                            <?= $form->field($model, 'Method_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                           
                            <?= $form->field($model, 'Type_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Reference_Code')->textInput(['maxlength'=> 50]) ?>

                            <?= $form->field($model, 'Description')->textarea(['rows'=> 2, 'maxlength'=> 250]) ?>

                            <?= $form->field($model, 'Total_Value')->textInput(['type'=> 'number']) ?>

                            <?= $form->field($model, 'Invoiced_Value')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Deliverables')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Contractor')->dropDownlist($contractors,['prompt'=> 'Select ...']) ?>

                            <?= $form->field($model, 'Contractor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                        </div>

                        <div class="col-md-6">
                            <?= $form->field($model, 'Comments')->textarea(['rows'=> 2, 'maxlength'=> 250]) ?>
                           
                            <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                            <?= $form->field($model, 'Global_Dimension_1_Code')->dropDownlist($function, ['prompt'=> 'Select ...']) ?>
                            <?= $form->field($model, 'Global_Dimension_2_Code')->dropDownlist($budgetCenter, ['prompt'=> 'Select ...']) ?>
                            <?= $form->field($model, 'Start_Date')->textInput(['type' => 'date','readonly'=> true,'disabled'=>true]) ?>
                            <?= $form->field($model, 'End_Date')->textInput(['type' => 'date','readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Notify_Period')->textInput(['maxlength' => 4, 'readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Monitoring_Department')->dropDownlist($HrDepartments, ['prompt' => 'Select ...']); ?>
                            <?= $form->field($model, 'Administration_Department')->dropDownlist($HrDepartments, ['prompt' => 'Select ...']) ?>
                            <?= $form->field($model, 'Notification_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Performance_Bond_Exp_Date')->textInput(['type' => 'date']) ?>
                            <?= $form->field($model, 'Performance_Bond_Notify_Period')->textInput(['maxlength' => 4]) ?>
                            <?= $form->field($model, 'Notify_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            <?= $form->field($model, 'Financial_Year')->textInput(['maxlength' => 10]) ?>
                            


                        </div>



                    </div>




                </div>












                <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success']) ?>
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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Imprest Management</h4>
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
<input type="hidden" name="absolute" value="<?= $absoluteUrl ?>">
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


         /* Set contract-costing_type */
         
         
         $('#contract-costing_type').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Costing_Type = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Costing_Type';
            $.post(url,{'Costing_Type': Costing_Type,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-costing_type');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-costing_type');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });

         /* Set contract_type */ 
         
         $('#contract-contract_type').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Contract_Type = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Contract_Type';
            $.post(url,{'Contract_Type': Contract_Type,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                    $('#contract-type_description').val(msg.Type_Description);

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-type_description');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-type_description');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });


        /* Set procurement_method */ 
         
         $('#contract-procurement_method').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Procurement_Method = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Procurement_Method';
            $.post(url,{'Procurement_Method': Procurement_Method,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                    $('#contract-method_description').val(msg.Method_Description);

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-procurement_method');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-procurement_method');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });


        /*Set Start Date*/
         
         $('#contract-start_date').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Start_Date = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Start_Date';
            $.post(url,{'Start_Date': Start_Date,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-start_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });


         /*Set End Date*/
         
         $('#contract-end_date').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const End_Date = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=End_Date';
            $.post(url,{'End_Date': End_Date,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-end_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-end_date');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });


        /*Set Notify Period*/
         
         $('#contract-notify_period').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Notify_Period = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Notify_Period';
            $.post(url,{'Notify_Period': Notify_Period,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                    $('#contract-notification_date').val(msg.Notification_Date);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-notify_period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-notify_period');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });

        // Commit Contrator

        $('#contract-contractor').on('change', function(e){
            e.preventDefault();
                  
            const Key = $('#contract-key').val();
            const Contractor = e.target.value;  
            
            const url = $('input[name="absolute"]').val()+'contract/setfield?field=Contractor';
            $.post(url,{'Contractor': Contractor,'Key': Key}).done(function(msg){

                   //populate empty form fields with new data
                    console.log(typeof msg);
                   
                    $('#contract-key').val(msg.Key);
                    $('#contract-contractor_name').val(msg.Contractor_Name);
                   

                    if((typeof msg) === 'string'){ // A string is an error
                        const parent = document.querySelector('.field-contract-contractor');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                        disableSubmit();
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-contract-contractor');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        enableSubmit();
                    }    
                    
                },'json');
        });
         
         function disableSubmit(){
             document.getElementById('submit').setAttribute("disabled", "true");
        }
        
        function enableSubmit(){
            document.getElementById('submit').removeAttribute("disabled");
        
        }
     
     
     /* Add Line */
     $('.add-line, .update-objective').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log(url);
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

        });
     
     /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
     
     
     
JS;

$this->registerJs($script);
