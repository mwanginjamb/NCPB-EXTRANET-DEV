<?php
/**
 * Created by PhpStorm.
 * User: HP ELITEBOOK 840 G5
 * Date: 3/9/2020
 * Time: 4:09 PM
 */

namespace frontend\models;
use yii\base\Model;


class Safariline extends Model
{

public $Key;
public $Expense_Date;
public $Travel_From;
public $Travel_To;
public $Total_Distance;
public $Return_Date;
public $Nights_Spent;
public $Days_Spent;
public $Document_No;
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