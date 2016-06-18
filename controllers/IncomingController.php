<?php

namespace pistol88\shop\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class IncomingController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => $this->module->adminRoles,
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'edittable' => ['post'],
                ],
            ],
        ];
    }

    public function actionCreate()
    {
        $model = $this->module->getService('incoming');

        if ($post = Yii::$app->request->post()) {
            $model->date = time();
            $model->content = serialize($post);
            
            $productModel = $this->module->getService('product');
            
            foreach($post['element'] as $id => $count) {
                if($product = $productModel::findOne($id)) {
                    $product->plusAmount($count);
                }
            }
            
            if($model->save()) {
                \Yii::$app->session->setFlash('success', 'Поступление успешно добавлено.');
            }

            return $this->redirect(['create', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
}
