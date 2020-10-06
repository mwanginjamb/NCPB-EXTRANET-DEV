<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Leaveline extends Model
{

public $Key;
public $Leave_Code;
public $Leave_balance;
public $Start_Date;
public $Days;
public $End_Date;
public $Total_No_Of_Days;
public $Holidays;
public $Weekend_Days;
public $Days_Applied;
public $Balance_After;
public $Date_of_Reporting_Back;
public $Application_No;
public $Line_No;
public $isNewRecord;

    public function rules()
    {
        return [

        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }
}