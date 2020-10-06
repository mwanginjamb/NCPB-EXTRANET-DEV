<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/22/2020
 * Time: 5:23 PM
 */



/* @var $this yii\web\View */

$this->title = 'HRMIS - NCPB Price Adjustment';
$this->params['breadcrumbs'][] = ['label' => 'Staff List', 'url' => ['index']];
$this->params['breadcrumbs'][] = '';
?>



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
        <div class="card">
            <div class="card-content">
        <?php
                $products = [
                        '1' => 'Maize 90Kg Bag',
                        '2' => 'Yellow Maize 90Kg Bag'
                ];

            print \yii\helpers\Html::dropDownList('products',null,$products,['prompt' => 'Select Produce','class'=>'form-control']);
        ?>
            </div>
        </div>
    </div>

<?php if($_GET['id'] == 1): ?>
            <div class="col-md-12">
                <div class="card-success">
                    <div class="card-header">
                        <h3 class="card-title">Price Adjustment: White Maize 90Kg Bag</h3>
                    </div>
                    <div class="card-body">


                        <div id="bar-chart" style="height: 300px;"></div>




                    </div>
                </div>
            </div>
<?php endif; ?>

<?php if($_GET['id'] == 2): ?>
    <div class="col-md-12">
        <div class="card-success">
            <div class="card-header">
                <h3 class="card-title">Price Adjustment: Yellow Maize</h3>
            </div>
            <div class="card-body">

                <div id="bar-chart2" style="height: 300px;"></div>

            </div>
        </div>
    </div>

    <?php endif; ?>



</div>

<!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Staff Contact</h4>
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
print '<input type="hidden" id="type" value="'.$_GET['id'].'" />';
$script = <<<JS

    $(function(){
         /*Data Tables*/
         var absolute = $('#ab').val();
          var chart = $('#type').val();
         $.fn.dataTable.ext.errMode = 'throw';
        
    
          $('#staff').DataTable({
           
            //serverSide: true,  
            ajax: './getstaff',
            paging: true,
            columns: [
                { title: 'Employee No' ,data: 'Employee_No'},
                { title: 'Full Name' ,data: 'Full_Name'},
                { title: 'User ID' ,data: 'User_ID'},
                { title: 'Company E-Mail' ,data: 'Company_E_Mail'},
                { title: 'Contract Type' ,data: 'Contract_Type'},    
                { title: 'View Contacts' ,data: 'view'},             
               
            ] ,                              
           language: {
                "zeroRecords": "No Employees to display"
            },
            
            order : [[ 2, "desc" ]]
            
           
       });
        
       //Hidding some 
       var table = $('#staff').DataTable();
       //table.columns([0,6]).visible(false);
    
    /*End Data tables*/
        $('#staff').on('click','a.contact', function(e){
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
        
        
        
     /*
     * BAR CHART
     * ---------
     */

    var bar_data = {
      data : [[1,10], [2,8], [3,4], [4,13], [5,17], [6,3], [7,10],[8,13],[9,5],[10,3]  ],
      bars: { show: true }
    }
    
    var bar_data2 = {
      data : [[1,30], [2,5], [3,1], [4,17], [5,7], [6,2], [7,8],[8,4],[9,10],[10,8]  ],
      bars: { show: true }
    }
    
    if(chart == 1){
    $.plot('#bar-chart', [bar_data], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [
                [1,'January'],
                [2,'February'],
                [3,'March'],
                [4,'April'],
                [5,'May'],
                [6,'June'],
                [4,'July'],
                [7,'August'],
                [8,'September'],
                [2,'October'],
                [9,'November'],
                [10,'December'],
            ]
      }
    });
    
    }
    
    //End chart Chart 1
    if(chart == 2){
    $.plot('#bar-chart2', [bar_data2], {
      grid  : {
        borderWidth: 1,
        borderColor: '#f3f3f3',
        tickColor  : '#f3f3f3'
      },
      series: {
         bars: {
          show: true, barWidth: 0.5, align: 'center',
        },
      },
      colors: ['#3c8dbc'],
      xaxis : {
        ticks: [
                [1,'January'],
                [2,'February'],
                [3,'March'],
                [4,'April'],
                [5,'May'],
                [6,'June'],
                [4,'July'],
                [7,'August'],
                [8,'September'],
                [2,'October'],
                [9,'November'],
                [10,'December'],
            ]
      }
    })
    
    }
    /* END BAR CHART */     
    
    $('select').on('change',function(){
        var product = $(this).children("option:selected").val();
        var url = absolute+'site/priceadjustment/?id='+product;
        window.location.href = url;
        return;
    });
    
    });


 function labelFormatter(label, series) {
    return '<div style="font-size:13px; text-align:center; padding:2px; color: #fff; font-weight: 600;">'
      + label
      + '<br>'
      + Math.round(series.percent) + '%</div>'
  }


   
        
JS;

$this->registerJs($script);






