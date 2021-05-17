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
use frontend\models\Surrenderline;
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

class SurrenderlineController extends Controller
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
       $service = Yii::$app->params['ServiceName']['SurrenderLines'];
       $Requisition_No = Yii::$app->request->get('Request_No');
       $model = new Surrenderline();


        if($Requisition_No && !Yii::$app->request->post()){

            $model->Requisition_No = $Requisition_No;

            return $this->renderAjax('create', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'glAccounts' => $this->getGlaccounts(),
                'budgetCenters' => $this->getBudgetcenters(),
                'locations' => $this->getLocations(),
                'currencies' => $this->getCurrencies(),
            ]);

        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Surrenderline'],$model) ){
            
            $refresh = Yii::$app->navhelper->readByKey($service,Yii::$app->request->post()['Surrenderline']['Key']);
            $model->Key = $refresh->Key;
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
                'budgetCenters' => $this->getBudgetcenters(),
                'locations' => $this->getLocations(),
                'currencies' => $this->getCurrencies(),
            ]);
        }


    }


    public function actionUpdate(){
        $model = new Surrenderline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['SurrenderLines'];

        if(!isset(Yii::$app->request->post()['Surrenderline'])){
            $filter = [
                'Line_No' => Yii::$app->request->get('Line_No'),
            ];
            $result = Yii::$app->navhelper->getData($service,$filter);


            if(is_array($result)){
                //load nav result to model
                $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;
                //Yii::$app->recruitment->printrr($model);
            }else{
                Yii::$app->recruitment->printrr($result);
            }
        }




        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Surrenderline'],$model) ){

            $refresh = Yii::$app->navhelper->getData($service,['Line_No' => Yii::$app->request->post()['Surrenderline']['Line_No']]);
            $model->Key = $refresh[0]->Key;

            //Yii::$app->recruitment->printrr($model);

            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Line Updated Successfully. </div>' ];
            }else{
                return ['note' => '<div class="alert alert-danger">Error Updating Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'glAccounts' => $this->getGlaccounts(),
                'budgetCenters' => $this->getBudgetcenters(),
                'locations' => $this->getLocations(),
                'currencies' => $this->getCurrencies(),
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'functions' => $this->getFunctioncodes(),
            'glAccounts' => $this->getGlaccounts(),
            'budgetCenters' => $this->getBudgetcenters(),
            'locations' => $this->getLocations(),
            'currencies' => $this->getCurrencies(),
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['SurrenderLines'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['status' => true ,'note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['status' => false ,'note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionSetExpensedate(){
        $model = new Surrenderline();
        $service = Yii::$app->params['ServiceName']['SurrenderLines'];

           $model->Expense_Date = Yii::$app->request->post('Expense_Date');
           $model->Requisition_No = Yii::$app->request->post('Requisition_No');

           $model->Line_No = time();

        $line = Yii::$app->navhelper->postData($service, $model);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $line;

    }

    public function actionSetbudgetcenter(){
        $model = new Imprestline();
        $service = Yii::$app->params['ServiceName']['ImprestRequestLine'];

        // Get Line to update

        $filter = [
            'Line_No' => Yii::$app->request->post('Line_No'),
        ];
        $res = Yii::$app->navhelper->getData($service, $filter);
        $model = Yii::$app->navhelper->loadmodel($res[0],$model);

        $model->Shortcut_Dimension_2_Code = Yii::$app->request->post('Shortcut_Dimension_2_Code');

        $line = Yii::$app->navhelper->updateData($service, $model);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $line;

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
        //return ArrayHelper::map($result,'Code','Name');
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');


    }

    /* Get Budget Centers*/

    public function getBudgetcenters(){
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = ['Global_Dimension_No' => 2];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        // return ArrayHelper::map($result,'Code','Name');
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');


    }

    /* Get Currencies*/

    public function getCurrencies(){
        $service = Yii::$app->params['ServiceName']['Currencies'];
        $filter = ['Description' => '<> " "'];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        // return ArrayHelper::map($result,'Code','Description');
        return Yii::$app->navhelper->refactorArray($result,'Code','Description');
    }

    /* Get expense locations */

    public function getLocations(){
        $service = Yii::$app->params['ServiceName']['categoryTowns'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Town_Code','Town_Name');
    }

    /* Get GL Accounts */

    public function getGlaccounts(){
        $service = Yii::$app->params['ServiceName']['AccountList'];
        $filter = [];
        $result = \Yii::$app->navhelper->getData($service, $filter);

       //  return  ArrayHelper::map($result,'No','Name');

        return Yii::$app->navhelper->refactorArray($result,'No','Name');

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