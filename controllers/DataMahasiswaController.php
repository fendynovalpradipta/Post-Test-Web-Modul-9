<?php

namespace app\controllers;

use Yii;
use app\models\DataMahasiswa;
use app\search\DataMahasiswaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use mPDF;

/**
 * DataMahasiswaController implements the CRUD actions for DataMahasiswa model.
 */
class DataMahasiswaController extends Controller
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
     * Lists all DataMahasiswa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DataMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDatamahasiswa()
    {
        $searchModel = new DataMahasiswaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('datamahasiswa', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }    

    /**
     * Displays a single DataMahasiswa model.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

   public function actionPdf($id)
    {
    $model = new Datamahasiswa();
    $content = $this->renderPartial('view-pdf',
         ['model' => $model]); 
    $mpdf = new mPDF([ 
        'mode' => mPDF::MODE_CORE, 
        'format' => mPDF::FORMAT_A4,
        'orientation' => mPDF::ORIENT_LANDSCAPE, 
        'destination' => mPDF::DEST_BROWSER, 
        'content' => $content, 
        'cssFi1e' => '@vendor/kartik-v/yii2-mpdf/src/assets/kv-mpdf-bootstrap.min.css', 
        'csslnline' => '.kv-heading-1{font-size:18px;} 
                        .th{background-color : red ;}',
        'options' => ['title' => 'Krajee Report Title'],
        'methods' => [
            'SetFooter'=>['Data Seluruh Mahasiswa {PAGENO}'],
        ] 
    ]);  
    return  $pdf->render(); 
    }    

    /**
     * Creates a new DataMahasiswa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DataMahasiswa();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nim]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing DataMahasiswa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->nim]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing DataMahasiswa model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the DataMahasiswa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DataMahasiswa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DataMahasiswa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
