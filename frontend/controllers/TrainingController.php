<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;

use frontend\models\Training;
use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\BadRequestHttpException;

use yii\web\Response;
use kartik\mpdf\Pdf;

class TrainingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete','view'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','list','create','update','delete','view'],
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


    public function actionCreate(){

        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingRequestHeader'];

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['Training']) || !Yii::$app->request->post()){


            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{
                Yii::$app->session->setFlash('error', 'Error : ' . $request, true);
                return $this->render('index');
            }
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Training'],$model) ){

            /*Read the card again to refresh Key in case it changed*/
           
            $refresh = Yii::$app->navhelper->readBykey($service, $model->key);
            $model->Key = $refresh->Key;
            
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Document saved Successfully.' );
                return $this->redirect(['view','No' => $result->Request_No]);

            }else{
                Yii::$app->session->setFlash('error','Error  '.$result );
                return $this->redirect(['index']);

            }

        }


        //Yii::$app->recruitment->printrr($model);

        return $this->render('create',[
            'model' => $model,
            'functions' => $this->getFunctioncodes(),
            'budgetCenters' => $this->getBudgetcenters(),
            
           
        ]);
    }




    public function actionUpdate(){
        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingRequestHeader'];
        $model->isNewRecord = false;


        $result = Yii::$app->navhelper->readBykey($service, Yii::$app->request->post('Key'));

        if(is_object($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;
        }else{
            Yii::$app->session->setFlash('error', $result);
             return $this->render('index');
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Training'],$model) ){
            
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->readByKey($service, $model->Key);;
            $model->Key = $refresh->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Record Updated Successfully.' );

                return $this->redirect(['view','No' => $result->Key]);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Record'.$result );
                return $this->render('index');

            }

        }

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'budgetCenters' => $this->getBudgetcenters(),
                                
            ]);
        }

        return $this->render('update',[
                'model' => $model,
                'functions' => $this->getFunctioncodes(),
                'budgetCenters' => $this->getBudgetcenters(),
                
        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['TrainingRequestHeader'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView(){
        $model = new Training();
        $service = Yii::$app->params['ServiceName']['TrainingRequestHeader'];

        $result = Yii::$app->navhelper->readByKey($service, Yii::$app->request->post('Key'));


        //load nav result to model
        $model = Yii::$app->navhelper->loadmodel($result, $model);
        // Yii::$app->recruitment->printrr($result);
        return $this->render('view',[
            'model' => $model,
            'header' => $result
        ]);
    }



    public function actionList(){

        $service = Yii::$app->params['ServiceName']['TrainingRequestList'];
        $filter = [
            //'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $result = [];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
       
        foreach($results as $item){

            
            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view'],['title' => 'View Claim.',
            'class'=>'btn btn-outline-primary btn-xs',
            'data' => [
                'params' => ['Key' => $item->Key],
                'method' => 'POST'
                ]
            ]);
            $updateLink = ($item->Status == 'New')?Html::a('<i class="fas fa-pen"></i>',['update'],['title' => 'Update Claim.',
            'class'=>'btn btn-outline-primary btn-xs',
            'data' => [
                'params' => ['Key' => $item->Key],
                'method' => 'POST'
                ]
            ]):'';
            if($item->Status == 'New'){
                $ApprovalLink = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->Request_No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);
            }

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Request_No,
                'Training_Area' => !empty($item->Training_Area)?$item->Training_Area:'',
                'Training_Program' => !empty($item->Training_Program)?$item->Training_Program:'',
                'Description' => !empty($item->Description)?$item->Description:'',
                'Start_Date' => !empty($item->Start_Date)?$item->Start_Date:'',
                'End_Date' => !empty($item->End_Date)?$item->End_Date:'',
                'Status' => !empty($item->Status)?$item->Status:'',
                'Actions' => $ApprovalLink.' '.$ViewLink.' '.$updateLink ,

            ];
        }

        return $result;
    }

    


   


    
   

   
    public function getEmployees(){
        $service = Yii::$app->params['ServiceName']['EmployeeList'];

        $employees = \Yii::$app->navhelper->getData($service);
        // Yii::$app->recruitment->printrr($employees);
        $data = [];
        $i = 0;
        if(is_array($employees)){

            foreach($employees as  $emp){
                $i++;
                if(!empty($emp->FullName) && !empty($emp->No)){
                    $data[$i] = [
                        'No' => $emp->No,
                        'Full_Name' => $emp->FullName
                    ];
                }

            }

        }

        return ArrayHelper::map($data,'No','Full_Name');
    }

    /* Call Approval Workflow Methods */

    public function actionSendForApproval($No)
    {
        $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];
       
        $data = [
            'documentType' => Yii::$app->params['Documents']['Safari'],
            'documentNo' => Yii::$app->request->get('No'),
            'uID' => Yii::$app->user->identity->{'User ID'}
            
        ];


        $result = Yii::$app->navhelper->codeunit($service,$data,'SubmitDocumentForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Request for Approval  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];

        $data = [
            'documentType' => Yii::$app->params['Documents']['Safari'],
            'documentNo' =>  Yii::$app->request->get('No'),
        ];


        $result = Yii::$app->navhelper->codeunit($service,$data,'CancelDocumentApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Approval Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
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

   
/** Update this method to use a Key instead of filterkey */
    public function actionSetfield($field){
        $service = 'MileageCard';
        $value = Yii::$app->request->post($field);
        $filterValue =Yii::$app->request->post('No'); 
        $filterKey = 'Claim_No';

        $result = Yii::$app->navhelper->Commit($service,$field,$value,$filterKey,$filterValue);
        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;
        return $result;
      
        
    }



}