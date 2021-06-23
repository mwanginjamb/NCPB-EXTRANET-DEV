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


    public function beforeAction($action) {
        $this->enableCsrfValidation = ($action->id !== "consumables-report"); // <-- here
        return parent::beforeAction($action);
    }



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
                    'delete' => ['post'],
                    
                ],
            ],
            'contentNegotiator' =>[
                'class' => ContentNegotiator::class,
                'only' => ['list','setfield','vendor-list','lpo-list'],
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

    public function actionVendors(){

        return $this->render('vendorlist');

    }

    public function actionLpos(){

        return $this->render('lpolist');

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
           


            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Document Updated Successfully.' );

                return $this->redirect(['view','No' => $result->Key]);

            }else{
                Yii::$app->session->setFlash('error','Error Updating Document '.$result );
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

         ($model->Start_Date == '0001-01-01')?$model->Start_Date = date('Y-m-d'): $model->Start_Date;
         ($model->End_Date == '0001-01-01')?$model->End_Date = date('Y-m-d'): $model->End_Date;
         ($model->Performance_Bond_Exp_Date == '0001-01-01')?$model->Performance_Bond_Exp_Date = date('Y-m-d'): $model->Performance_Bond_Exp_Date;
         ($model->Notify_Date == '0001-01-01')?$model->Notify_Date = date('Y-m-d'): $model->Notify_Date;
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

        // $result = Yii::$app->navhelper->findOne($service, 'Code', $No);
        $result = Yii::$app->navhelper->readByKey($service, $No);

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
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view'],[
                'class'=>'btn btn-outline-primary btn-xs',
                'data' => [
                    'method' => 'GET',
                    'params' => [
                        'No'=> $item->Key
                    ]
                ]

            ]);
            $Updatelink = Html::a('<i class="fas fa-pen"></i>',['update' ],[
                'class'=>'btn btn-outline-warning btn-xs mx-1',
                'data' => [
                    'method' => 'GET',
                    'params' => [
                        'Key'=> $item->Key
                    ]
                ]
            ]);
            $Deletelink = Html::a('<i class="fas fa-trash"></i>',['delete'],[
                'class'=>'btn btn-outline-danger delete btn-xs mx-1',
                'data' => [
                    'confirm' => 'Are you sure you want to delete this item?',
                    'method' => 'POST',
                    'params' => [
                        'Key'=> $item->Key
                    ]
                ]
            ]);
           

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
                'view' => $Viewlink.$Updatelink.$Deletelink
            ];
        }

        return $result;
    }


     public function actionVendorList(){
        $service = Yii::$app->params['ServiceName']['VendorList'];
        $filter = [];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Key ],['class'=>'btn btn-outline-primary btn-xs']);
            $Updatelink = Html::a('<i class="fas fa-pen"></i>',['update','Key'=> $item->Key ],['class'=>'btn btn-outline-warning btn-xs mx-1']);
            $Deletelink = Html::a('<i class="fas fa-trash"></i>',['delete','Key'=> $item->Key ],['class'=>'btn btn-outline-danger delete btn-xs mx-1']);
           

            $result['data'][] = [
                'No' => $item->No,
                'Name' => !empty($item->Name)?$item->Name:'',
                'Responsibility_Center' => !empty($item->Responsibility_Center)?number_format($item->Responsibility_Center):'',
                'Balance_Due_LCY' => !empty($item->Balance_Due_LCY)?number_format($item->Balance_Due_LCY):'',
                'Vendor_Type' => !empty($item->Vendor_Type)?$item->Vendor_Type:'',
                
                'view' => $Viewlink
            ];
        }

        return $result;
    }

    //LPO List


    public function actionLpoList(){
        $service = Yii::$app->params['ServiceName']['PurchaseOrderArchives'];
        $filter = [];

        $results = \Yii::$app->navhelper->getData($service,$filter);
        $result = [];
        foreach($results as $item){
            $link = $updateLink = $deleteLink =  '';
            $Viewlink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Key ],['class'=>'btn btn-outline-primary btn-xs']);
            $Updatelink = Html::a('<i class="fas fa-pen"></i>',['update','Key'=> $item->Key ],['class'=>'btn btn-outline-warning btn-xs mx-1']);
            $Deletelink = Html::a('<i class="fas fa-trash"></i>',['delete','Key'=> $item->Key ],['class'=>'btn btn-outline-danger delete btn-xs mx-1']);
           

            $result['data'][] = [
                'No' => $item->No,
                'Buy_from_Vendor_Name' => !empty($item->Buy_from_Vendor_Name)?$item->Buy_from_Vendor_Name:'',
                'Vendor_Authorization_No' => !empty($item->Vendor_Authorization_No)?$item->Vendor_Authorization_No:'',
                'Pay_to_Name' => !empty($item->Pay_to_Name)?$item->Pay_to_Name:'',
                'Posting_Date' => !empty($item->Posting_Date)?$item->Posting_Date:'',
                'Location_Code' => !empty($item->Location_Code)?$item->Location_Code:'',
                'Purchaser_Code' => !empty($item->Purchaser_Code)?$item->Purchaser_Code:'',
                'Document_Date' => !empty($item->Document_Date)?$item->Document_Date:'',
                'Payment_Terms_Code' => !empty($item->Payment_Terms_Code)?$item->Payment_Terms_Code:'',
                'Payment_Discount_Percent' => !empty($item->Payment_Discount_Percent)?$item->Payment_Discount_Percent:'',
                'Payment_Method_Code' => !empty($item->Payment_Method_Code)?$item->Payment_Method_Code:'',
                
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



    public function actionConsumablesReport()
    {


       // Yii::$app->recruitment->printrr($this->getItems());
        $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];


        if(Yii::$app->request->post()){
             
            $data = [
                'itemNo' =>Yii::$app->request->post('itemNo'),
                'locationCode' => Yii::$app->request->post('locationCode'),
                'balanceAtDate' =>  Yii::$app->request->post('balanceAtDate')
             ];
            $path = Yii::$app->navhelper->codeunit($service,$data,'DownloadStockBalanceReport');

            // Yii::$app->recruitment->printrr($path);

            if(!@is_file($path['return_value'])){
              
                return $this->render('consumables_report',[
                    'report' => false,
                    'p9years' => '',
                    'message' => @$path['return_value']
                ]);
            }
            $binary = file_get_contents($path['return_value']); //fopen($path['return_value'],'rb');

            $content = chunk_split(base64_encode($binary));
            //delete the file after getting it's contents --> This is some house keeping
            @unlink($path['return_value']);

           // Yii::$app->recruitment->printrr($path);
            return $this->render('consumables_report',[
                'report' => true,
                'content' => $content,
                'p9years' => '',
                'locations' =>  $this->getLocations(),
                'items' => $this->getItems(),
            ]);
        }

        return $this->render('consumables_report',[
            'report' => false,
            'locations' =>  $this->getLocations(),
            'items' => $this->getItems(),
        ]);
    }


     public function getItems(){
        $service = Yii::$app->params['ServiceName']['ItemList'];
        $result = \Yii::$app->navhelper->getData($service, ['Consumable_Item' => true]);
        return Yii::$app->navhelper->refactorArray($result,'No','Description');
    }

    public function getLocations(){

        $service = Yii::$app->params['ServiceName']['LocationList'];
        $result = \Yii::$app->navhelper->getData($service, []);
        return Yii::$app->navhelper->refactorArray($result,'Code','Name');
    }



    public function actionSetfield($field){
        $service = 'ContractCard';     
        $field = [ $field => \Yii::$app->request->post($field)];
        $Key = (Yii::$app->request->post('Key'))?Yii::$app->request->post('Key'):'';
        $result = Yii::$app->navhelper->Commit($service,$field,$Key);
        return $result;
        
    }



}