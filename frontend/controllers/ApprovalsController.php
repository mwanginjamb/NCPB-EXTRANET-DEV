<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/25/2020
 * Time: 3:55 PM
 */


namespace frontend\controllers;

use common\models\User;
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

class ApprovalsController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
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


       
    }


    public function actionUpdate($ApplicationNo){
        
    }

    public function actionView($ApplicationNo){
        
    }


   
    

    public function actionList(){
        $service = Yii::$app->params['ServiceName']['DocumentApprovals'];

        $filter = [
            'Action_ID' => Yii::$app->user->identity->{'User ID'},
        ];
        $approvals = \Yii::$app->navhelper->getData($service,$filter);

       


        $result = [];

        if(!is_object($approvals)){
            foreach($approvals as $app){



                    $Approvelink = ($app->Status == 'Approval_Pending')? Html::a('Approve Request',['approve-request',
                        'app'=> $app->Document_No,
                        'Document_Type' => $app->Document_Type
                         ],
                        ['class'=>'btn btn-success btn-xs','data' => [
                        'confirm' => 'Are you sure you want to Approve this request?',
                        'method' => 'post',
                    ]]):'';
                    $Rejectlink = ($app->Status == 'Approval_Pending')? Html::a('Reject Request',['reject-request',
                        'Document_Type' => $app->Document_Type
                     ],['class'=>'btn btn-warning reject btn-xs',
                        'rel' => $app->Document_No,
                        ]): "";

                    
                    // @todo add if condition per doc type

                    if($app->Document_Type == 'Imprest') 
                    {
                         $detailsLink = Html::a('View',['imprest/view','No'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Surrender') {
                        $detailsLink = Html::a('View',['surrender/view','No'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Claim') {
                        $detailsLink = Html::a('View',['claim/view','No'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Leave') {
                        $detailsLink = Html::a('View',['leave/view','No'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }
                    elseif ($app->Document_Type == 'Safari') {
                        $detailsLink = Html::a('View',['safari/view','No'=> $app->Document_No ],['class'=>'btn btn-outline-info btn-xs','target' => '_blank']);
                    }else{
                        $detailsLink = '';
                    }

                   



                $result['data'][] = [
                    'Key' => $app->Key,
                    'Details' => $app->Document_Type,
                    'Sender_ID' => !empty($app->Sender_ID)?$this->getName($app->Sender_ID):'Not Set',
                    'Action_ID' => !empty($app->Action_ID)?$app->Action_ID:'',
                    'Submitted_On' => $app->Submitted_On,
                    'Action_Time' => $app->Action_Time,
                    'Status' => $app->Status,
                    'Document_No' => $app->Document_No,
                    'Approvelink' => $Approvelink,
                    'Rejectlink' => $Rejectlink,
                    'details' => $detailsLink

                ];
            }
        }


        return $result;
    }



    public function actionApproveRequest($app){

        $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];

        // Check if Document  Approval is setup in approval codeunit

        if(!array_key_exists(Yii::$app->request->get('Document_Type'), Yii::$app->params['Documents']))
        {
            Yii::$app->session->setFlash('error', 'Approval Workflow for this document is not supported in Extranet.');

            return $this->redirect(['index']);
        }

        $data = [
            'documentType' => Yii::$app->params['Documents'][Yii::$app->request->get('Document_Type')],
            'documentNo' =>  Yii::$app->request->get('app'),
        ];


        $result = Yii::$app->navhelper->codeunit($service,$data,'ApproveDocument');

        if(!is_string($result))
        {
            Yii::$app->session->setFlash('success', 'Document Approved Successfully.');

            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error: '.$result);
            return $this->redirect(['index']);

        }
       
    }

    public function actionRejectRequest(){
        $service = Yii::$app->params['ServiceName']['wsPortalWorkflow'];

        // Check if Document  Approval is setup in approval codeunit

        if(!array_key_exists(Yii::$app->request->get('Document_Type'), Yii::$app->params['Documents']))
        {
            Yii::$app->session->setFlash('error', 'Approval Workflow for this document is not supported in Extranet.');

            return $this->redirect(['index']);
        }

        $data = [
            'documentType' => Yii::$app->params['Documents'][Yii::$app->request->get('Document_Type')],
            'documentNo' =>  Yii::$app->request->get('app'),
        ];


        $result = Yii::$app->navhelper->codeunit($service,$data,'RejectDocument');

        if(!is_string($result))
        {
            Yii::$app->session->setFlash('success', 'Document Rejected Successfully.');

            return $this->redirect(['index']);
        }else{

            Yii::$app->session->setFlash('error', 'Error: '.$result);
            return $this->redirect(['index']);

        }
    }

    public function getName($userID){

        //get Employee No
        $user = \common\models\User::find()->where(['User ID' => $userID])->one();
        $No = $user->{'Employee No_'};
        //Get Employees full name
        $service = Yii::$app->params['ServiceName']['employees'];
        $filter = [
            'No' => $No
        ];

        $results = Yii::$app->navhelper->getData($service,$filter);
        return $results[0]->Full_Name;
    }




   

}