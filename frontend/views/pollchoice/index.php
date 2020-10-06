<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\PollchoiceSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Survey choices';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card">

    <div class="card-header">
        <div class="card-title">Take Survey by Selecting  a Choice</div>
    </div>


</div>

<table class="table">
    <?php
    $counter = 0;
        foreach($model as $poll): ++$counter; ?>

            <tr>

                <td><?= $counter ?></td>
                <td><?= Html::checkbox('choice',false,['value'=> $poll->id,'rel'=>$poll->poll_id,'class'=>'choice form-controller']) ?></td>
                <td><?= $poll->choice_body ?></td>
            </tr>

    <?php endforeach; ?>
</table>

<div class="row">
    <?php
    $i = 0;
    foreach($model as $poll):
        ++$i;
        $bgs = [
                'bg-primary',
                'bg-danger',
                'bg-success',
                'bg-yellow',
                'bg-green'
        ];
        ?>
        <div class="col-md-4">
            <span><?= $poll->choice_body ?> (<?= bcdiv($poll::getPercentage($poll->poll_id, $poll->id), 1, 1); ?>
                %)</span></span>
        </div>

        <div class="col-md-8">
            <div class="progress-group">

                <span class="float-right"><?= $poll::getIndividualVotes($poll->poll_id, $poll->id); ?>/<b><?= $poll::getTotalVotes($poll->poll_id)?></b></span>
                <div class="progress progress-sm">
                    <div class="progress-bar <?= $bgs[$i - 1]?>" style="width: <?= bcdiv($poll::getPercentage($poll->poll_id, $poll->id), 1, 1); ?>%"></div>
                </div>
            </div>
        </div>


    <?php endforeach; ?>
</div>

<?php
$absoluteUrl = \yii\helpers\Url::home(true);
print '<input type="hidden" id="ab" value="'.$absoluteUrl.'" />';
$script = <<<JS
 //Submit Rejection form and get results in json    
        $('.choice').on('click', function(e){
       
            e.preventDefault();
            var absolute = $('#ab').val();
            var choice = $(this).val();
            var poll_id = $(this).attr('rel');
            var url = absolute+'/pollchoice/vote';
            
            $.post(url,{"choice": choice,"poll_id": poll_id}).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
JS;

$this->registerJs($script);