<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = Yii::$app->params['generalTitle'];
$this->params['breadcrumbs'][] = ['label' => 'Contract List', 'url' => ['index']];

$url = \yii\helpers\Url::home(true);
?>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
        <?= \yii\helpers\Html::a('Add New Contract',['create'],['class' => 'btn btn-info push-right', 'data' => [
            'confirm' => 'Are you sure you want to create a new Contract Document ?',
            'method' => 'get',
        ],]) ?>
            </div>
        </div>
    </div>
</div>


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
    echo Yii::$app->session->getFlash('error');
    print '</div>';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="card card-info">
            <div class="card-header">
                <h3 class="card-title">Contracts List</h3>






            </div>
            <div class="card-body">
                <table class="table table-bordered dt-responsive table-hover" id="table">
                </table>
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

    <input type="hidden" value="<?= $url ?>" id="url" />
<?php

$script = <<<JS

    $(function(){


       




         /*Data Tables*/
         
         //$.fn.dataTable.ext.errMode = 'throw';
        const url = $('#url').val();
    
          $('#table').DataTable({
           
            //serverSide: true,  
            ajax: url+'contract/list',
            paging: true,
            columns: [
                { title: 'No' ,data: 'Code'},
                { title: 'Description' ,data: 'Description'},
                { title: 'Total Value' ,data: 'Total_Value'},
                { title: 'Invoiced Value' ,data: 'Invoiced_Value'},
                { title: 'Deliverables' ,data: 'Deliverables'},   
                { title: 'Contractor Name' ,data: 'Contractor_Name'},
                { title: 'Comments', data: 'Comments' },
                { title: 'Start Date', data: 'Start_Date' },
                { title: 'End Date', data: 'End_Date' },
                { title: 'Procurement Method', data: 'Procurement_Method' },
                { title: 'View', data: 'view' },
               
            ] ,                              
           language: {
                "zeroRecords": "No Contract to display"
            },
            
            order : [[ 0, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#table').DataTable();
       table.columns([5,6]).visible(false);
    
    /*End Data tables*/
        $('#table').on('click','.delete', function(e){

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


        }); // End dt event delegation



          
    /*Handle modal dismissal event  */
    
    $('.modal').on('hidden.bs.modal',function(){
        var reld = location.reload(true);
        setTimeout(reld,1000);
    });



    });
        
JS;

$this->registerJs($script);

$style = <<<CSS
    table td:nth-child(7), td:nth-child(8), td:nth-child(9) {
        text-align: center;
    }
CSS;

$this->registerCss($style);







