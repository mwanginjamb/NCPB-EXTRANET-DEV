<?php

namespace frontend\controllers;

use common\models\Poll;
use common\models\Pollresults;
use Yii;
use common\models\Pollchoice;
use common\models\PollchoiceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PollchoiceController implements the CRUD actions for Pollchoice model.
 */
class PollchoiceController extends Controller
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
     * Lists all Pollchoice models.
     * @return mixed
     */
    public function actionIndex($id)
    {
        $model = Pollchoice::find()->where(['poll_id' => $id] )->all();

        if(Yii::$app->request->isAjax){
            return $this->renderAjax('index', [
                'model' => $model,
            ]);
        }

        return $this->render('index', [
           'model' => $model,
        ]);
    }

    /**
     * Displays a single Pollchoice model.
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
     * Creates a new Pollchoice model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pollchoice();

        if ($model->load(Yii::$app->request->post())) {
            $model->created_by = Yii::$app->user->identity->getEmployeeNo();

            //return $this->redirect(['view', 'id' => $model->id]);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if($model->save()){
                return ['note' => '<div class="alert alert-success">Survey Choice Created Successfully.</div>'];
            }else{
                return ['note' => '<div class="alert alert-danger">Error Creating Survey Choice.</div>'];
            }
        }

        if(Yii::$app->request->isAjax){
            $model->poll_id = Yii::$app->request->get('pid');
            return $this->renderAjax('create', [
                'model' => $model,
                'pollmodel' => Poll::find()->where(['id' => Yii::$app->request->get('pid') ])->one()
            ]);
        }

        /*return $this->render('create', [
            'model' => $model,
            'pollmodel' => Poll::find()->where(['id' => Yii::$app->request->get('pid') ])->one()
        ]);*/
    }

    /**
     * Updates an existing Pollchoice model.
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
     * Deletes an existing Pollchoice model.
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
     * Finds the Pollchoice model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pollchoice the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pollchoice::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionVote(){
        $model = new Pollresults();


        if(Yii::$app->request->post()){
            $model->poll_id = Yii::$app->request->post('poll_id');
            $model->poll_choice_id = Yii::$app->request->post('choice');
            $model->created_by = Yii::$app->user->identity->getEmployeeNo();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            //validate double voting

            $voted = Pollresults::find()->where(['created_by' => Yii::$app->user->identity->getEmployeeNo() ,'poll_choice_id' => Yii::$app->request->post('choice') ])->count();

            if($voted){
                return ['note' => '<div class="alert alert-danger">Error: You have already taken this survey.</div>'];
            }

            if($model->save()){
                return ['note' => '<div class="alert alert-success">Survey Choice Recorded Successfully.</div>'];
            }else{
                return ['note' => '<div class="alert alert-warning">Error Recording Survey Choice.</div>'];
            }
        }



    }
}
