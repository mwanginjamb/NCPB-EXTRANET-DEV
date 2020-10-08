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
use frontend\models\Imprestline;
use frontend\models\Leaveplanline;
use frontend\models\Weeknessdevelopmentplan;
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

class ImprestlineController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','create','update','delete','view'],
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
                'only' => ['uu'],
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
       $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];
       $Request_No = Yii::$app->request->get('Request_No');
       $model = new Imprestline() ;


        if($Request_No && !isset(Yii::$app->request->post()['Imprestline'])){

               $model->Imprest_No = $Request_No;

            return $this->renderAjax('create', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'glAccounts' => $this->getGlaccounts(),
                'budgetCenters' => $this->getBudgetcenters()
            ]);

        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Imprestline'],$model) ){


            $refresh = Yii::$app->navhelper->getData($service,['Line_No' => Yii::$app->request->post()['Imprestline']['Line_No']]);
            $model->Key = $refresh[0]->Key;
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           // Yii::$app->recruitment->printrr($refresh);
            // return $model;
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Imprest Line Created Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Creating Imprest Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'glAccounts' => $this->getGlaccounts(),
                'budgetCenters' => $this->getBudgetcenters()
            ]);
        }


    }


    public function actionUpdate(){
        $model = new Imprestline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];
        $filter = [
            'Line_No' => Yii::$app->request->get('Line_No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);


        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
            // Yii::$app->recruitment->printrr($model);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Imprestline'],$model) ){

            $refresh = Yii::$app->navhelper->getData($service,['Line_No' => Yii::$app->request->post()['Imprestline']['Line_No']]);
            $model->Key = $refresh[0]->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Imprest Line Updated Successfully. </div>' ];
            }else{
                return ['note' => '<div class="alert alert-danger">Error Updating Imprest Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'glAccounts' => $this->getGlaccounts(),
                'budgetCenters' => $this->getBudgetcenters()
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'functions' => $this->getFunctioncodes(),
            'glAccounts' => $this->getGlaccounts(),
            'budgetCenters' => $this->getBudgetcenters()
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionSetgl(){
        $model = new Imprestline();
        $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];

           $model->G_L_Account = Yii::$app->request->post('G_L_Account');
           $model->Imprest_No = Yii::$app->request->post('Imprest_No');
          // $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};
           $model->Line_No = time();

        $line = Yii::$app->navhelper->postData($service, $model);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $line;

    }

    public function actionSetenddate(){
        $model = new Imprestline();
        $service = Yii::$app->params['ServiceName']['Leave__Plan__Line'];

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No')
        ];
        $line = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($line)){
            Yii::$app->navhelper->loadmodel($line[0],$model);
            $model->Key = $line[0]->Key;
            $model->End_Date = date('Y-m-d',strtotime(Yii::$app->request->post('End_Date')));
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;
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



    /*Get Transaction Types */

    public function getTransactiontypes(){
        $service = Yii::$app->params['ServiceName']['PaymentTypes'];

        $result = \Yii::$app->navhelper->getData($service, []);
        return ArrayHelper::map($result,'Code','Description');
    }

    /* Get Dimension 1s*/


    public function getFunctioncodes(){
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = ['Global_Dimension_No' => 1 ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');


    }

    /* Get Budget Centers*/

    public function getBudgetcenters(){
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = ['Global_Dimension_No' => 2];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return ArrayHelper::map($result,'Code','Name');


    }

    /* Get GL Accounts */

    public function getGlaccounts(){
        $service = Yii::$app->params['ServiceName']['AccountList'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

        return  ArrayHelper::map($result,'No','Name');

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