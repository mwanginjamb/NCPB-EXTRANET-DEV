<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "poll".
 *
 * @property int $id
 * @property int|null $resolution_id
 * @property string|null $poll_body
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $startdate
 * @property int|null $enddate
 */
class Poll extends \yii\db\ActiveRecord
{

    public function behaviors()
    {
        return [
            TimestampBehavior::class,

        ];
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'poll';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['resolution_id', 'created_at', 'updated_at'], 'integer'],
            [['poll_body','created_by'], 'string'],
            [['startdate', 'enddate'],'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'resolution_id' => 'Resolution ID',
            'poll_body' => 'Survey Subject',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'startdate' => 'Startdate',
            'enddate' => 'Enddate',
        ];
    }
}
