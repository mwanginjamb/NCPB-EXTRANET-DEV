<?php

/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/28/2020
 * Time: 12:27 AM
 */


namespace frontend\controllers;

use common\models\HrloginForm;
use common\models\SignupForm;
use frontend\models\Appraisalcard;
use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use frontend\models\Applicantprofile;
use frontend\models\Employeerequisition;
use frontend\models\Employeerequsition;
use frontend\models\Job;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use frontend\models\Employee;
use yii\bootstrap4\Html as Bootstrap4Html;
use yii\web\Controller;
use yii\web\Response;

class AppraisalController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'vacancies', 'view', 'create', 'update', 'delete', 'myappraiseelist', 'eyagreementlist', 'eyappraiseelist', 'viewsubmitted'],
                'rules' => [
                    [
                        'actions' => ['vacancies'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index', 'vacancies', 'view', 'create', 'update', 'delete', 'myappraiseelist', 'eyagreementlist', 'eyappraiseelist', 'viewsubmitted'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['get'],
                    'reject' => ['POST']
                ],
            ],
            'contentNegotiator' => [
                'class' => ContentNegotiator::class,
                'only' => [
                    'list-gs-appraisee',
                    'list-gs-supervisor',
                    'list-gs-overview',
                    'list-my-appraisee',
                    'list-my-supervisor',
                    'list-my-overview',
                    'list-my-agreement',
                    'list-ey-appraisee',
                    'list-ey-supervisor',
                    'list-ey-overview',
                    'list-ey-agreement',
                    'list-ey-closed',

                    'setfield',

                ],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function beforeAction($action)
    {

        $ExceptedActions = ['ratings', 'target-status'];

        if (in_array($action->id, $ExceptedActions)) {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionGsSupervisor()
    {
        return $this->render('gssupervisor');
    }

    public function actionGsOverview()
    {
        return $this->render('gsoverview');
    }

    public function actionMyAppraisee()
    {
        return $this->render('myappraisee');
    }

    public function actionMySupervisor()
    {

        return $this->render('mysupervisor');
    }
    public function actionMyOverview()
    {
        return $this->render('myoverview');
    }
    public function actionMyAgreement()
    {

        return $this->render('myagreement');
    }

    public function actionEyAppraisee()
    {

        return $this->render('eyappraisee');
    }

    public function actionEySupervisor()
    {

        return $this->render('eysupervisor');
    }

    public function actionEyOverview()
    {
        return $this->render('eyOverview');
    }

    public function actionEyAgreement()
    {
        return $this->render('eyagreement');
    }

    public function actionEyClosed()
    {
        return $this->render('eyclosed');
    }

    public function actionRatings()
    {
        $data = Yii::$app->navhelper->dropDown('AppraisalRatings', 'Rating', 'Rating_Description');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }

    public function actionTargetStatus()
    {
        $data = [
            'Achieved' => 'Achieved',
            'Not_Achieved' => 'Not_Achieved'
        ];
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $data;
    }



    public function actionCommit()
    {
        $commitService = Yii::$app->request->post('service');
        $key = Yii::$app->request->post('key');
        $name = Yii::$app->request->post('name');
        $value = Yii::$app->request->post('value');

        $service = Yii::$app->params['ServiceName'][$commitService];
        $request = Yii::$app->navhelper->readByKey($service, $key);
        $data = [];
        if (is_object($request)) {
            $data = [
                'Key' => $request->Key,
                $name => $value
            ];
        } else {
            Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
            return ['error' => $request];
        }

        $result = Yii::$app->navhelper->updateData($service, $data);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
    }



    public function actionListGsAppraisee()
    {

        $service = Yii::$app->params['ServiceName']['ObjectiveSettingList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListGsSupervisor()
    {

        $service = Yii::$app->params['ServiceName']['LineMgrObjectiveApprovalList'];
        $filter = [
            'Supervisor_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }


    public function actionListGsOverview()
    {

        $service = Yii::$app->params['ServiceName']['OverviewMgrObjectiveApprovalList'];
        $filter = [
            'Overview_Manager' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListMyAppraisee()
    {

        $service = Yii::$app->params['ServiceName']['MYAppraiseelList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListMySupervisor()
    {

        $service = Yii::$app->params['ServiceName']['MYSupervisorList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }


    public function actionListMyOverview()
    {

        $service = Yii::$app->params['ServiceName']['MYOverviewList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        //Yii::$app->recruitment->printrr($appraisals);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListMyAgreement()
    {

        $service = Yii::$app->params['ServiceName']['MYAgreementlist'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListEyAppraisee()
    {

        $service = Yii::$app->params['ServiceName']['EYAppraiseeList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListEySupervisor()
    {

        $service = Yii::$app->params['ServiceName']['EYsupervisorList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListEyOverview()
    {

        $service = Yii::$app->params['ServiceName']['EYOverviewList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }

    public function actionListEyAgreement()
    {

        $service = Yii::$app->params['ServiceName']['EYAgreementList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }


    public function actionListEyClosed()
    {

        $service = Yii::$app->params['ServiceName']['ClosedAppraisalList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $appraisals = \Yii::$app->navhelper->getData($service, $filter);

        $result = [];

        if (is_array($appraisals)) {
            foreach ($appraisals as $req) {

                $Viewlink = Bootstrap4Html::a('<i class="fas fa-eye mx-1"></i> View', ['view', 'Key' => $req->Key], ['class' => 'btn btn-outline-primary btn-xs']);

                $result['data'][] = [
                    'Appraisal_No' => !empty($req->Appraisal_No) ? $req->Appraisal_No : 'Not Set',
                    'Employee_No' => !empty($req->Employee_No) ? $req->Employee_No : '',
                    'Employee_Name' => !empty($req->Employee_Name) ? $req->Employee_Name : 'Not Set',
                    'Level_Grade' => !empty($req->Level_Grade) ? $req->Level_Grade : 'Not Set',
                    'Job_Title' => !empty($req->Job_Title) ? $req->Job_Title : '',
                    'Appraisal_Period' =>  !empty($req->Appraisal_Period) ? $req->Appraisal_Period : '',
                    'Appraisal_Start_Date' =>  !empty($req->Appraisal_Start_Date) ? $req->Appraisal_Start_Date : '',
                    'Appraisal_End_Date' =>  !empty($req->Appraisal_End_Date) ? $req->Appraisal_End_Date : '',
                    'Action' =>   $Viewlink,

                ];
            }
        }

        return $result;
    }




    public function actionView($Key)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();


        $appraisal = Yii::$app->navhelper->readByKey($service, $Key);
        //Yii::$app->recruitment->printrr($appraisal);
        if (is_object($appraisal)) {
            $model = Yii::$app->navhelper->loadmodel($appraisal, $model);
        }


        return $this->render('view', [
            'model' => $model,
            'card' => $appraisal
        ]);
    }


    public function actionDashview()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => Yii::$app->request->get('Appraisal_No'),
            'Employee_No' => Yii::$app->request->get('Employee_No')
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);
        // Yii::$app->recruitment->printrr($appraisal);
        if (is_array($appraisal)) {
            $model = Yii::$app->navhelper->loadmodel($appraisal[0], $model);
        }

        //echo property_exists($appraisal[0]->Employee_Appraisal_KRAs,'Employee_Appraisal_KRAs')?'Exists':'Haina any';

        // Yii::$app->recruitment->printrr($appraisal[0]);


        return $this->render('dashview', [
            'model' => $model,
            'card' => $appraisal[0]
        ]);
    }



    public function actionSetfield($field)
    {
        $model = new  Appraisalcard();
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];

        $filter = [
            'Appraisal_No' => Yii::$app->request->post('Appraisal_No'),
        ];
        $result = Yii::$app->navhelper->getData($service, $filter);

        if (is_array($result)) {
            Yii::$app->navhelper->loadmodel($result[0], $model);
            $model->Key = $result[0]->Key;
            $model->$field = Yii::$app->request->post($field);
        }


        $result = Yii::$app->navhelper->updateData($service, $model);
        // Yii::$app->recruitment->printrr( $result);
        return $result;
    }

    public function actionViewsubmitted($Appraisal_No, $Employee_No)
    {
        // Yii::$app->recruitment->printrr(Yii::$app->user->identity);
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => $Appraisal_No,
            'Employee_No' => $Employee_No
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);

        if (is_array($appraisal)) {
            $model = Yii::$app->navhelper->loadmodel($appraisal[0], $model);
        }

        if ($model->isAppraisee()) {
            return $this->redirect(
                [
                    'view',
                    'Appraisal_No' => $Appraisal_No,
                    'Employee_No' => $Employee_No
                ]
            );
        }


        return $this->render('viewsubmitted', [
            'model' => $model,
            'card' => $appraisal[0],
            'peers' =>  ArrayHelper::map($this->getEmployees(), 'No', 'Full_Name'),
        ]);
    }

    //set peer1

    public function actionSetpeer1()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => Yii::$app->request->post('Appraisal_No'),
            //'Employee_No' => Yii::$app->request->get('Employee_No')
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);
        $model = Yii::$app->navhelper->loadmodel($appraisal[0], $model);
        $model->Peer_1_Employee_No = Yii::$app->request->post('Employee_No');
        //Update
        $result = Yii::$app->navhelper->updateData($service, $model);

        //Yii::$app->recruitment->printrr($result);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!is_string($result)) {
            //Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.', true);
            return ['note' => '<div class="alert alert-success alert-dismissable">Peer Set Successfully.</div>'];
        } else {

            // Yii::$app->session->setFlash('error', 'Error Rejecting Performance Appraisal Goals : '. $result);
            return ['note' => '<div class="alert alert-danger alert-dismissable">Error Setting Peer. </div>'];
        }
    }

    //Set Peer 2
    public function actionSetpeer2()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];
        $model = new Appraisalcard();

        $filter = [
            'Appraisal_No' => Yii::$app->request->post('Appraisal_No'),
            //'Employee_No' => Yii::$app->request->get('Employee_No')
        ];

        $appraisal = Yii::$app->navhelper->getData($service, $filter);
        $model = Yii::$app->navhelper->loadmodel($appraisal[0], $model);
        $model->Peer_2_Employee_No = Yii::$app->request->post('Employee_No');
        //Update
        $result = Yii::$app->navhelper->updateData($service, $model);

        //Yii::$app->recruitment->printrr($result);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!is_string($result)) {
            //Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.', true);
            return ['note' => '<div class="alert alert-success alert-dismissable">Peer 2 Set Successfully.</div>'];
        } else {

            // Yii::$app->session->setFlash('error', 'Error Rejecting Performance Appraisal Goals : '. $result);
            return ['note' => '<div class="alert alert-danger alert-dismissable">Error Setting Peer 2 </div>'];
        }
    }

    //Submit Appraisal to supervisor

    public function actionSubmit($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->codeunit($service, $data, 'IanSendGoalSettingForApproval');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['index']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Submitting Performance Appraisal : ' . $result);
            return $this->redirect(['index']);
        }
    }

    /*Supervisor Actions :Approve Reject*/



    //SendGoalSettingToOverview

    public function actionSendgoalsettingtooverview($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanSendGoalSettingToOverview');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Successfully sent to overview manager.', true);
            return $this->redirect(['gs-supervisor']);
        } else {
            Yii::$app->session->setFlash('error', 'Error sending to overview manager : ' . $result);
            return $this->redirect(['gs-supervisor']);
        }
    }




    // send back to line manager

    public function actionSendbacktolinemanager()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->Codeunit($service, $data, 'IanSendGoalSettingBackToLineManager');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Successfully sent to overview manager.', true);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        } else {
            Yii::$app->session->setFlash('error', 'Error sending to overview manager : ' . $result);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        }
    }



    public function actionApprove($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->IanApproveGoalSetting($service, $data);

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Approved Successfully.', true);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        } else {
            Yii::$app->session->setFlash('error', 'Error Approving Performance Appraisal Goals : ' . $result);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        }
    }


    /*Over Mid Year Approval*/



    public function actionOvapprovemy($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanApproveMYAppraisal');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Approved Successfully.', true);
            return $this->redirect(['my-overview']);
        } else {
            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['my-overview']);
        }
    }





    public function actionReject()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => Yii::$app->request->post('Appraisal_No'),
            'employeeNo' => Yii::$app->request->post('Employee_No'),
            'sendEmail' => 0,
            'approvalURL' => 1,
            'rejectionComments' => Yii::$app->request->post('comment')
        ];

        $result = Yii::$app->navhelper->IanSendGoalSettingBackToAppraisee($service, $data);
        //Response of this action is json only
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (!is_string($result)) {
            //Yii::$app->session->setFlash('success', 'Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.', true);
            return ['note' => '<div class="alert alert-success alert-dismissable">Perfomance Appraisal Goals Rejected and Sent Back to Appraisee Successfully.</div>'];
        } else {

            // Yii::$app->session->setFlash('error', 'Error Rejecting Performance Appraisal Goals : '. $result);
            return ['note' => '<div class="alert alert-danger alert-dismissable">Error Rejecting Performance Appraisal Goals </div>'];
        }
    }

    //Submit MY Appraisal for Approval

    public function actionSubmitmy($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->codeunit($service, $data, 'IanSendMYAppraisalForApproval');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['my-appraisee']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Submitting Mid Year Performance Appraisal : ' . $result);
            return $this->redirect(['my-appraisee']);
        }
    }


    // Send Mid Year  To Agreement



    public function actionSendMyToAgreement($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => '',
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendMYAppraisalToAgreement');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Perfomance Appraisal Pushed to Agreement Stage Successfully.', true);
            return $this->redirect(['my-supervisor']);
        } else {

            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['my-supervisor']);
        }
    }

    // Send MY Agreement Back to Appraisee


    public function actionMyToAppraisee()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];

        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');

        $data = [
            'appraisalNo' => Yii::$app->request->post('Appraisal_No'),
            'employeeNo' => Yii::$app->request->post('Employee_No'),
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/view', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => '',
        ];

        // IanSendMYAppraisaBackLineManagerFromAgreement

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendMYAppraisaBackLineManagerFromAgreement');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['myagreementsuper']);
            // return ['note' => '<div class="alert alert-success alert-dismissable">Mid Year Appraisal Rejected and Sent Back to Appraisee Successfully.</div>'];
        } else {

            Yii::$app->session->setFlash('error', 'Error Sending Mid Year Appraisal Back to Appraisee : ' . $result);
            return $this->redirect(['myagreementsuper']);
            // return ['note' => '<div class="alert alert-danger alert-dismissable">Error Rejecting Mid Year Appraisal : '. $result.'</div>'];

        }
    }


    public function actionAgreementToSupervisor($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => '',
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendMYAppraisaBackLineManagerFromAgreement');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Agreement Appraisal Sent Back to Line Manager Successfully.', true);
            return $this->redirect(['my-supervisor']);
        } else {

            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['my-supervisor']);
        }
    }


    // On agreement level , senf EY Back to ln Manager


    public function actionAgreementtolinemgr($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendEYAppraisalForApproval');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Perfomance Appraisal Agreement Submitted to Line Manager Successfully.', true);
            return $this->redirect(['ey-agreement']);
        } else {

            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['ey-agreement']);
        }
    }


    //Approve MY appraisal
    public function actionApprovemy($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->IanApproveMYAppraisal($service, $data);

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Approved Successfully.', true);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        } else {

            Yii::$app->session->setFlash('error', 'Error Approving Mid Year Appraisal : ' . $result);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        }
    }

    //Reject Mid-Year Appraisal

    public function actionRejectmy()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => Yii::$app->request->post('Appraisal_No'),
            'employeeNo' => Yii::$app->request->post('Employee_No'),
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            'rejectionComments' => Yii::$app->request->post('comment')
        ];

        $result = Yii::$app->navhelper->IanSendMYAppraisaBackToAppraisee($service, $data);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {
            //Yii::$app->session->setFlash('success', 'Mid Year Appraisal Rejected and Sent Back to Appraisee Successfully.', true);
            //return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
            return ['note' => '<div class="alert alert-success alert-dismissable">Mid Year Appraisal Rejected and Sent Back to Appraisee Successfully.</div>'];
        } else {

            //Yii::$app->session->setFlash('error', 'Error Rejecting Mid Year Appraisal : '. $result);
            //return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
            return ['note' => '<div class="alert alert-danger alert-dismissable">Error Rejecting Mid Year Appraisal : ' . $result . '</div>'];
        }
    }


    // Send MY Appraisal to Overview

    public function actionMyToOverview($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendMYAppraisalToOverViewManager');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Perfomance Appraisal Submitted Successfully to Overview.', true);
            return $this->redirect(['my-supervisor']);
        } else {

            Yii::$app->session->setFlash('error', 'Error  : ' . $result);
            return $this->redirect(['my-supervisor']);
        }
    }



    //Submit End Year Appraisal for Approval

    public function actionSubmitey($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo])
        ];

        $result = Yii::$app->navhelper->codeunit($service, $data, 'IanSendEYAppraisalForApproval');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Perfomance Appraisal Submitted Successfully.', true);
            return $this->redirect(['ey-appraisee']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Submitting End Year Performance Appraisal : ' . $result);
            return $this->redirect(['ey-appraisee']);
        }
    }


    //Approve EY appraisal
    public function actionApproveey($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1
        ];

        $result = Yii::$app->navhelper->codeunit($service, $data, 'IanApproveEYAppraisal');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Appraisal Approved Successfully.', true);
            return $this->redirect(['ey-overview']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Approving End Year Appraisal : ' . $result);
            return $this->redirect(['ey-overview']);
        }
    }

    //Reject End-Year Appraisal

    public function actionRejectey()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => Yii::$app->request->post('Appraisal_No'),
            'employeeNo' => Yii::$app->request->post('Employee_No'),
            'sendEmail' => 1,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            'rejectionComments' => Yii::$app->request->post('comment')
        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisaBackToAppraisee($service, $data);
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {
            //Yii::$app->session->setFlash('success', 'End Year Appraisal Rejected and Sent Back to Appraisee Successfully.', true);
            //return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
            return ['note' => '<div class="alert alert-success alert-dismissable">End Year Appraisal Rejected and Sent Back to Appraisee Successfully.</div>'];
        } else {

            //Yii::$app->session->setFlash('error', 'Error Rejecting End Year Appraisal : '. $result);
            //return $this->redirect(['viewsubmitted','Appraisal_No' => $appraisalNo,'Employee_No' => $employeeNo]);
            return ['note' => '<div class="alert  alert-danger alert-dismissable">Error  : ' . $result . '</div>'];
        }
    }

    //Overview reject ey



    public function actionOvrejectey()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => Yii::$app->request->post('Appraisal_No'),
            'employeeNo' => Yii::$app->request->post('Employee_No'),
            'sendEmail' => 1,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int
            'rejectionComments' => Yii::$app->request->post('comment')
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendEYAppraisaBackToLineManager');
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (!is_string($result)) {

            return ['note' => '<div class="alert alert-success alert-dismissable">End Year Appraisal Rejected and Sent Back to Appraisee Successfully.</div>'];
        } else {


            return ['note' => '<div class="alert  alert-danger alert-dismissable">Error  : ' . $result . '</div>'];
        }
    }

    //send appraisal to peer 1

    public function actionSendeytooverview($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]), //Ask korir to change this to text currently set to int

        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendEYAppraisalToOverview');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent to Overview Mgr. Successfully.', true);
            return $this->redirect(['ey-supervisor']);
        } else {

            Yii::$app->session->setFlash('error', 'Error  : ' . $result);
            return $this->redirect(['ey-supervisor']);
        }
    }

    //send appraisal to peer 2

    public function actionSendpeer2($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int

        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisalToPeer2($service, $data);

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent to Peer 2 Successfully.', true);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        } else {

            Yii::$app->session->setFlash('error', 'Error Sending Appraisal to Peer 2 for evaluation : ' . $result);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        }
    }

    //send End Year Appraisal Back to Supervisor from peer

    public function actionSendbacktosupervisor($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 0,
            'approvalURL' => 1, //Ask korir to change this to text currently set to int

        ];

        $result = Yii::$app->navhelper->IanSendEYAppraisaBackToSupervisorFromPeer($service, $data);

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent back to supervisor from peer  Successfully.', true);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        } else {

            Yii::$app->session->setFlash('error', 'Error Sending End Year Appraisal to Supervisor from Peer : ' . $result);
            return $this->redirect(['viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]);
        }
    }

    //Send End-Year Appraisal to Agreement Level

    public function actionSendtoagreementlevel($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),

        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendEYAppraisalToAgreementLevel');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'End Year Appraisal Sent Agreement Level  Successfully.', true);
            return $this->redirect(['ey-supervisor']);
        } else {

            Yii::$app->session->setFlash('error', 'Error  : ' . $result);
            return $this->redirect(['ey-supervisor']);
        }
    }

    //Get Employees this is just for selecting peer1 and Peer 2

    public function getEmployees()
    {
        $service = Yii::$app->params['ServiceName']['Employees'];

        $employees = \Yii::$app->navhelper->getData($service);
        $res = [];
        foreach ($employees as $e) {
            if (!empty($e->User_ID)) {
                $res[] = [
                    'No' => $e->No,
                    'Full_Name' => $e->Full_Name
                ];
            }
        }
        return $res;
    }

    //Generate Appraisal Report

    public function actionReport()
    {

        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];

        if (Yii::$app->request->post()) {

            $data = [
                'appraisalNo' => Yii::$app->request->post('appraisalNo'),
                'employeeNo' => Yii::$app->request->post('employeeNo')
            ];

            $path = Yii::$app->navhelper->CodeUnit($service, $data, 'IanGenerateReport');
            // Yii::$app->recruitment->printrr($path);
            if (!isset($path['return_value']) || !is_file($path['return_value'])) {

                return $this->render('report', [
                    'report' => false,
                    'message' => isset($path['return_value']) ? $path['return_value'] : 'Report is not available',
                ]);
            }
            $binary = file_get_contents($path['return_value']); //fopen($path['return_value'],'rb');
            $content = chunk_split(base64_encode($binary));
            //delete the file after getting it's contents --> This is some house keeping
            // unlink($path['return_value']);

            // Yii::$app->recruitment->printrr($path);
            return $this->render('report', [
                'report' => true,
                'content' => $content,
            ]);
        }

        return $this->render('report', [
            'report' => false,
            'content' => '',
        ]);
    }

    public function actionBacktoemp()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/view', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendGoalSettingBackToAppraisee');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Appraisal Sent Back to Appraisee Successfully.', true);
            return $this->redirect(['submitted']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Sending Appraisal Back to Appraisee  : ' . $result);
            return $this->redirect(['submitted']);
        }
    }


    public function actionBacktolinemgr()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendGoalSettingBackToLineManager');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Goals Sent Back Line Manager with comments Successfully.', true);
            return $this->redirect(['gs-overview']);
        } else {

            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['gs-overview']);
        }
    }

    public function actionMybacktolinemgr()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $appraisalNo = Yii::$app->request->post('Appraisal_No');
        $employeeNo = Yii::$app->request->post('Employee_No');
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/viewsubmitted', 'Appraisal_No' => $appraisalNo, 'Employee_No' => $employeeNo]),
            'rejectionComments' => Yii::$app->request->post('comment'),
        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanSendMYAppraisaBackLineManager');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Mid Year Appraisal Sent Back to Line Mgr Successfully.', true);
            return $this->redirect(['my-overview']);
        } else {

            Yii::$app->session->setFlash('error', 'Error : ' . $result);
            return $this->redirect(['my-overview']);
        }
    }

    /*Overview Mgr Goals Approval*/

    public function actionApprovegoals($appraisalNo, $employeeNo)
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
        $data = [
            'appraisalNo' => $appraisalNo,
            'employeeNo' => $employeeNo,
            'sendEmail' => 1,

        ];

        $result = Yii::$app->navhelper->CodeUnit($service, $data, 'IanApproveGoalSetting');

        if (!is_string($result)) {
            Yii::$app->session->setFlash('success', 'Goals Approved Successfully.', true);
            return $this->redirect(['gs-overview']);
        } else {

            Yii::$app->session->setFlash('error', 'Error Approving  Goals  : ' . $result);
            return $this->redirect(['gs-overview']);
        }
    }
}
