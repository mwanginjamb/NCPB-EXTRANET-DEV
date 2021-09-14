<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\Claimline;
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

class ClaimlineController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index','create','update','delete','view','list'],
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
                'only' => ['list'],
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

    public function actionCreate($No){
       $service = Yii::$app->params['ServiceName']['MileageLines'];
       $model = new Claimline();


        if($No && !Yii::$app->request->post()){

               $model->Claim_No = $No;
                        

               $res = Yii::$app->navhelper->postData($service, $model);
              //Yii::$app->recruitment->printrr($res);

               if(!is_string($res))
               {
                    Yii::$app->navhelper->loadpost($res, $model);

                    // Yii::$app->recruitment->printrr($model);
               }else {
                   
                    return '<div class="alert alert-danger">Error : '.$res.'</div>';
               }

           

        }
        

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Claimline'],$model) ){


             $refresh = Yii::$app->navhelper->readByKey($service, $model->Key);
            $model->Key = $refresh->Key;
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           // Yii::$app->recruitment->printrr($refresh);
            // return $model;
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Line Saved Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Saving Line: '.$result.'</div>'];
            }

        }

        $model->Date = ($model->Date == '0001-01-01')?Date('Y-m-d'):$model->Date;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'towns' => $this->getPostcodes(),
                'claimtype' => $this->getClaimtype(),
                'functions' => $this->getFunctioncodes(),
                'budgetCenters' => $this->getBudgetcenters()
            ]);
        }


    }


    public function actionUpdate($Key){
        $model = new Claimline() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['MileageLines'];
        
        $result = Yii::$app->navhelper->readByKey($service,$Key);

       

        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
            // Yii::$app->recruitment->printrr($model);
        }else{
            
            return ['note' => '<div class="alert alert-danger">'.$result.'</div>' ];
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Claimline'],$model) ){

            $refresh = Yii::$app->navhelper->readByKey($service, Yii::$app->request->post()['Claimline']['Key']);
            $model->Key = $refresh->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){
                return ['note' => '<div class="alert alert-success">Line Updated Successfully. </div>' ];
            }else{
                return ['note' => '<div class="alert alert-danger">Error Updating Line: '.$result.'</div>'];
            }

        }
        $model->Date = ($model->Date == '0001-01-01')?Date('Y-m-d'):$model->Date;
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'towns' => $this->getPostcodes(),
                'claimtype' => $this->getClaimtype(),
                'functions' => $this->getFunctioncodes(),
                'budgetCenters' => $this->getBudgetcenters()
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'towns' => $this->getPostcodes(),
            'claimtype' => $this->getClaimtype(),
            'functions' => $this->getFunctioncodes(),
            'budgetCenters' => $this->getBudgetcenters()
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['MileageLines'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    
    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['MileageLines'];
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


    




    /*Get Postal Code */

    public function getPostcodes(){
        $service = Yii::$app->params['ServiceName']['categoryTowns'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Town_Code','Town_Name');
    }


/*Get safaris*/


    public function getClaimtype(){
        $service = Yii::$app->params['ServiceName']['Safaris'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Claim_Type','Claim_Description');
    }


     public function getFunctioncodes(){
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = ['Global_Dimension_No' => 1 ];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');


    }

    /* Get Budget Centers*/

    public function getBudgetcenters(){
        $service = Yii::$app->params['ServiceName']['Dimensions'];
        $filter = ['Global_Dimension_No' => 2];
        $result = \Yii::$app->navhelper->getData($service, $filter);
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');

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