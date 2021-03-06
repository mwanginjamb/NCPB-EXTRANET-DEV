<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/21/2020
 * Time: 2:39 PM
 */

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AdminlteAsset;
use common\widgets\Alert;

AdminlteAsset::register($this);

$webroot = Yii::getAlias(@$webroot);
$absoluteUrl = \yii\helpers\Url::home(true);
$employee = (!Yii::$app->user->isGuest)?Yii::$app->user->identity->employee[0]:[];
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?= $absoluteUrl ?>favicon.jfif" rel="shortcut icon" type="image/vnd.microsoft.icon" />

    <!-- PWA SHIT -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#FEF207">
    <link rel="apple-touch-icon" href="/images/manifest/96.png"/>
    <meta name="apple-mobile-web-app-status-bar" content="#01A54F">
    
    <!-- / PWA SHIT -->

    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>

<?php $this->beginBody() ?>

<body class="hold-transition sidebar-mini accent-success layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-dark navbar-success">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="<?= $absoluteUrl ?>site" class="nav-link">Home</a>
                </li>
                <!--<li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li>-->
            </ul>

            <!-- SEARCH FORM -->
            <!--<form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>-->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                
             
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fas fa-th-large"></i>

                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <!--<span class="dropdown-item dropdown-header">15 Notifications</span>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-users mr-2"></i> 8 friend requests
                            <span class="float-right text-muted text-sm">12 hours</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-file mr-2"></i> 3 new reports
                            <span class="float-right text-muted text-sm">2 days</span>
                        </a>-->






                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest)? Html::a('<i class="fas fa-sign-in-alt "></i> Signup','/site/signup/',['class'=> 'dropdown-item']): ''; ?>

                        <div class="dropdown-divider"></div>

                        <?= (Yii::$app->user->isGuest)? Html::a('<i class="fas fa-lock-open"></i> Login','/site/login/',['class'=> 'dropdown-item']): ''; ?>

                        <div class="dropdown-divider"></div>

                        <div class="dropdown-divider"></div>

                        <?= (!Yii::$app->user->isGuest)? Html::a('<i class="fas fa-sign-out-alt"></i> Logout','/site/logout/',['class'=> 'dropdown-item']):''; ?>

                        <div class="dropdown-divider"></div>

                        <?= Html::a('<i class="fas fa-user"></i> Profile','employee/',['class'=> 'dropdown-item']); ?>

                        <div class="dropdown-divider"></div>

                         <?= Html::a('<i class="fas fa-address-book"></i> Contacts', $absoluteUrl.'site/staff',['class'=> 'dropdown-item']); ?>

                        <div class="dropdown-divider"></div>

                        <?= Html::a('<i class="fas fa-address-book"></i> Surveys', $absoluteUrl.'poll',['class'=> 'dropdown-item']); ?>

                    </div>
                </li>
               <!-- <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="false" href="#">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>-->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-light-success elevation-4" >
            <!-- Brand Logo -->
            <a href="<?= $absoluteUrl ?>site" class="brand-link navbar-warning">
                <img src="<?= $webroot ?>/images/Logo.jpg" alt="NCPB Logo" class="brand-image img-circle elevation-3"
                     style="opacity: .8">
                <span class="brand-text font-weight-light">NCPB</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= $webroot ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="<?= $absoluteUrl ?>employee/" class="d-block"><?= (!Yii::$app->user->isGuest)? ucwords($employee->First_Name.' '.$employee->Last_Name): ''?></a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                             with font-awesome or any other icon font library -->


<!--Approval Management -->
                        <?php if(!Yii::$app->user->isGuest): ?>
                        <li class="nav-item has-treeview <?= currentCtrl('approvals')?'menu-open':'' ?>">

                            <a href="#" class="nav-link <?= currentCtrl('approvals')?'active':'' ?>">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Approval Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>approvals" class="nav-link <?= currentaction('approvals','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Approval Requests</p>
                                    </a>
                                </li>


                            </ul>
                        </li>
                        <?php endif; ?>
<!--end Aprroval Management-->


                        <!--Leave Management-->
                        <li class="nav-item has-treeview  <?= currentCtrl('leave')?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl('leave')?'active':'' ?>">
                                <i class="nav-icon fas fa-paper-plane"></i>
                                <p>
                                    Leave Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>leave/" class="nav-link <?= currentaction('leave','index')?'active':'' ?>">
                                        <i class="fa fa-door-open nav-icon"></i>
                                        <p>Leave List</p>
                                    </a>
                                </li>



                               


                            </ul>
                        </li>

<!--/ Leave Management-->




                        <!-- Imprest management --->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['imprest','surrender','claim','safari'])?'menu-open':'menu-close' ?>">
                            <a href="#" title="Performance Management" class="nav-link <?= Yii::$app->recruitment->currentCtrl(['imprest','surrender','claim'])?'active':'' ?>">
                                <i class="nav-icon fa fa-coins"></i>
                                <p>
                                    Imprest Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">


                               


                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>imprest" class="nav-link <?= Yii::$app->recruitment->currentaction('imprest','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Imprest List</p>
                                    </a>
                                </li>



                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>surrender" class="nav-link <?= Yii::$app->recruitment->currentaction('surrender','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Posted Imprest List</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>safari" class="nav-link <?= Yii::$app->recruitment->currentaction('safari','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Safari Requests</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>claim" class="nav-link <?= Yii::$app->recruitment->currentaction('claim','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p> Mileage Claims</p>
                                    </a>
                                </li>


                            </ul>

                        </li>


                      

                        <!--Payroll reports -->
                         <li class="nav-item has-treeview <?= currentCtrl(['payslip','p9'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl(['payslip','p9'])?'active':'' ?>">
                                <i class="nav-icon fa fa-file-invoice-dollar"></i>
                                <p>
                                    Payroll Reports
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>payslip" class="nav-link <?= currentaction('payslip','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate Payslip</p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>p9" class="nav-link <?= currentaction('p9','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Generate P9 </p>
                                    </a>
                                </li>

                            </ul>
                        </li>




                        <!--payroll reports-->

                        

                        <!-- Contract Management -->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['contract'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl(['contract'])?'active':'' ?>">
                                <i class="nav-icon fas fa-file-contract " ></i>
                                <p>
                                    Contract Management
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract" class="nav-link <?= currentaction('contract','index')?'active':'' ?>">
                                        <i class="fa fa-file-contract nav-icon"></i>
                                        <p>Contracts List </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract/nearing-expiry" class="nav-link <?= currentaction('contract','nearing-expiry')?'active':'' ?>">
                                        <i class="fa fa-file-contract nav-icon"></i>
                                        <p>Contracts Nearing Expiry </p>
                                    </a>
                                </li>


                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract/pbond-monitoring" class="nav-link <?= currentaction('contract','pbond-monitoring')?'active':'' ?>">
                                        <i class="fa fa-file-contract nav-icon"></i>
                                        <p>Perf.Bond Monitoring </p>
                                    </a>
                                </li>

                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract/consumables-report" class="nav-link <?= currentaction('contract','consumables-report')?'active':'' ?>">
                                        <i class="fa fa-file-invoice nav-icon"></i>
                                        <p>Consumables Report </p>
                                    </a>
                                </li>

                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract/vendors" class="nav-link <?= currentaction('contract','vendors')?'active':'' ?>">
                                        <i class="fa fa-users-cog nav-icon"></i>
                                        <p>Registered Vendors </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>contract/lpos" class="nav-link <?= currentaction('contract','lpos')?'active':'' ?>">
                                        <i class="fa fa-users-cog nav-icon"></i>
                                        <p>LPO Analysis </p>
                                    </a>
                                </li>

                               

                            </ul>
                        </li>




                        <!-- Recruitment -->


                         

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(Yii::$app->params['profileControllers'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= Yii::$app->recruitment->currentCtrl('recruitment')?'active':'' ?>">
                                <i class="nav-icon fas fa-briefcase " ></i>
                                <p>
                                   Employee Recruitment
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>recruitment/vacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment','vacancies')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Internal Job Vacancies </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>recruitment/externalvacancies" class="nav-link <?= Yii::$app->recruitment->currentaction('recruitment','externalvacancies')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>External Job Vacancies </p>
                                    </a>
                                </li>

                               

                            </ul>
                        </li>


                         <!-- Performance Appraisal Management -->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['appraisal'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl(['appraisal'])?'active':'' ?>">
                                <i class="nav-icon fas fa-briefcase " ></i>
                                <p>
                                    Performance Mgt.
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/goal-setting" class="nav-link <?= currentaction('appraisal','goal-setting')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Goal Setting List </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/goal-setting-super" class="nav-link <?= currentaction('appraisal','goal-setting-super')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Goal Setting (Supervisor) </p>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/goal-setting-hr" class="nav-link <?= currentaction('appraisal','goal-setting-hr')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Goal Setting (HR) </p>
                                    </a>
                                </li>





                                <!--Mid Year Appraisals-->
                                <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentaction('appraisal',['my-appraisee','my-supervisor','my-hr'])?'menu-open':'' ?>">
                                    <a href="#" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal',['my-appraisee','my-supervisor','my-hr'])?'active':'' ?>">
                                        <i class="nav-icon fa fa-balance-scale"></i>
                                        <p>
                                            Mid Year Appraisals
                                            <i class="fas fa-angle-left right"></i>
                                            <!--<span class="badge badge-info right">6</span>-->
                                        </p>
                                    </a>

                                    <ul class="nav nav-treeview"><!--Mid Year Appraisals Menu-->

                                        <li class="nav-item">
                                            <a href="<?= $absoluteUrl ?>appraisal/my-appraisee" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','my-appraisee')?'active':'' ?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>M-Y Appraisal (Appraisee) </p>
                                            </a>
                                        </li>

                                       

                                            <li class="nav-item">
                                                <a href="<?= $absoluteUrl ?>appraisal/my-supervisor" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','my-supervisor')?'active':'' ?>">
                                                    <i class="fa fa-check-square nav-icon"></i>
                                                    <p>M-Y Appraisal (Supervisor) </p>
                                                </a>
                                            </li>

                                        

                                        <li class="nav-item">
                                            <a href="<?= $absoluteUrl ?>appraisal/my-hr" class="nav-link <?= Yii::$app->recruitment->currentaction('appraisal','my-hr')?'active':'' ?>">
                                                <i class="fa fa-check-square nav-icon"></i>
                                                <p>M-Y Appraisal (HR) </p>
                                            </a>
                                        </li>

                                        

                                    </ul><!--End Mid Year Appraisals menu list-->

                                <!-- Supervisor List -->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal" class="nav-link <?= currentaction('appraisal','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Appraisal List </p>
                                    </a>
                                </li>
                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/supervisor-appraisals" class="nav-link <?= currentaction('appraisal','supervisor-appraisals')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Supervisor List </p>
                                    </a>
                                </li>

                                <!-- Extra Supervisor -->

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/extra-appraisals" class="nav-link <?= currentaction('appraisal','extra-appraisals')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Extra Supervisor List </p>
                                    </a>
                                </li>

                                <!-- Hr List -->

                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/hr-appraisals" class="nav-link <?= currentaction('appraisal','hr-appraisals')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>HR Appraisal List </p>
                                    </a>
                                </li>

                                <!-- Closed List -->

                                 <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>appraisal/closed-appraisals" class="nav-link <?= currentaction('appraisal','closed-appraisals')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Closed Appraisal List </p>
                                    </a>
                                </li>

                               

                            </ul>
                        </li>

                        <!----Training---->

                        <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['training'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl(['training'])?'active':'' ?>">
                                <i class="nav-icon fas fa-briefcase " ></i>
                                <p>
                                    Training
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>training" class="nav-link <?= currentaction('training','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Training Request List </p>
                                    </a>
                                </li>

                    

                               

                            </ul>
                        </li>

                        <!-- Procurement Management -->


                         <li class="nav-item has-treeview <?= Yii::$app->recruitment->currentCtrl(['procurement'])?'menu-open':'' ?>">
                            <a href="#" class="nav-link <?= currentCtrl(['appraisal'])?'active':'' ?>">
                                <i class="nav-icon fas fa-briefcase " ></i>
                                <p>
                                    E-Procurement
                                    <i class="fas fa-angle-left right"></i>
                                    <!--<span class="badge badge-info right">6</span>-->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="<?= $absoluteUrl ?>procurement" class="nav-link <?= currentaction('procurement','index')?'active':'' ?>">
                                        <i class="fa fa-check-square nav-icon"></i>
                                        <p>Supplier Application List </p>
                                    </a>
                                </li>

                    

                               

                            </ul>
                        </li>









                            </ul>
                        </li>


                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>


        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark"></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <!--<li class="breadcrumb-item"><a href="site">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>-->
                                <?=
                                Breadcrumbs::widget([
                                'itemTemplate' => "<li class=\"breadcrumb-item\"><i>{link}</i></li>\n", // template for all links
                                'homeLink' => [
                                'label' => Yii::t('yii', 'Home'),
                                'url' => Yii::$app->homeUrl,
                                ],
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                                ])
                                ?>
                            </ol>

                        </div><!-- /.col-6 bread ish -->

                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <?= $content ?>
                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->

        </div>
        <!-- /.content-wrapper -->


        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; NCPB -  <?= Html::encode(Yii::$app->name) ?> 2014 - <?= date('Y') ?>   <a href="#"> NATIONAL CEREALS AND PRODUCE BOARD</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b><?= Yii::signature() ?></b>
            </div>
        </footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->




    </div>

</body>


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage();

function currentCtrl($ctrl){
    $controller = Yii::$app->controller->id;

    if(is_array($ctrl)){
        if(in_array($controller,$ctrl)){
            return true;
        }
    }
    if($controller == $ctrl ){
        return true;
    }else{
        return false;
    }
}

function currentaction($ctrl,$actn){//modify it to accept an array of controllers as an argument--> later please
    $controller = Yii::$app->controller->id;
    $action = Yii::$app->controller->action->id;
    if($controller == $ctrl && $action == $actn){
        return true;
    }else{
        return false;
    }
}

?>
