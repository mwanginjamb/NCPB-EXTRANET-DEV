<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Kpi;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use yii\web\Response;
use kartik\mpdf\Pdf;

class KpiController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','view','delete','update'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','view','delete','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['getexperience'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionCreate(){

        $model = new Kpi();
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPIs'];
        $model->isNewRecord = true;

        $KPIs = ArrayHelper::map($this->getKpi(Yii::$app->request->get('KRA_Code')),'code','description');
        //Yii::$app->recruitment->printrr($this->getKpi(Yii::$app->request->get('KRA_Code')),'code','description');

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Kpi'],$model) ){
            

            $model->Appraisal_Code = Yii::$app->request->get('Appraisal_No');
            $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
            $model->KRA_Code = Yii::$app->request->get('KRA_Code');


            $result = Yii::$app->navhelper->postData($service,$model);


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Appraisal KPI Added Successfully. </div>'];
            }else{
               
                return ['note' => '<div class="alert alert-danger">'.$result.'</div>'];

            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'KPIs' => $KPIs
            ]);
        }

        return $this->render('create',[
            'model' => $model,
            'KPIs' => $KPIs
        ]);
    }


    public function actionUpdate($Key){

        // Yii::$app->recruitment->printrr($this->getScoreCard());
        $model = new Kpi();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPIs'];

        $scoreCard = $this->getScoreCard();
        $KPIs = ArrayHelper::map($this->getKpi(Yii::$app->request->get('KRA_Code')),'code','description');
        
        $result = Yii::$app->navhelper->readByKey($service,$Key);
        if(!is_string($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
        }else{
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['note' => '<div class="alert alert-danger">'.$result.'</div>'];
            
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Kpi'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);

             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Record Updated Successfully. </div>'];
            }else{
                return ['note' => '<div class="alert alert-danger">'.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'scoreCard' => $scoreCard,
                'KPIs' =>  $KPIs,
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'scoreCard' => $scoreCard,
            'KPIs' =>  $KPIs
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKPIs'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully.</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Removing KPI</div>'];
        }
    }

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['leaveApplicationCard'];
        $leaveTypes = $this->getLeaveTypes();
        $employees = $this->getEmployees();

        $filter = [
            'Application_No' => $ApplicationNo
        ];

        $leave = Yii::$app->navhelper->getData($service, $filter);

        //load nav result to model
        $leaveModel = new Leave();
        $model = $this->loadtomodel($leave[0],$leaveModel);


        return $this->render('view',[
            'model' => $model,
            'leaveTypes' => ArrayHelper::map($leaveTypes,'Code','Description'),
            'relievers' => ArrayHelper::map($employees,'No','Full_Name'),
        ]);
    }


    public function actionApprovalRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->SendLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave request sent for approval Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error sending leave request for approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }

    public function actionCancelRequest($app){
        $service = Yii::$app->params['ServiceName']['Portal_Workflows'];
        $data = ['applicationNo' => $app];

        $request = Yii::$app->navhelper->CancelLeaveApprovalRequest($service, $data);

        if(is_array($request)){
            Yii::$app->session->setFlash('success','Leave Approval Request Cancelled Successfully',true);
            return $this->redirect(['index']);
        }else{
            Yii::$app->session->setFlash('error','Error Cancelling Leave Approval: '.$request,true);
            return $this->redirect(['index']);
        }
    }












    public function getScoreCard(){
        $service = Yii::$app->params['ServiceName']['ScoreCards'];
        $ratings = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($ratings,'Rating','Description');
    }

    public function getPerformancelevels(){
        $service = Yii::$app->params['ServiceName']['PerformanceLevel'];

        $ratings = \Yii::$app->navhelper->getData($service);
        return $ratings;
    }

    public function getCountries(){
        $service = Yii::$app->params['ServiceName']['Countries'];

        $res = [];
        $countries = \Yii::$app->navhelper->getData($service);
        foreach($countries as $c){
            if(!empty($c->Name))
                $res[] = [
                    'Code' => $c->Code,
                    'Name' => $c->Name
                ];
        }

        return $res;
    }


    // This is a perspective Objective Lookup function
    public function getKpi($KRA_Code){
        $service = Yii::$app->params['ServiceName']['PerspectiveObjectives'];
        $filter = [
            'KRA_Code' => $KRA_Code,
        ];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        $arr = [];
        $count = 0;

        if(is_array($result)){
            foreach($result as $res)
            {
                ++$count;
                if(!empty($res->KRA_Code) )
                {
                    $arr[$count] = [
                        'code' => $res->KPI,
                        'description' => $res->KPI
                    ];
                }

            }
        }

       return $arr;

    }

    public function loadtomodel($obj,$model){

        if(!is_object($obj)){
            return false;
        }
        $modeldata = (get_object_vars($obj)) ;
        foreach($modeldata as $key => $val){
            if(is_object($val)) continue;
            $model->$key = $val;
        }

        return $model;
    }
}