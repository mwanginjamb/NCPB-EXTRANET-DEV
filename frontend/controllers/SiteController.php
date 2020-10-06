<?php
namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Employee;
use yii\helpers\Html;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */



    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup','index'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','index','getemployee'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                ],
                /*'denyCallback' => function ($rule, $action) {
                    //throw new \Exception('You are not allowed to access this page');
                    return $this->goBack();
                }*/
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    ///'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $employee = $this->actionGetemployee()[0];

        //Yii::$app->recruitment->printrr($employee);
        $supervisor = $this->getSupervisor($employee->Supervisor_No);
        $balances = $this->Getleavebalance();

        return $this->render('index',[
            'employee' => $employee,
            'supervisor' => $supervisor,
            'balances' => $balances
            ]);
    }

    public function actionStaff(){
        return $this->render('staff');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'login';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();


        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->goBack();

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {

        if(Yii::$app->session->has('IdentityPassword')){
            Yii::$app->session->remove('IdentityPassword');
        }
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'login';
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->login($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->goHome();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    public function actionGetemployee(){

        $service = Yii::$app->params['ServiceName']['EmployeeCard'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $employee = \Yii::$app->navhelper->getData($service,$filter);
        return $employee;
    }

    public function getSupervisor($No){
        $service = Yii::$app->params['ServiceName']['EmployeeCard'];
        $filter = [
            'No' => $No
        ];
        $supervisor = \Yii::$app->navhelper->getData($service,$filter);
        if(is_array($supervisor)){
            return $supervisor[0];
        }else{
            return 'Not Set';
        }

    }

    public function Getleavebalance(){
        $result = [
            'Key' => 0,
            'Annual_Leave_Bal' => 0,
            'Maternity_Leave_Bal' => 0,
            'Paternity' => 0,
            'Study_Leave_Bal' => 0,
            'Compasionate_Leave_Bal' => 0,
            'Sick_Leave_Bal' => 0
        ];

        return $result;
        $service = Yii::$app->params['ServiceName']['leaveBalance'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];

        $balances = \Yii::$app->navhelper->getData($service,$filter);


        //print '<pre>';
        // print_r($balances);exit;

        foreach($balances as $b){
            $result = [
                'Key' => $b->Key,
                'Annual_Leave_Bal' => $b->Annual_Leave_Bal,
                'Maternity_Leave_Bal' => $b->Maternity_Leave_Bal,
                'Paternity' => $b->Paternity,
                'Study_Leave_Bal' => $b->Study_Leave_Bal,
                'Compasionate_Leave_Bal' => $b->Compasionate_Leave_Bal,
                'Sick_Leave_Bal' => $b->Sick_Leave_Bal
            ];
        }

        return $result;

    }

    //Get Staff list

     public function actionGetstaff(){
        $service = Yii::$app->params['ServiceName']['employees'];
       

        $staff = \Yii::$app->navhelper->getData($service);
        //Yii::$app->recruitment->printrr($staff);

        $result = [];
        foreach($staff as $leave){

            if(property_exists($leave,'Company_E_Mail' )){
                $Viewlink = Html::a('Contacts',['viewcontact','No'=> $leave->No ],['class'=>'btn btn-outline-warning contact btn-xs']);
            $emailLink = '<a href="mailto:'. $leave->Company_E_Mail .'" class="btn btn-outline-warning " title="Email this Staff">'.$leave->Company_E_Mail.'</a>';
           



            $result['data'][] = [
                'Key' => $leave->Key,
                'Employee_No' => !empty($leave->No)?$leave->No:'',
                'Full_Name' => !empty($leave->Full_Name)?$leave->Full_Name:'',
                'User_ID' => !empty($leave->User_ID)?$leave->User_ID:'',
                'Company_E_Mail' => !empty($leave->Company_E_Mail)?$emailLink:'',
                'Contract_Type' => !empty($leave->Contract_Type)?$leave->Contract_Type:'',
                
                'view' => $Viewlink
            ];
        }
       
       
            }
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
           return $result; 
            
    }

    //View contact

    public function actionViewcontact($No){
        $model = new Employee();
        $service = Yii::$app->params['ServiceName']['employeeCard'];
        $filter = [
            'No' => $No,
        ];
        $employee = \Yii::$app->navhelper->getData($service,$filter);
        $model = Yii::$app->navhelper->loadmodel($employee[0],$model);


        return $this->renderAjax('viewcontact',[
            'model' => $model,
        ]);
    }

    public function actionPriceadjustment(){
        return $this->render('priceadjustment');
    }
}
