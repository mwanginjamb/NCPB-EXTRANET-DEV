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


class Traininglines extends Model
{

public $Key;
public $Employee_No;
public $Employee_Name;
public $Employee_ID;
public $Attending;
public $Request_No;
public $isNewRecord;

    

    public function rules()
    {
        return [
            [['Employee_No'],'required'],
            ['Attending', 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            
        ];
    }

    

    



}