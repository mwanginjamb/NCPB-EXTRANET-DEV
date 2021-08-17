<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Appraisal - '.$model->Appraisal_Code;
$this->params['breadcrumbs'][] = ['label' => 'Appraisal', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal Card', 'url' => ['view','No'=> $model->Appraisal_Code]];


Yii::$app->session->set('Approval_Status',$model->Approval_Status);
Yii::$app->session->set('Mid_Year_Approval_Status',$model->Mid_Year_Approval_Status);



$absoluteUrl = \yii\helpers\Url::home(true);

/** Status Sessions */

Yii::$app->session->set('Approval_Status',$model->Approval_Status);




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
            echo Yii::$app->session->getFlash('error');
            print '</div>';
        }



?>


    
    <!--  Action Buttons -->

    <div class="row">
        <!-- Add action buttons here -->

        <?php if($model->Approval_Status == 'Appraisee_Level'): ?>

                         <div class="col-md-3">
                                     <?= Html::a('<i class="fas fa-forward"></i> submit',['submit','appraisalNo'=> $model->Appraisal_Code,'employeeNo' => $model->Employee_No],['class' => 'btn btn-app submitforapproval mx-1','data' => [
                                            'confirm' => 'Are you sure you want to submit this appraisal to supervisor ?',
                                            'method' => 'post',
                                        ],
                                        'title' => 'Send Score Card to Supervisor..'

                                    ]) ?>
                         </div>       

                                    
                                

        <?php endif; ?>

            <div class="col-md-3">  
                   <?= Html::a('<i class="fas fa-book-open"></i> P.A Report',['report'],[
                                        'class' => 'btn btn-app bg-success mx-1',
                                        'title' => 'Generate Performance Appraisal Report',
                                        'target'=> '_blank',
                                        'data' => [
                                            // 'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                            'params'=>[
                                                'appraisalNo'=> $model->Appraisal_Code,
                                                'employeeNo' => $model->Employee_No,
                                            ],
                                            'method' => 'post'
                                        ]
                                    ]);

                    ?>
            </div>


<!--    Supervisor Level Actions -->
        <?php if($model->Approval_Status == 'Supervisor_Level'): ?>
                 <div class="col-md-3"> 
                        <?= Html::a('<i class="fas fa-backward"></i> Back To Appraisee',['back-to-appraisee'],[
                                        'class' => 'btn btn-app bg-danger mx-1',
                                        'title' => 'Send Appraisal Back To Appraisee..',
                                        'data' => [
                                             'confirm' => 'Are you sure you want to send appraisal Back to Appraisee?',
                                            'params'=>[
                                                'appraisalNo'=> $model->Appraisal_Code,
                                                'employeeNo' => $model->Employee_No,
                                            ],
                                            'method' => 'post'
                                        ]
                                    ]);

                        ?>  
                    </div>   

                    <div class="col-md-3"> 
                        <?= Html::a('<i class="fas fa-forward"></i>To HR',['to-hr'],[
                                        'class' => 'btn btn-app bg-success mx-1',
                                        'title' => 'Send Appraisal To Hr',
                                        'data' => [
                                             'confirm' => 'Are you sure you want to send appraisal to HR?',
                                            'params'=>[
                                                'appraisalNo'=> $model->Appraisal_Code,
                                                'employeeNo' => $model->Employee_No,
                                            ],
                                            'method' => 'post'
                                        ]
                                    ]);

                        ?>  
                    </div>  

                                    
                                

        <?php endif; ?>

     <!-- HR aCTIONS -->     

     <?php if($model->Approval_Status == 'Hr_Level'): ?>
                 
                 <div class="col-md-3"> 
                        <?= Html::a('<i class="fas fa-backward"></i> Back To Supervisor',['back-to-supervisor'],[
                                        'class' => 'btn btn-app bg-success mx-1',
                                        'title' => 'Send Appraisal Back To Supervisor..',
                                        'data' => [
                                             'confirm' => 'Are you sure you want to send appraisal Back to Supervisor?',
                                            'params'=>[
                                                'appraisalNo'=> $model->Appraisal_Code,
                                                'employeeNo' => $model->Employee_No,
                                            ],
                                            'method' => 'post'
                                        ]
                                    ]);

                        ?>  
                    </div>   
                                    
                                

        <?php endif; ?>


     <!-- / hr Actions -->     
            
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3>Appraisal  Card </h3>
                </div>



            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">

                    <h3 class="card-title">Appraisal No : <?= $model->Appraisal_Code ?></h3>

                </div>
                <div class="card-body">


                    <?php $form = ActiveForm::begin(); ?>


                    <div class="row">
                        <div class=" row col-md-12">
                            <div class="col-md-6">

                                <?= $form->field($model, 'Appraisal_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_No')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Employee_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Department')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                
                            
                                <?= $form->field($model, 'Appraisal_Start_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                




                                <p class="parent"><span>+</span>

                                    <?= $form->field($model, 'Calender_Code')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                </p>


                            </div>
                            <div class="col-md-6">
                            
                                <?= $form->field($model, 'Appraisal_End_Date')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Total_KPI_x0027_s')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Deparrtment_Name')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Mid_Year_Approval_Status')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                <?= $form->field($model, 'Action_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                               
                                

                                <p class="parent"><span>+</span>

                                     <?= $form->field($model, 'Hr_User_ID')->textInput(['readonly'=> true, 'disabled'=>true]) ?>


                                </p>



                            </div>
                        </div>

                    </div>

                   
                  
                    
                   
                   




                    <?php ActiveForm::end(); ?>



                </div>


                <div class="text lead text-center">SCORES</div>
                <div class=" d-flex flex-row justify-content-between mr-4 ml-4">

                    
                   
                               

                                <div class="col col-md-6">
                                    <?= $form->field($model, 'Mid_Year_Score')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                </div>
                                <div class="col col-md-6">
                                    <?= $form->field($model, 'End_Year_Score')->textInput(['readonly'=> true, 'disabled'=>true]) ?>
                                </div>
                   
                    
                    

                </div>
            </div><!--end details card-->


            <!--Objectives card -->

            <?php // Yii::$app->recruitment->printrr($model->getLines($model->Application_No)) ?>



            <div class="card">
                <div class="card-header">
                    <div class="card-title"> Employee Key Result Areas</div>
                            
                    <div class="card-tools">
                        <?= Html::a('<i class="fa fa-plus-square"></i>',['objective/create','Appraisal_Code'=> $model->Appraisal_Code],['class' => 'mx-1 update-objective btn btn-xs btn-outline-warning', 'title' => 'Add Key Result Area']);
                            ?>
                    </div>
                </div>



                <div class="card-body">

                   <?php if(is_array($model->KRA)){ //show Objectives ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                             <td>#</td>
                            <td><b>Objective Code</b></td>
                            <td><b>Objective</b></td>
                            <td><b>Objective Description</b></td>
                            <td><b>Total KPIs</b></td>
                            <td><b>Action</b></td>

                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            // print '<pre>'; print_r($model->KRA); exit;

                         foreach($model->KRA as $obj):


                            if(empty($obj->KRA_Code))
                            {
                                continue;
                            }


                            $updateLink = Html::a('<i class="fa fa-edit"></i>',['objective/update','Key'=> $obj->Key],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Key Result Area']);
                             $deleteLink = Html::a('<i class="fa fa-trash"></i>',['objective/delete','Key'=> $obj->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Key Result Area']);
                             $addKpi = Html::a('<i class="fa fa-plus-square"></i>',['kpi/create','Employee_No'=>$model->Employee_No,'Appraisal_No' => $model->Appraisal_Code,'KRA_Code' => $obj->KRA_Code  ],['class'=>'mx-1 update-objective add btn btn-success btn-xs','title' => 'Add a Key Performance Indicator']);
                         ?>
                                <tr class="parent">
                                     <td><span>+</span></td>
                                    <td><?= !empty($obj->KRA_Code)?$obj->KRA_Code:'Not Set' ?></td>
                                    <td><?= !empty($obj->Objective)?$obj->Objective:'Not Set' ?></td>
                                    <td><?= !empty($obj->Objective_Description)?$obj->Objective_Description:'Not Set' ?></td>
                                    <td><?= !empty($obj->Total_KPI_x0027_s)?$obj->Total_KPI_x0027_s:'Not Set' ?></td>
                                    <td><?= $updateLink.$deleteLink.$addKpi ?></td>
                                </tr>
                                <tr class="child">
                                    <td colspan="6" >
                                        <div class="table-responsive">
                                            <table class="table table-hover table-borderless table-info">
                                                <thead>
                                                <tr >
                                                    <td><b>KPI</b></td>
                                                    <td><b>Activity / Initiative</b></td>
                                                    <td><b>Target</b></td>
                                                    <td><b>Maximum Weight</b></td>
                                                    <td><b>Target Achieved</b></td>
                                                    <td><b>Self Assesment</b></td>
                                                    <td><b>Self Comments</b></td>
                                                    <td><b>Joint Assesment</b></td>
                                                    <td><b>Supervisor Comments</b></td>
                                                    <td><b>Weighted Rating</b></td>
                                                    <td><b>Hr Comments</b></td>
                                                    

                                                    <th><b>Action</b></th>

                                                   
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php if(is_array($model->getKPI($obj->KRA_Code))){

                                                    foreach($model->getKPI($obj->KRA_Code) as $kpi):

                                                        if(empty($kpi->KPI_Code)){
                                                            continue;
                                                        }

                             $updateLink = Html::a('<i class="fa fa-edit"></i>',['kpi/update','Key'=> $kpi->Key],['class' => 'mx-1 update-objective btn btn-xs btn-outline-info', 'title' => 'Update Key Result Area']);
                             $deleteLink = Html::a('<i class="fa fa-trash"></i>',['kpi/delete','Key'=> $kpi->Key ],['class'=>'mx-1 delete btn btn-danger btn-xs', 'title' => 'Delete Key Result Area']);


                                                      ?>
                                            <tr>
                                                <td><?= !empty($kpi->KPI_Code)?$kpi->KPI_Code:' Not Set' ?></td>           
                                                <td><?= !empty($kpi->Activity)?$kpi->Activity:' Not Set' ?></td>
                                                <td><?= !empty($kpi->Target)?$kpi->Target:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Maximum_Weight)?$kpi->Maximum_Weight:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Target_Achieved)?$kpi->Target_Achieved:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Self_Assesment)?$kpi->Self_Assesment:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Self_Comments)?$kpi->Self_Comments:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Joint_Assesment)?$kpi->Joint_Assesment:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Supervisor_Comments)?$kpi->Supervisor_Comments:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Weighted_Rating)?$kpi->Weighted_Rating:'Not Set' ?></td>
                                                <td><?= !empty($kpi->Hr_Comments)?$kpi->Hr_Comments:'Not Set' ?></td>
                                                

                                

                                                <td><?= $updateLink.$deleteLink ?></td>

                                            </tr>
                                                <?php
                                                    endforeach;
                                                }
                                                ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        </td>
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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Performance Appraisal Management</h4>
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
            const Appraisal_Code = $('input[id=Appraisal_No]').val();
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
