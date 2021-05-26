<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentplan;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Objective;
use frontend\models\Trainingplan;
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

class ObjectiveController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup','index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index'],
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
                'only' => ['setfield'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
                    //'application/xml' => Response::FORMAT_XML,
                ],
            ]
        ];
    }


     public function actionSetfield($field){
        $service = 'EmployeeAppraisalKRAs';     
        $field = [ $field => \Yii::$app->request->post($field)];
        $Key = (Yii::$app->request->post('Key'))?Yii::$app->request->post('Key'):'';
        $result = Yii::$app->navhelper->Commit($service,$field,$Key);
        return $result;
        
    }

    public function actionIndex(){

        return $this->render('index');

    }

    public function actionCreate(){

        // Yii::$app->recruitment->printrr($this->GetKRAs());

        $model = new Objective() ;
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKRAs'];


        $model->Appraisal_Code = Yii::$app->request->get('Appraisal_Code');
        $model->Employee_No = Yii::$app->user->identity->{'Employee No_'};

        // Post Initial Data

        $res = Yii::$app->navhelper->postData($service,$model);

        // Load model with resultant data

        Yii::$app->navhelper->loadmodel($res,$model);


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Objective'],$model)  ){

            $result = Yii::$app->navhelper->postData($service,$model);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(is_object($result)){
                return ['note' => '<div class="alert alert-success">Key Result Area Line Added Successfully. </div>' ];
            }else{
                return ['note' => '<div class="alert alert-danger">Error : '.$result.'</div>'];
            }

        }//End Saving experience

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('create', [
                'model' => $model,
                'kra' => $this->GetKRAs()
            ]);
        }

        return $this->render('create',[
            'model' => $model,
            'kra' => $this->GetKRAs()
        ]);
    }


    public function actionUpdate($Key){
        $model = new Objective() ;
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKRAs'];
        
        $result = Yii::$app->navhelper->readByKey($service,$Key);


        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Objective'],$model) ){
            $result = Yii::$app->navhelper->updateData($service,$model);

            //Yii::$app->recruitment->printrr($result);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if(!is_string($result)){

                return ['note' => '<div class="alert alert-success ">Record Updated Successfully</div>'];
            }else{

                return ['note' => '<div class="alert alert-danger">Error : '.$result.'</div>' ];
            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'kra' => $this->GetKRAs()
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'kra' => $this->GetKRAs()
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['EmployeeAppraisalKRAs'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($ApplicationNo){
        $service = Yii::$app->params['ServiceName']['NewEmpObjectives'];


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


    public function GetKRAs() {
        $service = Yii::$app->params['ServiceName']['KRALookup'];
        $result = Yii::$app->navhelper->getData($service);

        return Yii::$app->navhelper->RefactorArray($result,'KRA_Code','Objective');


    }
}