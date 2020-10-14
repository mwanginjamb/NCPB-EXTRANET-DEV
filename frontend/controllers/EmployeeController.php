<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 2/26/2020
 * Time: 5:33 AM
 */

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;

use frontend\models\Employee;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class EmployeeController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => [],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['index'],
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
        $model = new Employee();
        $service = Yii::$app->params['ServiceName']['EmployeeCard'];
        $filter = [
            'No' => Yii::$app->user->identity->{'Employee No_'},
        ];
        $employee = \Yii::$app->navhelper->getData($service,$filter);
        $model = $this->loadtomodel($employee[0],$model);

        // Yii::$app->recruitment->printrr($model);
        return $this->render('index',[
            'model' => $model,
            'ethnicity' => $this->getEthnicGroups(),
            'regions' => $this->getRegions(),
            'stations' => $this->getStations(),
            'counties' => $this->getCounties(),
            'subCounties' => $this->getSubCounties(),
        ]);
    }

    // Get Ethic Groups

    public function getEthnicGroups(){
        $service = Yii::$app->params['ServiceName']['EthnicGroups'];
        $results = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as  $res){
                $i++;
                if(!empty($res->Code) && !empty($res->Description)){
                    $data[$i] = [
                        'Code' => $res->Code,
                        'Description' => $res->Description
                    ];
                }
            }
        }
        return ArrayHelper::map($data,'Code','Description');
    }

    // Get Regions

    public function getRegions(){
        $service = Yii::$app->params['ServiceName']['Regions'];
        $results = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as  $res){
                $i++;
                if(!empty($res->Region_Code) && !empty($res->Region_Name)){
                    $data[$i] = [
                        'Code' => $res->Region_Code,
                        'Description' => $res->Region_Name
                    ];
                }
            }
        }
        return ArrayHelper::map($data,'Code','Description');
    }

    // Stations

    public function getStations(){
        return [];
        $service = Yii::$app->params['ServiceName']['Stations'];
        $results = \Yii::$app->navhelper->getData($service);
        //Yii::$app->recruitment->printrr($results);
        $data = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as  $res){
                $i++;
                if(!empty($res->Station_Code) && !empty($res->Station_Name)){
                    $data[$i] = [
                        'Code' => $res->Station_Code,
                        'Description' => $res->Station_Name
                    ];
                }
            }
        }
        return ArrayHelper::map($data,'Code','Description');
    }

    public function getCounties(){
        $service = Yii::$app->params['ServiceName']['Counties'];
        $results = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as  $res){
                $i++;
                if(!empty($res->Code) && !empty($res->Name)){
                    $data[$i] = [
                        'Code' => $res->Code,
                        'Description' => $res->Name
                    ];
                }
            }
        }
        return ArrayHelper::map($data,'Code','Description');
    }

    // Get Sub counties

    public function getSubCounties(){
        $service = Yii::$app->params['ServiceName']['SubCounties'];
        $results = \Yii::$app->navhelper->getData($service);
        $data = [];
        $i = 0;
        if(is_array($results)){
            foreach($results as  $res){
                $i++;
                if(!empty($res->Sub_County_Code) && !empty($res->Subcounty_Name)){
                    $data[$i] = [
                        'Code' => $res->Sub_County_Code,
                        'Description' => $res->Subcounty_Name
                    ];
                }
            }
        }
        return ArrayHelper::map($data,'Code','Description');
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