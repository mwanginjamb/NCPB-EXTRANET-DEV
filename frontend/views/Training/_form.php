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


                                <?= $form->field($model, 'Request_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Training_Area')->dropDownList($tAreas,['prompt'=>'Select ...']) ?>
                                <?= $form->field($model, 'Training_Program')->textInput(['type' => 'text','readonly' =>  true]) ?>
                                <?= $form->field($model, 'Description')->textInput(['required'=> true]) ?>
                                <?= $form->field($model, 'Start_Date')->textInput(['type'=> 'date']) ?>
                                <?= $form->field($model, 'End_Date')->textInput(['type'=> 'date']) ?>
                                <?= $form->field($model, 'Institute_Name')->textInput() ?>
                                <?= $form->field($model, 'Training_Objectives')->textarea(['rows'=> 2]) ?>
                                <?= $form->field($model, 'Training_Type')->dropDownList([
                                    '_blank_'=> '_blank_',
                                    'Corporate' => 'Corporate',
                                    'Department' => 'Department',
                                    'Individual' => 'Individual'
                                    ],['prompt' => 'Select ...']) ?>
                                <?= $form->field($model, 'Trainer_Type')->dropDownList(
                                    [
                                        '_blank' => '_blank',
                                        'Internal' => 'Internal',
                                        'External' => 'External',

                                    ],
                                    ['prompt' => 'Select ...']) ?>

                        </div>

                        <div class="col-md-6">

                                <?= $form->field($model, 'Trainer_Code')->dropDownList($employees,['prompt'=> 'Select ...', 'required'=>true]) ?>
                                <?= $form->field($model, 'Trainer_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Total_Cost')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Shortcut_Dimension_1_Code')->dropDownList($functions,['prompt'=> 'Select ...']) ?>
                                <?= $form->field($model, 'Shortcut_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Annual_Budget')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Available_Budget')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               
                                <?= $form->field($model, 'Commitment')->textInput( ['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Budget_to_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Budget_G_L')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Key')->textInput(['readonly'=> true]) ?>


                        </div>



                    </div>




                </div>












               <!-- <div class="row">

                    <div class="form-group">
                        <?= Html::submitButton(($model->isNewRecord)?'Save':'Update', ['class' => 'btn btn-success','id' => 'submit']) ?>
                    </div>


                </div>-->
                <?php ActiveForm::end(); ?>
            </div>
        </div>

        
            <!--Objectives card -->

            <?php // Yii::$app->recruitment->printrr($model->getLines($model->Application_No)) ?>



            <div class="card card-success">
                <div class="card-header">
                    <div class="card-title">   <?= ($model->Status == 'New')? Html::a('<i class="fa fa-plus-square"></i> New Line',['traininglines/create','No'=>$model->Request_No],['class' => 'add-objective btn btn-outline-warning']):'' ?></div>
                </div>



                <div class="card-body">





                    <?php
                    if(property_exists($header->Training_Request_Line,'Training_Request_Line')){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Employee No</b></td>
                                
                                <td><b>Employee Name</b></td>
                                <td><b>Employee ID</b></td>
                                <td><b>Attending</b></td>
                                <td><b>Actions</b></td>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($header->Training_Request_Line->Training_Request_Line as $obj):
                               
                                $attending = ($obj->Attending)?'Yes':'No';
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['traininglines/update',
                                    'Key'=> $obj->Key
                                ],
                                ['class' => 'update-objective btn btn-outline-info btn-xs','title' => 'update line']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['traininglines/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Employee_No)?$obj->Employee_No:'Not Set' ?></td>
                                    <td><?= !empty($obj->Employee_Name)?$obj->Employee_Name:'Not Set' ?></td>
                                    <td><?= !empty($obj->Employee_ID)?$obj->Employee_ID:'Not Set' ?></td>
                                    <td><?= $attending ?></td>
                                    
                                    

                                    <td><?= ($header->Status == 'New')?$updateLink.'|'.$deleteLink:'' ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <!--objectives card -->



    </div>
</div>



    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Training Management</h4>
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

    /*Deleting Records*/
     
    $('.delete, .delete-objective').on('click',function(e){
         e.preventDefault();
           var secondThought = confirm("Are you sure you want to delete this record ?");
           if(!secondThought){//if user says no, kill code execution
                return;
           }
           
         var url = $(this).attr('href');
         $.get(url).done(function(msg){
             $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
         },'json');
     });

       //Add a training plan
    
       $('.add-objective, .update-objective').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
        
     
     /*Set training Area*/
     
     $('#training-training_area').change(function(e){
        updateField('Training','Training_Area', e);
     });

     $('#training-description').change(function(e){
        updateField('Training','Description', e);
     });

     // Set Start date

     $('#training-start_date').change(function(e){
        updateField('Training','Start_Date', e);
     });


     // set end date

     $('#training-end_date').change(function(e){
        updateField('Training','End_Date', e);
     });
     
     // Set Institution Name

     $('#training-institute_name').change(function(e){
        updateField('Training','Institute_Name', e);
     });

     // Update Training Objectives

     $('#training-training_objectives').change((e) => {
         updateField('Training','Training_Objectives', e);
     });

     // Update Training Type
     
     $('#training-training_type').change((e) => {
        updateField('Training','Training_Type', e);
     });

     // Update Trainer Type
     
     $('#training-trainer_type').change((e) => {
        updateField('Training','Trainer_Type', e);
     });

     // Update Trainer Code

     $('#training-trainer_code').change((e) => {
        updateField('Training','Trainer_Code', e);
     });


     function updateField(entity,fieldName, ev) {
                const model = entity.toLowerCase();
                const field = fieldName.toLowerCase();
                const formField = '.field-'+model+'-'+fieldName.toLowerCase();
                const keyField ='#'+model+'-key'; 
                const targetField = '#'+model+'-'.field;
                const tget = '#'+model+'-'+field;


                const fieldValue = ev.target.value;
                const Key = $(keyField).val();
                //alert(Key);
                if(Key.length){
                    const url = $('input[name=url]').val()+model+'/setfield?field='+fieldName;
                    $.post(url,{ fieldValue:fieldValue,'Key': Key}).done(function(msg){
                        
                            // Populate relevant Fields
                            
                            
                            // console.log(msg[fieldName]);
                            // console.log(fieldName);
                           
                            $(keyField).val(msg.Key);
                            $(targetField).val(msg[fieldName]);
                            $('#training-training_program').val(msg.Training_Program);

                           
                            if((typeof msg) === 'string') { // A string is an error
                                console.log(formField);
                                const parent = document.querySelector(formField);
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = msg;
                                
                            }else{ // An object represents correct details

                                const parent = document.querySelector(formField);
                                const helpbBlock = parent.children[2];
                                helpbBlock.innerText = '';
                                
                            }   
                        },'json');
                }
            
     }

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
