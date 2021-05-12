<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:21 PM
 */

namespace frontend\controllers;



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

use frontend\models\Appraisalcard;

class AppraisalController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','signup','index','list','create','update','delete','view','supervisorlist','hrlist','extrasupervisorlist','closedlist'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','list','create','update','delete','view','supervisorlist','hrlist','extrasupervisorlist','closedlist'],
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
                'only' => [
				'list',
				'supervisorlist',
				'hrlist',
				'extrasupervisorlist',
				'closedlist'
				],
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

    public function actionClosedAppraisals(){

        return $this->render('closed');

    }

    public function actionExtraAppraisals(){

        return $this->render('extra');

    }

    public function actionHrAppraisals(){

        return $this->render('hr');

    }

    public function actionSupervisorAppraisals(){

        return $this->render('super');

    }




    public function actionCreate(){

        $model = new Claim();
        $service = Yii::$app->params['ServiceName']['MileageCard'];

        /*Do initial request */
        if(!isset(Yii::$app->request->post()['Leave']) && !Yii::$app->request->post()){


            $request = Yii::$app->navhelper->postData($service,$model);
            //Yii::$app->recruitment->printrr($request);
            if(is_object($request) )
            {
                Yii::$app->navhelper->loadmodel($request,$model);
            }else{
                Yii::$app->session->setFlash('error', 'Error : ' . $request, true);
                return $this->render('create',[
                    'model' => $model,
                    'safariRequests' => $this->safariRequests(),
                    'functions' => $this->getFunctioncodes(),
                    'budgetCenters' => $this->getBudgetcenters()
                ]);
            }
        }

        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Leave'],$model) ){


            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->findOne($service, 'Claim_No', $model->Claim_No);;
            $model->Key = $refresh->Key;
            
            $result = Yii::$app->navhelper->updateData($service,$model);
            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Claim saved Successfully.' );
                return $this->redirect(['view','No' => $result->Claim_No]);

            }else{
                Yii::$app->session->setFlash('error','Error  '.$result );
                return $this->redirect(['index']);

            }

        }


        //Yii::$app->recruitment->printrr($model);

        return $this->render('create',[
            'model' => $model,
            'safariRequests' => $this->safariRequests(),
             'functions' => $this->getFunctioncodes(),
             'budgetCenters' => $this->getBudgetcenters()
           
        ]);
    }




    public function actionUpdate(){
        $model = new Claim();
        $service = Yii::$app->params['ServiceName']['MileageCard'];
        $model->isNewRecord = false;

        $filter = [
            'Claim_No' => Yii::$app->request->get('No'),
        ];
        $result = Yii::$app->navhelper->getData($service,$filter);

        if(is_array($result)){
            //load nav result to model
            $model = Yii::$app->navhelper->loadmodel($result[0],$model) ;//$this->loadtomodeEmployee_Nol($result[0],$Expmodel);
        }else{
            Yii::$app->sessiom->setFlash('error', $result);
             return $this->render('update',[
            'model' => $model,
            'safariRequests' => $this->safariRequests(),
            'functions' => $this->getFunctioncodes(),
            'budgetCenters' => $this->getBudgetcenters()

        ]);
        }


        if(Yii::$app->request->post() && Yii::$app->navhelper->loadpost(Yii::$app->request->post()['Claim'],$model) ){
            $filter = [
                'Claim_No' => $model->Claim_No,
            ];
            /*Read the card again to refresh Key in case it changed*/
            $refresh = Yii::$app->navhelper->findOne($service, 'Claim_No', $model->Claim_No);;
            $model->Key = $refresh->Key;

            $result = Yii::$app->navhelper->updateData($service,$model);

            if(!is_string($result)){

                Yii::$app->session->setFlash('success','Record Updated Successfully.' );

                return $this->redirect(['view','No' => $result->Claim_No]);

            }else{
                Yii::$app->session->setFlash('success','Error Updating Record'.$result );
                return $this->render('update',[
                    'model' => $model,
                    'safariRequests' => $this->safariRequests(),
                     'functions' => $this->getFunctioncodes(),
                    'budgetCenters' => $this->getBudgetcenters()
                ]);

            }

        }


        // Yii::$app->recruitment->printrr($model);
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('update', [
                'model' => $model,
                'safariRequests' => $this->safariRequests(),
                'functions' => $this->getFunctioncodes(),
                'budgetCenters' => $this->getBudgetcenters()
                
            ]);
        }

        return $this->render('update',[
            'model' => $model,
            'safariRequests' => $this->safariRequests(),
            'functions' => $this->getFunctioncodes(),
            'budgetCenters' => $this->getBudgetcenters()

        ]);
    }

    public function actionDelete(){
        $service = Yii::$app->params['ServiceName']['MileageCard'];
        $result = Yii::$app->navhelper->deleteData($service,Yii::$app->request->get('Key'));
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(!is_string($result)){

            return ['note' => '<div class="alert alert-success">Record Purged Successfully</div>'];
        }else{
            return ['note' => '<div class="alert alert-danger">Error Purging Record: '.$result.'</div>' ];
        }
    }

    public function actionView($No){
        // Yii::$app->recruitment->printrr(Yii::$app->user->identity->{'User ID'});
		$model = new Appraisalcard();
        $service = Yii::$app->params['ServiceName']['AppraisalCard'];

        $result = Yii::$app->navhelper->findOne($service, 'Appraisal_Code', $No);


        //load nav result to model
        $model = $this->loadtomodel($result, $model);

        return $this->render('view',[
            'model' => $model,
        ]);
    }



    public function actionList(){

        $service = Yii::$app->params['ServiceName']['AppraisalList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->Appraisal_Code))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i>',['update','No'=> $item->Appraisal_Code ],['title' => 'Update Appraisal Card.','class'=>'btn btn-outline-primary btn-xs']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Appraisal_Code,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                'Appraisal_Start_Date' => !empty($Appraisal_Start_Date)?$Appraisal_Start_Date:'',
                'Appraisal_End_Date' => !empty($item->Appraisal_End_Date)?$item->Appraisal_End_Date:'',
                'Remaining_Days' => !empty($item->Remaining_Days)?$item->Remaining_Days:'',
                'Total_KPI_x0027_s' => !empty($item->Total_KPI_x0027_s)?$item->Total_KPI_x0027_s:'',
                'Created_By' => !empty($item->Created_By)?$item->Created_By:'',
                'Created_On' => !empty($item->Created_On)?$item->Created_On:'',
                'Actions' => $ViewLink ,

            ];
        }

        return $result;
    }
	
	// Get Supervisor List
	
	public function actionSupervisorlist(){

        $service = Yii::$app->params['ServiceName']['AppraisalListSupervisor'];
        $filter = [
            'Action_ID' => Yii::$app->user->identity->{'User ID'},
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->Appraisal_Code))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i>',['update','No'=> $item->Appraisal_Code ],['title' => 'Update Appraisal Card.','class'=>'btn btn-outline-primary btn-xs']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Appraisal_Code,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                'Appraisal_Start_Date' => !empty($Appraisal_Start_Date)?$Appraisal_Start_Date:'',
                'Appraisal_End_Date' => !empty($item->Appraisal_End_Date)?$item->Appraisal_End_Date:'',
                'Remaining_Days' => !empty($item->Remaining_Days)?$item->Remaining_Days:'',
                'Total_KPI_x0027_s' => !empty($item->Total_KPI_x0027_s)?$item->Total_KPI_x0027_s:'',
                'Created_By' => !empty($item->Created_By)?$item->Created_By:'',
                'Created_On' => !empty($item->Created_On)?$item->Created_On:'',
                'Actions' => $ViewLink ,

            ];
        }

        return $result;
    }

    // Get Hr List
	
	public function actionHrlist(){

        $service = Yii::$app->params['ServiceName']['AppraisalListHr'];
        $filter = [
            'Hr_User_ID' => Yii::$app->user->identity->{'User ID'},
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->Appraisal_Code))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i>',['update','No'=> $item->Appraisal_Code ],['title' => 'Update Appraisal Card.','class'=>'btn btn-outline-primary btn-xs']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Appraisal_Code,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                'Appraisal_Start_Date' => !empty($Appraisal_Start_Date)?$Appraisal_Start_Date:'',
                'Appraisal_End_Date' => !empty($item->Appraisal_End_Date)?$item->Appraisal_End_Date:'',
                'Remaining_Days' => !empty($item->Remaining_Days)?$item->Remaining_Days:'',
                'Total_KPI_x0027_s' => !empty($item->Total_KPI_x0027_s)?$item->Total_KPI_x0027_s:'',
                'Created_By' => !empty($item->Created_By)?$item->Created_By:'',
                'Created_On' => !empty($item->Created_On)?$item->Created_On:'',
                'Actions' => $ViewLink ,

            ];
        }

        return $result;
    }
	
	
	public function actionExtrasupervisorlist(){

        $service = Yii::$app->params['ServiceName']['AppraisalListExtraSupervisor'];
        $filter = [
            'Action_ID' => Yii::$app->user->identity->{'User ID'},
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        // Yii::$app->recruitment->printrr($results);
        $result = [];
        foreach($results as $item){

            if(empty($item->Appraisal_Code))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i>',['update','No'=> $item->Appraisal_Code ],['title' => 'Update Appraisal Card.','class'=>'btn btn-outline-primary btn-xs']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Appraisal_Code,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                'Appraisal_Start_Date' => !empty($Appraisal_Start_Date)?$Appraisal_Start_Date:'',
                'Appraisal_End_Date' => !empty($item->Appraisal_End_Date)?$item->Appraisal_End_Date:'',
                'Remaining_Days' => !empty($item->Remaining_Days)?$item->Remaining_Days:'',
                'Total_KPI_x0027_s' => !empty($item->Total_KPI_x0027_s)?$item->Total_KPI_x0027_s:'',
                'Created_By' => !empty($item->Created_By)?$item->Created_By:'',
                'Created_On' => !empty($item->Created_On)?$item->Created_On:'',
                'Actions' => $ViewLink ,

            ];
        }

        return $result;
    }
	
	
	public function actionClosedlist(){

        $service = Yii::$app->params['ServiceName']['AppraisalListClosed'];
        $filter = [
            //'Employee_No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        
        $results = \Yii::$app->navhelper->getData($service,$filter);
        
        $result = [];
        foreach($results as $item){

            if(empty($item->Appraisal_Code))
            {
                continue;
            }


            $ApprovalLink = $updateLink = $ViewLink =  '';
            $ViewLink = Html::a('<i class="fas fa-eye"></i>',['view','No'=> $item->Appraisal_Code ],['title' => 'View Appriasal Card..','class'=>'btn btn-outline-primary btn-xs']);
            $updateLink = Html::a('<i class="fas fa-pen"></i>',['update','No'=> $item->Appraisal_Code ],['title' => 'Update Appraisal Card.','class'=>'btn btn-outline-primary btn-xs']);
            

            $result['data'][] = [
                'Key' => $item->Key,
                'No' => $item->Appraisal_Code,
                'Employee_No' => !empty($item->Employee_No)?$item->Employee_No:'',
                'Employee_Name' => !empty($item->Employee_Name)?$item->Employee_Name:'',
                'Department' => !empty($item->Department)?$item->Department:'',
                'Appraisal_Start_Date' => !empty($Appraisal_Start_Date)?$Appraisal_Start_Date:'',
                'Appraisal_End_Date' => !empty($item->Appraisal_End_Date)?$item->Appraisal_End_Date:'',
                'Remaining_Days' => !empty($item->Remaining_Days)?$item->Remaining_Days:'',
                'Total_KPI_x0027_s' => !empty($item->Total_KPI_x0027_s)?$item->Total_KPI_x0027_s:'',
                'Created_By' => !empty($item->Created_By)?$item->Created_By:'',
                'Created_On' => !empty($item->Created_On)?$item->Created_On:'',
                'Actions' => $ViewLink ,

            ];
        }

        return $result;
    }


    public function getCovertypes(){
        $service = Yii::$app->params['ServiceName']['MedicalCoverTypes'];

        $results = \Yii::$app->navhelper->getData($service);
        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                if(!empty($res->Code) && !empty($res->Description)){
                    $result[$i] =[
                        'Code' => $res->Code,
                        'Description' => $res->Description
                    ];
                    $i++;
                }

            }
        }
        return ArrayHelper::map($result,'Code','Description');
    }

    /* My Imprests*/

    public function getmyimprests(){
        $service = Yii::$app->params['ServiceName']['PostedImprestRequest'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Surrendered' => false,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_Amount
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }

    /*Get Staff Loans */

    public function getLoans(){
        $service = Yii::$app->params['ServiceName']['StaffLoans'];

        $results = \Yii::$app->navhelper->getData($service);
        return ArrayHelper::map($results,'Code','Loan_Name');
    }

    /* Get My Posted Imprest Receipts */

    public function getimprestreceipts($imprestNo){
        $service = Yii::$app->params['ServiceName']['PostedReceiptsList'];
        $filter = [
            'Employee_No' => Yii::$app->user->identity->Employee[0]->No,
            'Imprest_No' => $imprestNo,
        ];

        $results = \Yii::$app->navhelper->getData($service,$filter);

        $result = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as $res){
                $result[$i] =[
                    'No' => $res->No,
                    'detail' => $res->No.' - '.$res->Imprest_No
                ];
                $i++;
            }
        }
        // Yii::$app->recruitment->printrr(ArrayHelper::map($result,'No','detail'));
        return ArrayHelper::map($result,'No','detail');
    }

    public function getLeaveTypes($gender = ''){
        $service = Yii::$app->params['ServiceName']['LeaveTypesSetup']; //['leaveTypes'];
        $filter = [
            // 'Gender' => $gender,
            //'Gender' => !empty(Yii::$app->user->identity->Employee[0]->Gender)?Yii::$app->user->identity->Employee[0]->Gender:'Both'
        ];

        $result = \Yii::$app->navhelper->getData($service,$filter);
        return ArrayHelper::map($result,'Code','Description');
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

    /* Call Appraisal Status Change  Methods */

    public function actionSubmit()
    {
        $service = Yii::$app->params['ServiceName']['AppraisalStatusChange'];
       
        $data = [
            'appraisalNo' => Yii::$app->request->get('appraisalNo'),
            'employeeNo' => Yii::$app->request->get('employeeNo'),
            'sendEmail' => true,
            'approvalURL' => Yii::$app->urlManager->createAbsoluteUrl(['appraisal/view', 'No' => Yii::$app->request->get('appraisalNo')])
            
        ];


         $result = Yii::$app->navhelper->codeunit($service,$data,'IanSendNewEmployeeForApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', ' Request Sent to Supervisor Successfully.', true);
            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error   : '. $result);
            return $this->redirect(['index']);

        }
    }

    /*Cancel Approval Request */

    public function actionCancelRequest($No)
    {
         $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];

        $data = [
            'documentType' => Yii::$app->params['Documents']['Claim'],
            'documentNo' =>  Yii::$app->request->get('No'),
        ];


        $result = Yii::$app->navhelper->codeunit($service,$data,'CancelDocumentApproval');

        if(!is_string($result)){
            Yii::$app->session->setFlash('success', 'Request Cancelled Successfully.', true);
            return $this->redirect(['view','No' => $No]);
        }else{

            Yii::$app->session->setFlash('error', 'Error   : '. $result);
            return $this->redirect(['view','No' => $No]);

        }
    }


     


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