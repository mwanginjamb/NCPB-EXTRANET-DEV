<?php

namespace frontend\controllers;

use Yii;
use common\models\Poll;
use common\models\PollSearch;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PollController implements the CRUD actions for Poll model.
 */
class PollController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Poll models.
     * @return mixed
     */
    public function actionIndex()
    {

        return $this->render('index');
    }

    /**
     * Displays a single Poll model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Poll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Poll();


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->startdate = strtotime($model->startdate);
            $model->enddate = strtotime($model->enddate);
            $model->created_by = Yii::$app->user->identity->getEmployeeNo();

            //Yii::$app->recruitment->printrr($model); exit;
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Poll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Poll model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Poll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Poll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Poll::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetsurveys(){
        $surveys = Poll::find()->all();

        $results =[];

        foreach($surveys as $s){

            $voteLink = Html::a('<i class="fa fa-check-square"></i>  Participate',['./pollchoice','id'=>$s->id],['class'=> 'btn vote ']);
            $surveychoice = Html::a('<i class="fa fa-plus"></i>  Add Survey Questions',['pollchoice/create','pid'=>$s->id],['class'=> 'btn add-choice']);
            $results['data'][] = [
                'survey' => $s->poll_body,
                'start_date' => date('d-M-Y', $s->startdate),
                'end_date' => date('d-M-Y', $s->enddate),
                'surveychoices' => $surveychoice,
                'participate' => $voteLink
            ];
        }
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $results;
    }
}
