<?php

namespace backend\controllers;

use Yii;
use backend\models\Material;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;


/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends Controller
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
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Material::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Material model.
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
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $request = Yii::$app->request;
        $model = new Material();
        if(!$request->isPost)
        {
            if ($model->load(Yii::$app->request->post()) && $model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }else{
            $model->scenario = 'upload';
            if($model->validate()){
                $model->uploadFile = UploadedFile::getInstance($model, 'uploadFile');
                $ext = substr($model->uploadFile->name,-4);
                $temp = $model->uploadFile->tempName;
                $type =$model->uploadFile->type;
                $timeStamp = time();
                $model->format = $type;
                $model->created_at = $timeStamp;
                $model->uid = Yii::$app->user->id;
                $model->name = $_POST['Material']['name'];
                if($url = $model->upload($temp,$timeStamp.$ext))
                {
                    Yii::$app->session->setFlash('success', '云端上传成功！');
                    $model->url = $url;
                    $model->scenario = 'addNew';
                    if($model->validate() && $model->save()){
                        Yii::$app->session->setFlash('success', '保存成功！');
                        return $this->redirect('/material/index');
                    }else{
                        Yii::$app->session->setFlash('error', '保存失败，请稍后再试！');
                        //TODO:联系网站管理人员
                    }
                }else{
                    Yii::$app->session->setFlash('error', '上传失败，请稍后再试！');
                    //TODO:联系网站管理人员
                }
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Material model.
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
     * Deletes an existing Material model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $target =  $this->findModel($id);
        $key = substr($target['url'],-14);
        //删除本地数据库
        if($target->delete()){
            Yii::$app->session->setFlash('success', '数据库删除成功！');
        }else{
            Yii::$app->session->setFlash('error', '数据库删除失败！');
        }
        //删除云端文件
        $model = new Material();
        if(!$model->deleteQiniu($key)){
            Yii::$app->session->setFlash('success', '云端删除成功！');
        }else{
            Yii::$app->session->setFlash('error', '云端删除失败！');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
