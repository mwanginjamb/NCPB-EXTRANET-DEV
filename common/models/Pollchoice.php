<?php

namespace common\models;


use Yii;
use yii\behaviors\TimestampBehavior;
use common\models\Pollresults;

/**
 * This is the model class for table "table_pollChoice".
 *
 * @property int $id
 * @property string|null $choice_body
 * @property int|null $poll_id
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 */
class Pollchoice extends \yii\db\ActiveRecord
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
        return 'table_pollChoice';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['poll_id', 'created_at', 'updated_at'], 'integer'],
            [['choice_body','created_by'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'choice_body' => 'Choice Body',
            'poll_id' => 'Poll ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }

    public static function getPercentage($pollID,$choiceID)
    {

        $results = Pollresults::find()->where(['poll_id' => $pollID, 'poll_choice_id' => $choiceID])->count();
        $total = self::getTotalVotes($pollID);
        if($results > 0){
            $per = ($results / $total) * 100;
        }else{
            $per = 0;
        }
        return $per;
    }

    public static function getTotalVotes($pollID)
    {
        $total = Pollresults::find()->where(['poll_id' => $pollID])->count();
        return $total;
    }

    public static function getIndividualVotes($pollID,$choiceID)
    {
        $results = Pollresults::find()->where(['poll_id' => $pollID, 'poll_choice_id' => $choiceID])->count();
        return $results;
    }


}
