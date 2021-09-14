<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Claim - '.$model->Claim_No;
$this->params['breadcrumbs'][] = ['label' => 'imprests', 'url' => ['Claim']];
$this->params['breadcrumbs'][] = ['label' => 'Imprest Card', 'url' => ['view','No'=> $model->Claim_No]];
/** Status Sessions */

?>

    <div class="row">
        <div class="col-md-4">

            <?= ($model->Document_Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Send Approval Req',['send-for-approval'],['class' => 'btn btn-app submitforapproval',
                'data' => [
                    'confirm' => 'Are you sure you want to send this document for approval?',
                    'params'=>[
                        'No'=> $model->Claim_No ,
                        //'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                    ],
                    'method' => 'get',
                ],
                'title' => 'Submit Imprest Approval'

            ]):'' ?>


            <?= ($model->Document_Status == 'Approval_Pending')?Html::a('<i class="fas fa-times"></i> Cancel Approval Req.',['cancel-request'],['class' => 'btn btn-app submitforapproval',
                'data' => [
                    'confirm' => 'Are you sure you want to cancel imprest approval request?',
                    'params'=>[
                        'No'=> $model->Claim_No,
                    ],
                    'method' => 'get',
                ],
                'title' => 'Cancel Imprest Approval Request'

            ]):'' ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-success">
                <div class="card-header">
                    <h3>Claim Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Claim No : <?= $model->Claim_No ?></h3>



                    <?php
                    if(Yii::$app->session->hasFlash('success')){
                        print ' <div class="alert alert-success alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('success');
                        print '</div>';
                    }else if(Yii::$app->session->hasFlash('error')){
                        print ' <div class="alert alert-danger alert-dismissable">
                                 ';
                        echo Yii::$app->session->getFlash('error');
                        print '</div>';
                    }
                    ?>
                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Claim_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Payroll_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Safari_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Full_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Imprest_Account')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                            
                                <?= $form->field($model, 'Total_Claim')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                




                                <p class="parent"><span>+</span>




                                </p>


                            </div>
                            <div class="col-md-6">
                            
                                <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Approvals')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Document_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Source_Document_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                

                                <p class="parent"><span>+</span>



                                </p>



                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


            <!--Objectives card -->

            <?php // Yii::$app->recruitment->printrr($model->getLines($model->Application_No)) ?>



            <div class="card">
                <div class="card-header">
                    <div class="card-title">   <?= ($model->Document_Status == 'New')? Html::a('<i class="fa fa-plus-square"></i> New Line',['claimline/create','No'=>$model->Claim_No],['class' => 'add-objective btn btn-outline-info']):'' ?></div>
                </div>



                <div class="card-body">





                    <?php
                    if(is_array($model->getLines())){ //show Lines ?>
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Travel_From</b></td>
                                <td><b>Travel_To</b></td>
                                <td><b>Claim_Type</b></td>
                                <td><b>Description</b></td>
                                <td><b>Date</b></td>
                                <td><b>Distance</b></td>
                                <td><b>Days</b></td>
                                <td><b>Nights_Spent</b></td>
                                <td><b>Reason_For_Claim</b></td>
                                <td><b>Rate</b></td>
                                <td><b>Total_Amount</b></td>
                                <td><b>Function Code</b></td>
                                <td><b>Budget Center Code</b></td>
                                <td><b>Actions</b></td>


                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->lines as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['claimline/update',
                                    'Key'=> $obj->Key
                                ],
                                    ['class' => 'update-objective btn btn-outline-info btn-xs','title' => 'update line']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['claimline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->Travel_From)?$obj->Travel_From:'Not Set' ?></td>
                                    <td><?= !empty($obj->Travel_To)?$obj->Travel_To:'Not Set' ?></td>
                                    <td><?= !empty($obj->Claim_Type)?$obj->Claim_Type:'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Date)?$obj->Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Nights_Spent)?$obj->Nights_Spent:'Not Set' ?></td>
                                    <td><?= !empty($obj->Reason_For_Claim)?$obj->Reason_For_Claim:'Not Set' ?></td>
                                    <td><?= !empty($obj->Rate)?$obj->Rate:'Not Set' ?></td>
                                    <td><?= !empty($obj->Total_Amount)?$obj->Total_Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Global_Dimension_1_Code)?$obj->Global_Dimension_1_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Global_Dimension_2_Code)?$obj->Global_Dimension_2_Code:'Not Set' ?></td>

                                    <td><?= ($model->Document_Status == 'New')?$updateLink.'|'.$deleteLink:'' ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } ?>
                </div>
            </div>

            <!--objectives card -->









    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Claims Management</h4>
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


<?php

$script = <<<JS

    $(function(){
      
        
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
      
    
    /*Evaluate KRA*/
        $('.evalkra').on('click', function(e){
             e.preventDefault();
            var url = $(this).attr('href');
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 

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
     
     
     //Update a training plan
    
     $('.update-trainingplan').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
     
     
     //Update/ Evalute Employeeappraisal behaviour -- evalbehaviour
     
      $('.evalbehaviour').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      /*Add learning assessment competence-----> add-learning-assessment */
      
      
      $('.add-learning-assessment').on('click',function(e){
        e.preventDefault();
        var url = $(this).attr('href');
        console.log('clicking...');
        $('.modal').modal('show')
                        .find('.modal-body')
                        .load(url); 

     });
      
      
     
      
      
      
    
    /*Handle modal dismissal event  */
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    }); 
        
    /*Parent-Children accordion*/ 
    
    $('tr.parent').find('span').text('+');
    $('tr.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('tr.parent').nextUntil('tr.parent').slideUp(1, function(){});    
    $('tr.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('tr.parent').slideToggle(100, function(){});
     });
    
    /*Divs parenting*/
    
     $('p.parent').find('span').text('+');
    $('p.parent').find('span').css({"color":"red", "font-weight":"bolder"});    
    $('p.parent').nextUntil('p.parent').slideUp(1, function(){});    
    $('p.parent').click(function(){
            $(this).find('span').text(function(_, value){return value=='-'?'+':'-'}); //to disregard an argument -event- on a function use an underscore in the parameter               
            $(this).nextUntil('p.parent').slideToggle(100, function(){});
     });
    
        //Add Career Development Plan
        
        $('.add-cdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
           
            
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });//End Adding career development plan
         
         /*Add Career development Strength*/
         
         
        $('.add-cds').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
            
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /*End Add Career development Strength*/
         
         
         /* Add further development Areas */
         
            $('.add-fda').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         
         /* End Add further development Areas */
         
         /*Add Weakness Development Plan*/
             $('.add-wdp').on('click',function(e){
            e.preventDefault();
            var url = $(this).attr('href');
                       
            console.log('clicking...');
            $('.modal').modal('show')
                            .find('.modal-body')
                            .load(url); 
            
         });
         /*End Add Weakness Development Plan*/

         //Change Action taken

         $('select#probation-action_taken').on('change',(e) => {

            const key = $('input[id=Key]').val();
            const Employee_No = $('input[id=Employee_No]').val();
            const Appraisal_No = $('input[id=Appraisal_No]').val();
            const Action_Taken = $('#probation-action_taken option:selected').val();
           
              

            /* var data = {
                "Action_Taken": Action_Taken,
                "Appraisal_No": Appraisal_No,
                "Employee_No": Employee_No,
                "Key": key

             } 
            */
            $.get('./takeaction', {"Key":key,"Appraisal_No":Appraisal_No, "Action_Taken": Action_Taken,"Employee_No": Employee_No}).done(function(msg){
                 $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
                });


            });
    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);

$style = <<<CSS
    p span {
        margin-right: 50%;
        font-weight: bold;
    }

    table td:nth-child(11), td:nth-child(12) {
                text-align: center;
    }
    
    /* Table Media Queries */
    
     @media (max-width: 500px) {
          table td:nth-child(2),td:nth-child(3),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
     @media (max-width: 550px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
    
    @media (max-width: 650px) {
          table td:nth-child(2),td:nth-child(6),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }


    @media (max-width: 1500px) {
          table td:nth-child(2),td:nth-child(7),td:nth-child(8),td:nth-child(9),td:nth-child(10), td:nth-child(11) {
                display: none;
        }
    }
CSS;

$this->registerCss($style);
