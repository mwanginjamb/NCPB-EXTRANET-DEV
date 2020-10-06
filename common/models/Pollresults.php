<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;

use Yii;

/**
 * This is the model class for table "table_pollResults".
 *
 * @property int $id
 * @property int|null $poll_id
 * @property int|null $poll_choice_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Pollresults extends \yii\db\ActiveRecord
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
        return 'table_pollResults';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'poll_choice_id', 'created_at', 'updated_at'], 'integer'],
            [['created_by'], 'string']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'poll_id' => 'Poll ID',
            'poll_choice_id' => 'Poll Choice ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
