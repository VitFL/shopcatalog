<?php

namespace app\controllers;

use Yii;
use app\models\Shop;
use app\models\ShopSearch;
use app\models\BusinessHours;
use app\models\Model;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\filters\VerbFilter;

/**
 * ShopController implements the CRUD actions for Shop model.
 */
class ShopController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Shop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ShopSearch();
        $queryParams = Yii::$app->request->post();
        $dataProvider = $searchModel->search($queryParams);

        $date_picker = isset($queryParams['ShopSearch']['date_picker']) ? $queryParams['ShopSearch']['date_picker'] : false;
        $time_picker = isset($queryParams['ShopSearch']['time_picker']) ? $queryParams['ShopSearch']['time_picker'] : false;

        $search_params = ($date_picker) ?
            ['date'=>$date_picker, 'dayofweek'=>date('N', strtotime($date_picker))] :
            ['date'=>false,'dayofweek'=>false];

        $search_params['time']=($time_picker)?$time_picker:false;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'search_params' => $search_params,
        ]);
    }

    /**
     * Displays a single Shop model.
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
     * Creates a new Shop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */


    public function actionCreate()
    {
        $modelShop = new Shop;
        $modelsBusinessHours = [];

        if ($modelShop->load(Yii::$app->request->post())) {

            $modelsBusinessHours = Model::createMultiple(BusinessHours::classname());
            Model::loadMultiple($modelsBusinessHours, Yii::$app->request->post());

            // validate all models
            $valid = $modelShop->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();

                try {
                    if ($flag = $modelShop->save(false)) {
                        foreach ($modelsBusinessHours as $modelBusinessHours) {
                            $modelBusinessHours->shop_id = $modelShop->id;
                            if (! ($flag = $modelBusinessHours->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }

                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelShop->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        for ($i=1 ; $i<=7 ; $i++) {

            $modelsBusinessHours[$i] = new BusinessHours();

        }


        return $this->render('create', [
            'modelShop' => $modelShop,
            'modelsBusinessHours' => (empty($modelsBusinessHours)) ? [new BusinessHours] : $modelsBusinessHours
        ]);
    }


    /**
     * Updates an existing Shop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $modelShop = $this->findModel($id);
        $modelsBusinessHours = $modelShop->businessHours;

        if ($modelShop->load(Yii::$app->request->post())) {

            $oldIDs = ArrayHelper::map($modelsBusinessHours, 'id', 'id');
            $modelsBusinessHours = Model::createMultiple(BusinessHours::classname(), $modelsBusinessHours);

            Model::loadMultiple($modelsBusinessHours, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsBusinessHours, 'id', 'id')));



            // validate Shop model
            $valid = $modelShop->validate();

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $modelShop->save(false)) {
                        if (! empty($deletedIDs)) {

                            BusinessHours::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsBusinessHours as $modelBusinessHours) {
                            $modelBusinessHours->shop_id = $modelShop->id;
                            if (! ($flag = $modelBusinessHours->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $modelShop->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        for ($i=1 ; $i<=7 ; $i++) {

         $newModelsBusinessHours[$i] = new BusinessHours();

        }

        foreach ($modelsBusinessHours as $modelBusinessHours)
        {
            $newModelsBusinessHours[$modelBusinessHours->weekday] = $modelBusinessHours;
        }


        return $this->render('update', [
            'modelShop' => $modelShop,
            'modelsBusinessHours' => (empty($newModelsBusinessHours)) ? [new BusinessHours] : $newModelsBusinessHours
        ]);
    }

    /**
     * Deletes an existing Shop model.
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
     * Finds the Shop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Shop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Shop::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
