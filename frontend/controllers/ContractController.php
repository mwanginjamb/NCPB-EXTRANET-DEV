<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;
use frontend\models\Careerdevelopmentstrength;
use frontend\models\Employeeappraisalkra;
use frontend\models\Experience;
use frontend\models\Imprestcard;
use frontend\models\Imprestline;
use frontend\models\Imprestsurrendercard;
use frontend\models\Leaveplancard;
use frontend\models\Leave;
use frontend\models\Contract;
use frontend\models\Trainingplan;
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

class ContractController extends Controller
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

        $model = new Contract();
        $service = Yii::$app->params['ServiceName']['ContractCard'];

        /*Do initial request */
        if(!Yii::$app->request->post()){


            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{
                Yii::$app->session->setFlash('error', 'Error : ' . $request, true);
                return $this->redirect(['index']);
            }
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Contract'],$model) ){

            $result = Yii::$app->navhelper->readByKey($service, $model->Key);

           if(!is_string($result) )
            {
                $model->Key = $result->Key;
            }else{
                Yii::$app->session->setFlash('error', 'Error : ' . $request, true);
                return $this->render('create',[
                    'model' => $model,
                    'tenderTypes' => $this->getTenderTypes(),
                    'procurementMethods' => $this->getProcurementMethods(),
                    'contractors' => $this->getVendors(),
                    'function' => $this->getFunctioncodes(),
                    'budgetCenter' =>  $this->getBudgetcenters(),
                    'HrDepartments' => $this->getHrDepartments()
                    
                ]);
            }
            



            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Record Created Successfully.' );
                return $this->redirect(['view','No' => $result->Application_No]);

            }else{
                Yii::$app->session->setFlash('error','Error  '.$result );
                return $this->redirect(['index']);

            }

        }


        //Yii::$app->recruitment->printrr($model);

        return $this->render('create',[
            'model' => $model,
            'tenderTypes' => $this->getTenderTypes(),
                    'procurementMethods' => $this->getProcurementMethods(),
                    'contractors' => $this->getVendors(),
                    'function' => $this->getFunctioncodes(),
                    'budgetCenter' =>  $this->getBudgetcenters(),
                    'HrDepartments' => $this->getHrDepartments()
            
        ]);
    }




    public function actionUpdate($Key){
        $model = new Contract();
        $service = Yii::$app->params['ServiceName']['ContractCard'];
        $model->isNewRecord = false;

         $result = Yii::$app->navhelper->readByKey($service, $Key);

        if(!is_string($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result,$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->recruitment->printrr($result);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Contract'],$model) ){
            $filter = [
                'Application_No' => $model->Application_No,
            ];
            


            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Leave Header Updated Successfully.' );

                return $this->redirect(['view','No' => $result->Application_No]);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Leave Header '.$result );
                return $this->render('update',[
                    'model' => $model,
                    'tenderTypes' => $this->getTenderTypes(),
                    'procurementMethods' => $this->getProcurementMethods(),
                    'contractors' => $this->getVendors(),
                    'function' => $this->getFunctioncodes(),
                    'budgetCenter' =>  $this->getBudgetcenters(),
                    'HrDepartments' => $this->getHrDepartments()
                ]);

            }

        }


        // Yii::$app->recruitment->printrr($model);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'tenderTypes' => $this->getTenderTypes(),
                    'procurementMethods' => $this->getProcurementMethods(),
                    'contractors' => $this->getVendors(),
                    'function' => $this->getFunctioncodes(),
                    'budgetCenter' =>  $this->getBudgetcenters(),
                    'HrDepartments' => $this->getHrDepartments()

            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'tenderTypes' => $this->getTenderTypes(),
                    'procurementMethods' => $this->getProcurementMethods(),
                    'contractors' => $this->getVendors(),
                    'function' => $this->getFunctioncodes(),
                    'budgetCenter' =>  $this->getBudgetcenters(),
                    'HrDepartments' => $this->getHrDepartments()

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['ContractCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
        $model = new Contract();
        $service = Yii::$app->params['ServiceName']['ContractCard'];

        $result = Yii::$app->navhelper->findOne($service, 'Code', $No);

        //load nav result to model
        $model = $this->loadtomodel($result, $model);

        

        return $this->render('view',[
            'model' => $model,
        ]);
    }



    // Get imprest list

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['ContractList'];
        $filter = [
            // 'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Code ],['class'=>'btn btn-outline-primary btn-xs']);
            $Updatelink = Html::a('<i class="fas fa-pen"></i>',['update','Key'=> $item->Key ],['class'=>'btn btn-outline-warning btn-xs mx-1']);
           

            $result['data'][] = [
                'Code' => $item->Code,
                'Description' => !empty($item->Description)?$item->Description:'',
                'Total_Value' => !empty($item->Total_Value)?number_format($item->Total_Value):'',
                'Invoiced_Value' => !empty($item->Invoiced_Value)?number_format($item->Invoiced_Value):'',
                'Deliverables' => !empty($item->Deliverables)?$item->Deliverables:'',
                'Contractor_Name' => !empty($item->Contractor_Name)?$item->Contractor_Name:'',
                'Comments' => !empty($item->Comments)?$item->Comments:'',
                'Status' => $item->Status,
                'Start_Date' => $item->Start_Date,
                'End_Date' => $item->End_Date,
                'Procurement_Method' => !empty($item->Procurement_Method)?$item->Procurement_Method:'',
                'view' => $Viewlink.$Updatelink
            ];
        }

        return $result;
    }

    // Get Imprest  surrender list

    public function actionGetimprestsurrenders(){
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        //Yii::$app->recruitment->printrr( );
        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view-surrender','No'=> $item->No ],['class'=>'btn btn-outline-primary btn-xs']);
            if($item->Status == 'New'){
                $link = Html::a('<i class="fas fa-paper-plane"></i>',['send-for-approval','No'=> $item->No ],['title'=>'Send Approval Request','class'=>'btn btn-primary btn-xs']);

                $updateLink = Html::a('<i class="far fa-edit"></i>',['update','No'=> $item->No ],['class'=>'btn btn-info btn-xs']);
            }else if($item->Status == 'Pending_Approval'){
                $link = Html::a('<i class="fas fa-times"></i>',['cancel-request','No'=> $item->No ],['title'=>'Cancel Approval Request','class'=>'btn btn-warning btn-xs']);
            }

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->No,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Purpose' => !empty($item->Purpose)?$item->Purpose:'',
                'Imprest_Amount' => !empty($item->Imprest_Amount)?$item->Imprest_Amount:'',
                'Status' => $item->Status,
                'Action' => $link,
                'Update_Action' => $updateLink,
                'view' => $Viewlink
            ];
        }

        return $result;
    }


   

    public function getTenderTypes(){
        $service = Yii::$app->params['ServiceName']['TenderTypes']; 
        $result = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($result,'Tender_Type_Code','Tender_Type_Name');
    }

     public function getProcurementMethods(){
        $service = Yii::$app->params['ServiceName']['procurementMethods']; 
        $result = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($result,'Method_Code','Method_Description');
    }


    public function getVendors(){
        $service = Yii::$app->params['ServiceName']['VendorList']; 
        $result = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($result,'No','Name');
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

     public function getHrDepartments(){
        $service = Yii::$app->params['ServiceName']['HRdepartments']; 
        $result = \Yii::$app->navhelper->getData($service);
        return Yii::$app->navhelper->refactorArray($result,'Department_Code','Department_Description');
    }

   




    public function actionSetleavetype(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Leave_Code = Yii::$app->request->post('Leave_Code');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /*Set Receipt Amount */
    public function actionSetdays(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Days_To_Go_on_Leave = Yii::$app->request->post('Days_To_Go_on_Leave');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /*Set Start Date */
    public function actionSetstartdate(){
        $model = new Leave();
        $service = Yii::$app->params['ServiceName']['LeaveCard'];

        $filter = [
            'Application_No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Start_Date = Yii::$app->request->post('Start_Date');
        }

        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

    /* Set Imprest Type */

    public function actionSetimpresttype(){
        $model = new Imprestcard();
        $service = Yii::$app->params['ServiceName']['ImprestRequestCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_Type = Yii::$app->request->post('Imprest_Type');
        }


        $result = Yii::$app->navhelper->updateData($service,$model,['Amount_LCY']);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

    }

        /*Set Imprest to Surrend*/

    public function actionSetimpresttosurrender(){
        $model = new Imprestsurrendercard();
        $service = Yii::$app->params['ServiceName']['ImprestSurrenderCardPortal'];

        $filter = [
            'No' => Yii::$app->request->post('No')
        ];
        $request = Yii::$app->navhelper->getData($service, $filter);

        if(is_array($request)){
            Yii::$app->navhelper->loadmodel($request[0],$model);
            $model->Key = $request[0]->Key;
            $model->Imprest_No = Yii::$app->request->post('Imprest_No');
        }


        $result = Yii::$app->navhelper->updateData($service,$model);

        Yii::$app->response->format = \yii\web\response::FORMAT_JSON;

        return $result;

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

    /* Call Approval Workflow Methods */

    public function actionSendForApproval()
    {
        $service = Yii::$app->params['ServiceName']['IntegrationFuctions'];
        $No = Yii::$app->request->get('No');
        $data = [
            'documentType' => 1,
            'documentNo' => Yii::$app->request->get('No'),
            'currentLevel' => '',
            'sourceId' => ''
        ];


        $result = Yii::$app->navhelper->Integration($service,$data,'SendApprovalRequest');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Sending Imprest Request for Approval  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
        $service = Yii::$app->params['ServiceName']['PortalFactory'];

        $data = [
            'applicationNo' => $No,
        ];


        $result = Yii::$app->navhelper->PortalWorkFlows($service,$data,'IanCancelImprestForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Imprest Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error Cancelling Imprest Approval Request.  : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }



}