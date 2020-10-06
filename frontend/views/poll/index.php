<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - NCPB Surveys';
$this->params['breadcrumbs'][] = ['label' => 'Surveys', 'url' => ['index']];

?>
    <div class="row">
        <div class="col-md-12">
            <div class="card card-success">
                <div class="card-body">
                    <?= \yii\helpers\Html::a('Add New Survey',['create','create'=> 1],['class' => 'btn btn-outline-warning push-right', 'data' => [
                        'confirm' => 'Are you sure you want to create a new Survey',
                        'method' => 'post',
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
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title">Surveys List</h3>

                </div>
                <div class="card-body">
                    <table class="table table-bordered dt-responsive table-hover" id="leaves">
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
                    <h4 class="modal-title" id="myModalLabel" style="position: absolute">Survey</h4>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-outline-warning">Save changes</button>-->
                </div>

            </div>
        </div>
    </div>

<?php
$absoluteUrl = \yii\helpers\Url::home(true);

print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
$script = <<<JS

    $(function(){
         /*Data Tables*/
         
         $.fn.dataTable.ext.errMode = 'throw';
        
        var absolute = $('#ab').val();
          $('#leaves').DataTable({
           
            //serverSide: true,  
            ajax: absolute+'/poll/getsurveys',
            paging: true,
            columns: [
                { title: 'Survey' ,data: 'survey'},
                { title: 'Start Date' ,data: 'start_date'},
                { title: 'End Date' ,data: 'end_date'},
                { title: 'surveychoices' ,data: 'surveychoices'},
                { title: 'participate' ,data: 'participate'},
               
               
            ] ,                              
           language: {
                "zeroRecords": "No Surveys display"
            },
            
            order : [[ 1, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#leaves').DataTable();
       if(1==9){
       table.columns([0,3]).visible(false);
       }
    
    /*End Data tables*/
        $('#leaves').on('click','tr', function(){
            
        });
        
        //Add Poll choice
        
           $('#leaves').on('click','.add-choice',function(e){
                e.preventDefault();
                var url = $(this).attr('href');
                           
                console.log('clicking...');
                $('.modal').modal('show')
                                .find('.modal-body')
                                .load(url); 
            
         });
           
           /*Pull voting choices screen*/
           
            $('#leaves').on('click','.vote',function(e){
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
        
    });//End Jquery
        
JS;

$this->registerJs($script);






