<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\Safariline;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use frontend\models\Leave;
use frontend\models\Traininglines;
use yii\web\Response;
use kartik\mpdf\Pdf;

class TraininglinesController extends Controller
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
                'only' => ['list','setfield'],
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
       $service = Yii::$app->params['ServiceName']['TrainingRequestLine'];
       $model = new Traininglines();

        // Yii::$app->recruitment->printrr($this->getEmployees());
        if($No && !isset(Yii::$app->request->post()['Traininglines']) && !Yii::$app->request->post()){

               $model->Request_No = $No;
               $res = Yii::$app->navhelper->postData($service, $model);
               if(!is_string($res))
               {
                    Yii::$app->navhelper->loadpost($res, $model);
               }else {
                   
                    return '<div class="alert alert-danger">Error : '.$res.'</div>';
               }
        }
        
        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Traininglines'],$model) ){


            $refresh = Yii::$app->navhelper->readByKey($service, $model->Key);
            $model->Key = $refresh->Key;
            $result = Yii::$app->navhelper->updateData($service,$model);

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
            if(is_object($result)){

                return ['note' => '<div class="alert alert-success">Line Saved Successfully. </div>' ];
            }else{

                return ['note' => '<div class="alert alert-danger">Error Saving Line: '.$result.'</div>'];
            }

        }

        if(Yii::$app->request->isAjax){

            return $this->renderAjax('create', [
                'model' => $model,
                'employees' => $this->getEmployees()
            ]);
        }
    }

    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['EmployeeList'];
        $employees = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($employees,'No','FullName');
    
    }


    public function actionUpdate($Key=""){
        $model = new Traininglines();
        $model->isNewRecord = false;
        $service = Yii::$app->params['ServiceName']['TrainingRequestLine'];
        
        $result = Yii::$app->navhelper->readByKey($service,$Key);
        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
            
        }else{
            return '<div class="alert alert-danger">Error : '.$result.'</div>';
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Traininglines'],$model) ){

            $refresh = Yii::$app->navhelper->readByKey($service, Yii::$app->request->post()['Traininglines']['Key']);
           

           if(is_object($refresh)){
            $model->Key = $refresh->Key;
           }
            
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
                'employees' => $this->getEmployees()
               
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'employees' => $this->getEmployees()
            
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['TrainingRequestLine'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){
            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

  


  


    


}