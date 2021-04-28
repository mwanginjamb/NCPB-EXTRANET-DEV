<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use common\models\User;
use Yii;
use yii\base\Model;


class Safari extends Model
{

public $Key;
public $Safari_No;
public $Purpose;
public $Expected_Travel_Date;
public $Expected_Date_of_Return;
public $Employee_No;
public $Imprest_Accoount;
public $Employee_Name;
public $Shortcut_Dimension_1_Code;
public $Shortcut_Dimension_2_Code;
public $Total_Entitlements;
public $Status;
public $Action_ID;
public $Mode_of_Transport;
public $Total_KMs;
public $Employee_Department;
public $Department_Name;
public $Fleet_Request_No;
public $Created_On;
public $Created_By;
public $Last_Updated_On;
public $Last_Updated_By;
public $isNewRecord;

    

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [
            'Shortcut_Dimension_1_Code' => 'Function Code',
            'Shortcut_Dimension_2_Code' => 'Budget Center Code',
        ];
    }

    public function getLines(){
        $service = Yii::$app->params['ServiceName']['safariLine'];
        $filter = [
            'Document_No' => $this->Safari_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }

    public function getEarnings(){
        $service = Yii::$app->params['ServiceName']['safariEarnings'];
        $filter = [
            'Safari_No' => $this->Safari_No,
        ];

        $lines = Yii::$app->navhelper->getData($service, $filter);
        return $lines;

    }



}