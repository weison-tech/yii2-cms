<?php

namespace core\modules\admin\controllers;

use moonland\phpexcel\Excel;
use Yii;
use core\modules\admin\models\Admin;
use core\modules\admin\models\search\AdminSearch;
use core\modules\admin\components\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * AdminController implements the CRUD actions for Admin model.
 */
class AdminController extends Controller
{
    /**
     * Lists all Admin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AdminSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Admin model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Admin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Admin();

        $model->setScenario('create');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Admin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->setScenario('update');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Admin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Admin::STATUS_DELETED;
        $model->save();

        return $this->redirect(['index']);
    }

    /**
     * Upload excel to batch create user
     */
    public function actionExcelCreate()
    {
        try{
            $dir = 'uploads' . DIRECTORY_SEPARATOR . 'excel' . DIRECTORY_SEPARATOR;
            $sub_dir = $dir .  DIRECTORY_SEPARATOR . 'create-admin' . DIRECTORY_SEPARATOR;
            if (!is_dir($dir)) {
                mkdir($dir);
            }
            if (!is_dir($sub_dir)) {
                mkdir($sub_dir);
            }

            $files = UploadedFile::getInstancesByName('create-admin');
            if (isset($files[0])) {
                $file = $files[0];
                $filename = $sub_dir . $file->baseName . '.' . $file->extension;
                $file->saveAs($filename);

                $data = (Array) Excel::import($filename);
                if ($data) {
                    foreach ($data as $item) {
                        $username = trim($item['用户名'] ?? ($item['Username']) ?? '');
                        $email = trim($item['邮箱'] ?? ($item['Email']) ?? '');
                        $password = trim($item['密码'] ?? ($item['Password']) ?? '123456');
                        if (!$username) {
                            $res = Json::encode(['code' => 500, 'msg' => Yii::t('AdminModule.base', 'Excel must contain username field')]);
                            exit($res);
                        }
                        $admin = Admin::find()->where(['username' => $username])->one();
                        $admin = $admin ?: new Admin();
                        $admin->username = $username;
                        if ($email) {
                            $admin->email = $email;
                        }
                        if ($admin->isNewRecord) {
                            $admin->password = $password;
                        }
                        $admin->status = Admin::STATUS_ACTIVE;
                        $admin->save();
                    }
                }
            }
            $res = Json::encode(['code' => 200, 'msg' => Yii::t('AdminModule.base', 'Successful operation')]);
            exit($res);
        } catch (\Exception $e) {
            $res = Json::encode(['code' => 500, 'msg' => Yii::t('AdminModule.base', 'Operation failed')]);
            exit($res);
        }
    }

    /**
     * Finds the Admin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Admin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Admin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * 修改信息
     */
    public function actionUpdateInfo()
    {
        $model = $this->findModel(Yii::$app->admin->getId());
        $model->setScenario('self-update');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash(
                'success',
                Yii::t('base', 'Update successfully')
            );
            return $this->redirect(['update-info']);
        } else {
            return $this->render('update-info', ['model' => $model]);
        }
    }
}
