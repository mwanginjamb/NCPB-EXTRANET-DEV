<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Contract - '.$model->Code;
$this->params['breadcrumbs'][] = ['label' => 'Contracts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Contract Card', 'url' => ['view','No'=> $model->Code]];
/** Status Sessions */

?>

<div class="row">
    <div class="col-md-4">

        <?= ($model->Status == 'New')?Html::a('<i class="fas fa-paper-plane"></i> Activate',['activate-contract'],['class' => 'btn btn-app submitforapproval',
            'data' => [
                'confirm' => 'Are you sure you want to Activate Contract ?',
                'params'=>[
                    'No'=> $model->Code,
                    'employeeNo' => Yii::$app->user->identity->{'Employee No_'},
                ],
                'method' => 'get',
        ],
            'title' => 'Activate Contract'

        ]):'' ?>


        <?= ($model->Status == 'Running')?Html::a('<i class="fas fa-times"></i> Close Contract.',['close-contract'],['class' => 'btn btn-app submitforapproval',
            'data' => [
            'confirm' => 'Are you sure you want to close  this contract?',
            'params'=>[
                'No'=> $model->Code,
            ],
            'method' => 'get',
        ],
            'title' => 'Close Contract'

        ]):'' ?>
    </div>
</div>

    <div class="row">
        <div class="col-md-12">
            <div class="card-success">
                <div class="card-header">
                    <h3>Contract Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">




                    <h3 class="card-title">Imprest No : <?= $model->Code?></h3>



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

                                <?= $form->field($model, 'Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Costing_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                              
                                <?= $form->field($model, 'Contract_Type')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               
                                <?= $form->field($model, 'Quarter')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Procurement_Method')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                
                                <?= $form->field($model, 'Method_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                 <?= $form->field($model, 'Type_Description')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                  <?= $form->field($model, 'Reference_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                   <?= $form->field($model, 'Description')->textarea(['readonly'=> true, 'disabled'=>true]) ?>

                                   <?= $form->field($model, 'Total_Value')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


        <?= '<p><span>Invoiced Value</span> '.Html::a($model->Invoiced_Value,'#'); '</p>'?>

        <?= '<p><span>Deliverables</span> '.Html::a($model->Deliverables,'#'); '</p>' ?>
  

                                 <?= $form->field($model, 'Contractor')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                  <?= $form->field($model, 'Contractor_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                <p class="parent"><span>+</span>

                                   

                                </p>


                            </div>
                            <div class="col-md-6">

                                <?= $form->field($model, 'Comments')->textarea(['readonly'=> true, 'disabled'=>true]) ?>
                                
                                <?= $form->field($model, 'Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               

                                <?= $form->field($model, 'Global_Dimension_1_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                
                                <?= $form->field($model, 'Global_Dimension_2_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>




                                <?= '<p><span>Start Date</span> '.Html::a($model->Start_Date,'#'); '</p>'?>
                                <?= '<p><span>End Date</span> '.Html::a($model->End_Date,'#'); '</p>'?>

                                <?= $form->field($model, 'Notify_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Monitoring_Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Administration_Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <?= $form->field($model, 'Notification_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <?= $form->field($model, 'Performance_Bond_Exp_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>

                                <?= $form->field($model, 'Performance_Bond_Notify_Period')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Notify_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model,'Financial_Year')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                <p class="parent"><span>+</span>



                                </p>



                            </div>
                        </div>
                    </div>




                    <?php ActiveForm::end(); ?>



                </div>
            </div><!--end details card-->


            <!--Objectives card -->


            <div class="card">
                <div class="card-header">
                    <div class="card-title">   <?= ($model->Status == 'New')?Html::a('<i class="fa fa-plus-square"></i> New Contract Line',['contractline/create','Code'=>$model->Code],['class' => 'add-objective btn btn-outline-info']):'' ?></div>
                </div>



                <div class="card-body">





                    <?php
                    if(is_array($model->getLines())){ //show Lines ?>
                        <div class="table-responsive">
                             <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td><b>Deliverable_Code</b></td>
                                <td><b>Description</b></td>
                                <td><b>Start Date</b></td>
                                <td><b>Period</b></td>
                                <td><b>End Date</b></td>
                                <td><b>Contractor</b></td>
                                <td><b>Vendor No</b></td>
                                <td><b>Vendor Name</b></td>

                                <td><b>Amount</b></td>
                                <td><b>Action</b></td>



                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            // print '<pre>'; print_r($model->getObjectives()); exit;

                            foreach($model->lines as $obj):
                                $updateLink = Html::a('<i class="fa fa-edit"></i>',['contractline/update','Line_No'=> $obj->Line_No],['class' => 'update-objective btn btn-outline-info btn-xs']);
                                $deleteLink = Html::a('<i class="fa fa-trash"></i>',['contractlineline/delete','Key'=> $obj->Key ],['class'=>'delete btn btn-outline-danger btn-xs']);
                                ?>
                                <tr>

                                    <td><?= !empty($obj->G_L_Account)?$obj->G_L_Account:'Not Set' ?></td>
                                    <td><?= !empty($obj->Description)?$obj->Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Start_Date)?$obj->Start_Date:'Not Set' ?></td>
                                    <td><?= !empty($obj->Period)?$obj->Period:'Not Set' ?></td>
                                    <td><?= !empty($obj->Contractor)?$obj->Contractor:'Not Set' ?></td>
                                    <td><?= !empty($obj->Vendor_No)?$obj->Vendor_No:'Not Set' ?></td>
                                    <td><?= !empty($obj->Vendor_Name)?$obj->Vendor_Name:'Not Set' ?></td>
                                    <td><?= !empty($obj->Amount)?$obj->Amount:'Not Set' ?></td>
                                    <td><?= !empty($obj->Invoiced)?Html::checkbox($obj->Invoiced):'Not Set' ?></td>
                                    

                                    <td><?= $updateLink.'|'.$deleteLink ?></td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        </div>  
                       
                    <?php } ?>
                </div>
            </div>

            <!--objectives card -->








        </>
    </div>

    <!--My Bs Modal template  --->

    <div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Contract Management</h4>
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
         $(this).closest('tr').remove(); // REMOVE PARENT ELEM
         $.get(url).done(function(msg){
             if(msg.status !== TRUE){
                 $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
             }             
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
