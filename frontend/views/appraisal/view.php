<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/24/2020
 * Time: 6:09 PM
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Performance Appraisal - ' . $model->Appraisal_No;
$this->params['breadcrumbs'][] = ['label' => 'Performance Management', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Appraisal View', 'url' => ['view', 'Employee_No' => $model->Employee_No, 'Appraisal_No' => $model->Appraisal_No]];
/** Status Sessions */

Yii::$app->session->set('Goal_Setting_Status', $model->Goal_Setting_Status);
Yii::$app->session->set('MY_Appraisal_Status', $model->MY_Appraisal_Status);
Yii::$app->session->set('EY_Appraisal_Status', $model->EY_Appraisal_Status);
Yii::$app->session->set('isSupervisor', false);
Yii::$app->session->set('isOverview', $model->isOverView());
Yii::$app->session->set('isAppraisee', $model->isAppraisee());

$absoluteUrl = \yii\helpers\Url::home(true);

//Yii::$app->recruitment->printrr($model->isSupervisor());
?>

<div class="row">
    <div class="col-md-12">
        <div class="card-ushurusecondary">
            <div class="card-header">
                <h3>Performance Appraisal Card </h3>
            </div>

            <div class="card-body info-box">

                <div class="row">
                    <?php if ($model->Goal_Setting_Status == 'New') : ?>

                        <div class="col-md-6">

                            <?= Html::a('<i class="fas fa-forward"></i> submit', ['submit', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                                'class' => 'btn btn-app submitforapproval mx-auto', 'data' => [
                                    'confirm' => 'Are you sure you want to submit this appraisal?',
                                    'method' => 'post',
                                ],
                                'title' => 'Submit Goals for Approval'

                            ]) ?>
                        </div>

                    <?php endif; ?>

                    <div class="col-md-4">
                        <?= Html::a('<i class="fas fa-book-open"></i> P.A Report', ['report', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-success  pull-right mx-auto',
                            'title' => 'Generate Performance Appraisal Report',
                            'target' => '_blank',
                            'data' => [
                                // 'confirm' => 'Are you sure you want to send appraisal to peer 2?',
                                'params' => [
                                    'appraisalNo' => $model->Appraisal_No,
                                    'employeeNo' => $model->Employee_No,
                                ],
                                'method' => 'post',
                            ]
                        ]);
                        ?>

                    </div>


                    <?php if ($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Appraisee_Level') : ?>

                        <div class="col-md-4">
                            <?= Html::a('<i class="fas fa-forward"></i> submit EY', ['submitey', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                                'class' => 'btn btn-app bg-primary',
                                'title' => 'Submit End Year Appraisal for Approval',
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit End Year Appraisal?',
                                    'method' => 'post',
                                ]
                            ]) ?>
                        </div>

                    <?php endif; ?>


                    <?php if ($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Agreement_Level') : ?>

                        <div class="col-md-4">
                            <?= Html::a('<i class="fas fa-check"></i>E.Y  To Ln Manager', ['agreementtolinemgr', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                                'class' => 'btn btn-app bg-success py-2 mx-2',
                                'title' => 'To Line Manager',
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit End Year Appraisal?',
                                    'method' => 'post',
                                ]
                            ]) ?>
                        </div>

                    <?php endif; ?>




                    <?php if ($model->Goal_Setting_Status == 'Overview_Manager' && $model->isOverview()) : ?>
                        <div class="col-md-4">

                            <?= Html::a(
                                '<i class="fas fa-backward"></i> To Line Mgr.',
                                ['backtolinemgr', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                                [
                                    'class' => 'btn btn-app bg-danger rejectgoals',
                                    'rel' => $model->Appraisal_No,
                                    'rev' => $model->Employee_No,
                                    'title' => 'Submit Appraisal  Back to Line Manager'

                                ]
                            ) ?>
                        </div>
                        <div class="col-md-4">&nbsp;</div>
                        <div class="col-md-4">

                            <?= Html::a(
                                '<i class="fas fa-forward"></i> Approve',
                                ['approvegoals', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                                [

                                    'class' => 'btn btn-app submitforapproval', 'data' => [
                                        'confirm' => 'Are you sure you want to approve goals ?',
                                        'method' => 'post',
                                    ],
                                    'title' => 'Approve Set Appraisal Goals .'
                                ]
                            ) ?>

                        </div>

                    <?php endif; ?>


                    <!-- Overview Manager Actions at MY -->
                    <?php if ($model->MY_Appraisal_Status == 'Overview_Manager' && $model->isOverview()) : ?>
                        <?= Html::a(
                            '<i class="fas fa-check"></i> Approve',
                            ['ovapprovemy', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                            [

                                'class' => 'mx-1 btn btn-app bg-success submitforapproval', 'data' => [
                                    'confirm' => 'Are you sure you want to approve this Mid-Year Appraisal ?',
                                    'method' => 'post',
                                ],
                                'title' => 'Approve Mid Year Appraisal .'
                            ]
                        ) ?>



                        <?= Html::a(
                            '<i class="fas fa-backward"></i> To Line Mgr.',
                            ['mybacktolinemgr', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                            [
                                'class' => 'btn btn-app bg-danger rejectmyappraisal',
                                'rel' => $model->Appraisal_No,
                                'rev' => $model->Employee_No,
                                'title' => 'Send Mid Year Appraisal Back to Line Manager'

                            ]
                        ) ?>

                    <?php endif; ?>

                    <!-- End MY Overview Actions -->


                    <!--Mid Year Actions By Appraisee -->

                    <?php if ($model->Goal_Setting_Status == 'Closed' && $model->MY_Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()) : ?>

                        <div class="col-md-4 mx-1">
                            <?= Html::a('<i class="fas fa-forward"></i> Submit', ['submitmy', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                                'class' => 'btn btn-app bg-info submitforapproval ',
                                'title' => 'Submit Your Mid Year Appraisal for Approval',
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit Your Mid Year Appraisal?',
                                    'method' => 'post',
                                ]
                            ]) ?>

                        </div>


                    <?php endif; ?>

                    <?php if ($model->Goal_Setting_Status == 'Closed' && $model->MY_Appraisal_Status == 'Agreement_Level' && $model->isAppraisee()) : ?>
                        <?= Html::a('<i class="fas fa-play"></i>M.Y Agreement To Ln Mgr ', ['agreement-to-supervisor', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-warning  mx-1',
                            'title' => 'Mid-Year to Agreement Stage',
                            'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal to Agreement Level ?',
                                'method' => 'post',
                            ]
                        ]);
                        ?>
                    <?php endif; ?>

                    <!--Enf Mid Year Actions By Appraisee -->

                    <!-- Line Mgr Actions on complete goals -->

                    <?php if ($model->Goal_Setting_Status == 'Supervisor_Level'  && $model->isSupervisor()) : ?>


                        <?= Html::a(
                            '<i class="fas fa-backward"></i> To Appraisee.',
                            ['backtoemp', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                            [
                                'class' => 'btn btn-app bg-danger rejectappraiseesubmition',
                                'rel' => $model->Appraisal_No,
                                'rev' => $model->Employee_No,
                                'title' => 'Submit Probation  Back to Appraisee'

                            ]
                        ) ?>


                        <!-- Send Probation to Overview -->

                        <?= Html::a(
                            '<i class="fas fa-forward"></i> Overview ',
                            ['sendgoalsettingtooverview', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No],
                            [

                                'class' => 'mx-1 btn btn-app submitforapproval', 'data' => [
                                    'confirm' => 'Are you sure you want to Submit Goals to Overview Manager ?',
                                    'method' => 'post',
                                ],
                                'title' => 'Submit Goals to Overview Manager.'
                            ]
                        ) ?>






                    <?php endif; ?>

                    <!-- Mid YEar Supervisor Action -->

                    <?php if ($model->MY_Appraisal_Status == 'Supervisor_Level') : ?>

                        <?= Html::a('<i class="fas fa-times"></i> Reject MY', ['rejectmy'], [
                            'class' => 'btn btn-app bg-warning rejectmy mx-1',
                            'title' => 'Reject Mid-Year Appraisal',
                            'rel' => $model->Appraisal_No,
                            'rev' => $model->Employee_No,
                            /*'data' => [
                                            'confirm' => 'Are you sure you want to Reject this Mid-Year appraisal?',
                                            'method' => 'post',]*/
                        ])
                        ?>

                        <?= Html::a('<i class="fas fa-play"></i>MY To Agreement ', ['send-my-to-agreement', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-warning  mx-1',
                            'title' => 'Mid-Year to Agreement Stage',
                            'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal to Agreement Level ?',
                                'method' => 'post',
                            ]
                        ]);
                        ?>




                        <?= Html::a('<i class="fas fa-play"></i> To Overview ', ['my-to-overview', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-warning mx-1',
                            'title' => 'Send Appraisal To Overview Manager.',
                            'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal to Overview Manager ?',
                                'method' => 'post',
                            ]
                        ]);
                        ?>

                    <?php endif; ?>

                    <!--/ Mid YEar Supervisor Action -->



                    <!-- Agreement actions -->


                    <?php if ($model->MY_Appraisal_Status == 'Agreement_Level') : ?>

                        <?= Html::a('<i class="fas fa-play"></i>MY To Appraisee ', ['my-to-appraisee', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-warning  mx-1',
                            'title' => 'Mid-Year Agreement Back to Appraisee.',
                            'data' => [
                                'confirm' => 'Are you sure you want to send MY Appraisal Back to Appraisee ?',
                                'method' => 'post',
                            ]
                        ]);
                        ?>

                    <?php elseif ($model->EY_Appraisal_Status == 'Agreement_Level') : ?>


                        <?= Html::a('<i class="fas fa-times"></i> Reject EY', ['rejectey', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-warning rejectey',
                            'title' => 'Reject End-Year Appraisal',
                            'rel' =>  $model->Appraisal_No,
                            'rev' => $model->Employee_No,
                            /*'data' => [
               'confirm' => 'Are you sure you want to Reject this End-Year Appraisal?',
               'method' => 'post',]*/
                        ])
                        ?>

                    <?php endif; ?>

                    <!-- End Agreement actions -->

                    <?php if ($model->MY_Appraisal_Status == 'Closed' && $model->EY_Appraisal_Status == 'Agreement_Level') : ?>

                        <div class="col-md-4">
                            <?= Html::a('<i class="fas fa-check"></i> To Ln Mgr.', ['agreementtolinemgr', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                                'class' => 'btn btn-app bg-success',
                                'title' => 'Submit End Year Appraisal for Approval',
                                'data' => [
                                    'confirm' => 'Are you sure you want to submit End Year Appraisal?',
                                    'method' => 'post',
                                ]
                            ]) ?>
                        </div>

                    <?php endif; ?>


                    <?= ($model->EY_Appraisal_Status == 'Peer_1_Level' || $model->EY_Appraisal_Status == 'Peer_2_Level') ? Html::a('<i class="fas fa-play"></i> Send Back to Supervisor', ['sendbacktosupervisor', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                        'class' => 'btn btn-success ',
                        'title' => 'Send Peer Appraisal to Supervisor',
                        'data' => [
                            'confirm' => 'Are you sure you want to send Appraisal to Supervisor?',
                            'method' => 'post',
                        ]
                    ]) : '';
                    ?>


                    <!-- Overview Manager Actions -->

                    <?php if ($model->EY_Appraisal_Status == 'Overview_Manager' && $model->isOverview()) : ?>

                        <?= Html::a('<i class="fas fa-check"></i> Approve EY', ['approveey', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'mx-1 btn btn-app bg-success submitforapproval',
                            'title' => 'Approve End Year Appraisal',
                            'data' => [
                                'confirm' => 'Are you sure you want to Approve this End Year Appraisal ?',
                                'method' => 'post',
                            ]
                        ])
                        ?>

                        <?= Html::a('<i class="fas fa-times"></i> To Ln Manager', ['rejectey', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-danger ovrejectey',
                            'title' => 'Reject Goals Set by Appraisee',
                            'rel' => $model->Appraisal_No,
                            'rev' => $model->Employee_No,
                            /*'data' => [
            'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
            'method' => 'post',]*/
                        ])
                        ?>

                    <?php endif; ?>

                    <?php if ($model->EY_Appraisal_Status == 'Supervisor_Level') : ?>

                        <?= Html::a('<i class="fas fa-check"></i> Agreement..', ['sendtoagreementlevel', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-success submitforapproval',
                            'title' => 'Move Appraisal to  Agreement Level',
                            'data' => [
                                'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                                'method' => 'post',
                            ]
                        ])
                        ?>

                        <!-- Back to Appraisee -->

                        <?= Html::a('<i class="fas fa-times"></i> To Appraisee', ['rejectey', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'btn btn-app bg-danger rejectey',
                            'title' => 'Reject Goals Set by Appraisee',
                            'rel' => $model->Appraisal_No,
                            'rev' => $model->Employee_No,
                            /*'data' => [
                'confirm' => 'Are you sure you want to Reject this Mid Year Appraisal?',
                'method' => 'post',]*/
                        ])
                        ?>


                        <?= Html::a('<i class="fas fa-forward"></i> Overview', ['sendeytooverview', 'appraisalNo' => $model->Appraisal_No, 'employeeNo' => $model->Employee_No], [
                            'class' => 'mx-1 btn btn-app bg-success submitforapproval',
                            'title' => 'Move Appraisal to  Agreement Level',
                            'data' => [
                                'confirm' => 'Are you sure you want to send this End-Year Appraisal to Agreement Level ?',
                                'method' => 'post',
                            ]
                        ])
                        ?>

                    <?php endif; ?>


                </div>

            </div>

        </div>
    </div>
</div>

<!--Appraisal Indicator Steps-->



<!--/End Steps-->

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">




                <h3 class="card-title">Appraisal : <?= $model->Appraisal_No ?></h3>



                <?php
                if (Yii::$app->session->hasFlash('success')) {
                    print ' <div class="alert alert-success alert-dismissable">
                                 ';
                    echo Yii::$app->session->getFlash('success');
                    print '</div>';
                } else if (Yii::$app->session->hasFlash('error')) {
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

                            <?= $form->field($model, 'Appraisal_No')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Employee_No')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Employee_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Mid_Year_Overrall_rating')->textInput(['readonly' => true, 'disabled' => true]) ?>

                            <p class="parent"><span>+</span>
                                <?= $form->field($model, 'Overview_Rejection_Comments')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Level_Grade')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Job_Title')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Appraisal_Period')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?php $form->field($model, 'Appraisal_Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'Goal_Setting_Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'MY_Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'MY_End_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>

                            </p>


                        </div>
                        <div class="col-md-6">
                            <?= $form->field($model, 'EY_Start_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'EY_End_Date')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Goal_Setting_Status')->textInput(['readonly' => true, 'disabled' => true]) ?>
                            <?= $form->field($model, 'Overall_Score')->textInput(['readonly' => true, 'disabled' => true]) ?>


                            <p class="parent"><span>+</span>

                                <?= $form->field($model, 'Supervisor_Rejection_Comments')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'MY_Appraisal_Status')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?= $form->field($model, 'EY_Appraisal_Status')->textInput(['readonly' => true, 'disabled' => true]) ?>

                                <?= $form->field($model, 'Supervisor_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>

                                <?= $form->field($model, 'Overview_Manager_Name')->textInput(['readonly' => true, 'disabled' => true]) ?>
                                <?php $form->field($model, 'Overview_Manager_UserID')->textInput(['readonly' => true, 'disabled' => true]) ?>


                                <?= $form->field($model, 'Recomended_Action')->textInput(['readonly' => true, 'disabled' => true]) ?>



                            </p>



                        </div>
                    </div>
                </div>

                <!-- Mid Year Overview comment shit -->

                <div class="row">
                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Mid Year Line Manager Comments
                                </div>
                            </div>
                            <div class="card-body">
                                <?= ($model->MY_Appraisal_Status == 'Supervisor_Level') ? $form->field($model, 'Line_Manager_Mid_Year_Comments')->textArea(['rows' => 2, 'maxlength' => '140']) : '' ?>
                                <span class="text-success" id="ln-confirmation-my">Comment Saved Successfully.</span>

                                <?= ($model->MY_Appraisal_Status !== 'Supervisor_Level') ? $form->field($model, 'Line_Manager_Mid_Year_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]) : '' ?>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">

                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    Mid Year Overview Manager Comments
                                </div>
                            </div>
                            <div class="card-body">
                                <?= ($model->MY_Appraisal_Status == 'Overview_Manager') ? $form->field($model, 'Overview_Mid_Year_Comments')->textArea(['rows' => 2, 'maxlength' => '140']) : '' ?>
                                <span class="text-success" id="confirmation-my">Comment Saved Successfully.</span>

                                <?= ($model->MY_Appraisal_Status !== 'Overview_Manager') ? $form->field($model, 'Overview_Mid_Year_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]) : '' ?>
                            </div>
                        </div>

                    </div>
                </div>


                <div class="row">

                    <div class="col-md-6">



                        <div class="card">

                            <div class="card-header">
                                <div class="card-title">
                                    Line Manager Comments
                                </div>
                            </div>
                            <div class="card-body">
                                <?= ($model->EY_Appraisal_Status == 'Supervisor_Level') ? $form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'maxlength' => '140']) : '' ?>
                                <span class="text-success" id="confirmation-super">Comment Saved Successfully.</span>

                                <?= ($model->EY_Appraisal_Status !== 'Supervisor_Level') ? $form->field($model, 'Supervisor_Overall_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]) : '' ?>
                            </div>
                        </div>



                    </div>
                    <div class="col-md-6">



                        <div class="card">

                            <div class="card-header">
                                <div class="card-title">
                                    Overview Manager Comments
                                </div>
                            </div>
                            <div class="card-body">
                                <?= ($model->EY_Appraisal_Status == 'Overview_Manager') ? $form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'maxlength' => '140']) : '' ?>
                                <span class="text-success" id="confirmation">Comment Saved Successfully.</span>

                                <?= ($model->EY_Appraisal_Status !== 'Overview_Manager') ? $form->field($model, 'Over_View_Manager_Comments')->textArea(['rows' => 2, 'readonly' => true, 'disabled' =>  true]) : '' ?>
                            </div>
                        </div>

                    </div>

                </div>



                <?php ActiveForm::end(); ?>



            </div>
        </div>
        <!--end details card-->


        <?php if (1 == 1) { //$model->EY_Appraisal_Status !== 'Agreement_Level' 
        ?>
            <!--KRA CARD -->
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Employee Appraisal Key Result Areas (KRAs)</h4>
                    <div class="card-tools">
                        <?php ($model->Goal_Setting_Status == 'New' || $model->MY_Appraisal_Status == 'Appraisee_Level') ? Html::a('<i class="fa fa-plus mr-2"></i> Add', ['appraisalkra/create', 'Appraisal_No' => $model->Appraisal_No], ['class' => 'add btn btn-sm btn-outline-light']) : '' ?>
                    </div>
                </div>

                <div class="card-body">

                    <?php if (property_exists($card->Employee_Appraisal_KRAs, 'Employee_Appraisal_KRAs')) { ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td></td>
                                        <td class="text text-bold text-center">perspective</td>
                                        <td class="text text-bold text-center">KRA</td>
                                        <td class="text text-bold text-center">Objective</td>
                                        <td class="text text-bold text-center">Overall Rating</td>

                                        <td class="text text-bold text-center">Maximum Weight</td>
                                        <td class="text text-bold text-center">Total Width</td>
                                        <td class="text text-bold text-center">Mid Year Overall Rating</td>


                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($card->Employee_Appraisal_KRAs->Employee_Appraisal_KRAs as $k) {
                                        $mvtopip = Html::Checkbox('Move_To_PIP', $k->Move_To_PIP, ['readonly' => true, 'disabled' => true]);

                                    ?>

                                        <tr class="parent">

                                            <td><span>+</span></td>

                                            <td><?= !empty($k->Perspective) ? $k->Perspective : '' ?></td>
                                            <td><?= !empty($k->KRA) ? $k->KRA : '' ?></td>
                                            <td><?= !empty($k->Objective) ? $k->Objective : '' ?></td>
                                            <td><?= !empty($k->Overall_Rating) ? $k->Overall_Rating : '' ?></td>

                                            <td><?= !empty($k->Maximum_Weight) ? $k->Maximum_Weight : '' ?></td>
                                            <td><?= !empty($k->Total_Weigth) ? $k->Total_Weigth : '' ?></td>
                                            <td><?= !empty($k->Mid_Year_Overall_Rating) ? $k->Mid_Year_Overall_Rating : '' ?></td>


                                        </tr>

                                        <!-- Display KPIs Conditionary -->

                                        <?php
                                        if ($model->MY_Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()) {
                                            echo $this->render('_kpi_my_appraisee', ['model' => $model, 'k' => $k]);
                                        } else if ($model->MY_Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()) {
                                            echo $this->render('_kpi_my_supervisor', ['model' => $model, 'k' => $k]);
                                        } else if ($model->MY_Appraisal_Status == 'Agreement_Level' && $model->isAppraisee()) {
                                            echo $this->render('_kpi_my_agreement', ['model' => $model, 'k' => $k]);
                                        } else if ($model->EY_Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()) {
                                            echo $this->render('_kpi_ey_appraisee', ['model' => $model, 'k' => $k]);
                                        } else if ($model->EY_Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()) {
                                            echo $this->render('_kpi_ey_supervisor', ['model' => $model, 'k' => $k]);
                                        } else if ($model->EY_Appraisal_Status == 'Agreement_Level' && $model->isAppraisee()) {
                                            echo $this->render('_kpi_ey_agreement', ['model' => $model, 'k' => $k]);
                                        } else {
                                            echo $this->render('_kpi_readonly', ['model' => $model, 'k' => $k]);
                                        }
                                        ?>

                                        <!-- End KPI Display -->


                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>


                    <?php } ?>
                </div>
            </div>

            <!--END KRA CARD -->

            <!--Employee Appraisal  Competence --->

            <div class="card-ushurusecondary">
                <div class="card-header">
                    <h4 class="card-title">Employee Appraisal Competences</h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <td>#</td>

                                <td>Category</td>
                                <td>Maximum Weight</td>
                                <td>Mid Year Overall Rating</td>
                                <td>Overall Rating</td>

                            </tr>
                        </thead>
                        <?php if (property_exists($card->Employee_Appraisal_Competence, 'Employee_Appraisal_Competence')) { ?>

                            <tbody>
                                <?php foreach ($card->Employee_Appraisal_Competence->Employee_Appraisal_Competence as $comp) { ?>

                                    <tr class="parent">
                                        <td><span>+</span></td>

                                        <td><?= isset($comp->Category) ? $comp->Category : 'Not Set' ?></td>
                                        <td><?= isset($comp->Maximum_Weigth) ? $comp->Maximum_Weigth : 'Not Set' ?></td>
                                        <td><?= $comp->Mid_Year_Overall_Rating ?></td>
                                        <td><?= isset($comp->Overal_Rating) ? $comp->Overal_Rating : 'Not Set' ?></td>

                                    </tr>
                                    <!-- Behavior Lines conditional Rendering -->
                                    <?php
                                    if ($model->MY_Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()) {
                                        echo $this->render('_behaviour_my_appraisee', ['model' => $model, 'comp' => $comp]);
                                    } else if ($model->MY_Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()) {
                                        echo $this->render('_behaviour_my_supervisor', ['model' => $model, 'comp' => $comp]);
                                    } else if ($model->MY_Appraisal_Status == 'Agreement_Level' && $model->isAppraisee()) {
                                        echo $this->render('_behaviour_my_agreement', ['model' => $model, 'comp' => $comp]);
                                    } else if ($model->EY_Appraisal_Status == 'Appraisee_Level' && $model->isAppraisee()) {
                                        echo $this->render('_behaviour_ey_appraisee', ['model' => $model, 'comp' => $comp]);
                                    } else if ($model->EY_Appraisal_Status == 'Supervisor_Level' && $model->isSupervisor()) {
                                        echo $this->render('_behaviour_ey_supervisor', ['model' => $model, 'comp' => $comp]);
                                    } else if ($model->EY_Appraisal_Status == 'Agreement_Level' && $model->isAppraisee()) {
                                        echo $this->render('_behaviour_ey_agreement', ['model' => $model, 'comp' => $comp]);
                                    } else {
                                        echo $this->render('_behaviour_readonly', ['model' => $model, 'comp' => $comp]);
                                    }
                                    ?>
                                    <!-- End Behaviour Lines -->

                                <?php } ?>
                            </tbody>
                    </table>


                <?php } ?>
                </div>
            </div>

            <!--/Employee Appraisal  Competence --->




        <?php } ?>


    </div>
</div>

<!--My Bs Modal template  --->

<div class="modal fade bs-example-modal-lg bs-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title" id="myModalLabel" style="position: absolute">Performance Appraisal</h4>
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

<!-- Goal setting rejection by overview -->


<div id="backtolinemgr" style="display: none">

    <?= Html::beginForm(['appraisal/backtolinemgr'], 'post', ['id' => 'backtolinemgr-form']) ?>

    <?= Html::textarea('comment', '', ['placeholder' => 'Rejection Comment', 'row' => 4, 'class' => 'form-control', 'required' => true]) ?>

    <?= Html::input('hidden', 'Appraisal_No', '', ['class' => 'form-control']); ?>
    <?= Html::input('hidden', 'Employee_No', '', ['class' => 'form-control']); ?>


    <?= Html::submitButton('submit', ['class' => 'btn btn-warning', 'style' => 'margin-top: 10px']) ?>

    <?= Html::endForm() ?>
</div>




<div id="rejectmyappraisal" style="display: none">

    <?= Html::beginForm(['appraisal/mybacktolinemgr'], 'post', ['id' => 'mybacktolinemgr-form']) ?>

    <?= Html::textarea('comment', '', ['placeholder' => 'Rejection Comment', 'row' => 4, 'class' => 'form-control', 'required' => true]) ?>

    <?= Html::input('hidden', 'Appraisal_No', '', ['class' => 'form-control']); ?>
    <?= Html::input('hidden', 'Employee_No', '', ['class' => 'form-control']); ?>


    <?= Html::submitButton('submit', ['class' => 'btn btn-warning', 'style' => 'margin-top: 10px']) ?>

    <?= Html::endForm() ?>
</div>


<input type="hidden" name="url" value="<?= $absoluteUrl ?>">
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
    
     $('.add-trainingplan, .add').on('click',function(e){
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
      
      /*Update Learning Assessment and Add/update employee objectives/kpis */
      
      $('.update-learning, .add-objective').on('click',function(e){
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



/*Send Goals Back to Line Mgr*/

         $('.rejectgoals').on('click', function(e){
        e.preventDefault();
        const form = $('#backtolinemgr').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#backtolinemgr').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });//End click event on  GOals rejection-button click







/*Send My Back to Line Mgr*/

        $('.rejectmyappraisal').on('click', function(e){
        e.preventDefault();
        const form = $('#rejectmyappraisal').html(); 
        const Appraisal_No = $(this).attr('rel');
        const Employee_No = $(this).attr('rev');
        
        console.log('Appraisal No: '+Appraisal_No);
        console.log('Employee No: '+Employee_No);
        
        //Display the rejection comment form
        $('.modal').modal('show')
                        .find('.modal-body')
                        .append(form);
        
        //populate relevant input field with code unit required params
                
        $('input[name=Appraisal_No]').val(Appraisal_No);
        $('input[name=Employee_No]').val(Employee_No);
        
        //Submit Rejection form and get results in json    
        $('form#rejectmyappraisal-form').on('submit', function(e){
            e.preventDefault()
            const data = $(this).serialize();
            const url = $(this).attr('action');
            $.post(url,data).done(function(msg){
                    $('.modal').modal('show')
                    .find('.modal-body')
                    .html(msg.note);
        
                },'json');
        });
        
        
    });//End click event on my appraisal overview back to line mgr





/*Commit Overview Manager Comment*/
     
     $('#confirmation').hide();
     $('#appraisalcard-over_view_manager_comments').change(function(e){
        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();
        if(Appraisal_No.length){
            
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Over_View_Manager_Comments';
            $.post(url,{'Over_View_Manager_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  

                    console.log(typeof msg);
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-over_view_manager_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });





       /*Commit Line Manager Comment*/
     
     $('#confirmation-super').hide();
     $('#appraisalcard-supervisor_overall_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Supervisor_Overall_Comments';
            $.post(url,{'Supervisor_Overall_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-supervisor_overall_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation-super').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });


    /*Commit Mid Year Overview Manager Comment*/
     
     $('#confirmation-my').hide();
     $('#appraisalcard-overview_mid_year_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Overview_Mid_Year_Comments';
            $.post(url,{'Overview_Mid_Year_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-overview_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-overview_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#confirmation-my').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });


     // Commit Line Manager Mid Year Comments 

     $('#ln-confirmation-my').hide();
     $('#appraisalcard-line_manager_mid_year_comments').change(function(e){

        const Comments = e.target.value;
        const Appraisal_No = $('#appraisalcard-appraisal_no').val();

       
        if(Appraisal_No.length){

      
            const url = $('input[name=url]').val()+'appraisal/setfield?field=Line_Manager_Mid_Year_Comments';
            $.post(url,{'Line_Manager_Mid_Year_Comments': Comments,'Appraisal_No': Appraisal_No}).done(function(msg){
                   //populate empty form fields with new data
                   
                  
                   $('#appraisalcard-key').val(msg.Key);
                  
                    console.table(msg);
                    if((typeof msg) === 'string') { // A string is an error
                        const parent = document.querySelector('.field-appraisalcard-line_manager_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = msg;
                      
                        
                    }else{ // An object represents correct details
                        const parent = document.querySelector('.field-appraisalcard-line_manager_mid_year_comments');
                        const helpbBlock = parent.children[2];
                        helpbBlock.innerText = ''; 
                        $('#ln-confirmation-my').show();
                        
                        
                    }
                    
                },'json');
            
        }     
     });


    
        
    });//end jquery

    

        
JS;

$this->registerJs($script);
