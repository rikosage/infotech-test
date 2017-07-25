<?php

namespace app\controllers;

use Yii;

use app\components\BaseController;

use app\models\Books;
use app\models\Authors;

use app\models\search\BooksSearch;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * BooksController implements the CRUD actions for Books model.
 */
class BooksController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => $this->getAccessRules(),
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Books models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BooksSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Books model.
     * @param int $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Books::className() ,$id),
        ]);
    }

    /**
     * Creates a new Books model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Books();
        return $this->createOrUpdate($model, "create");
    }

    /**
     * Updates an existing Books model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel(Books::className(), $id);
        return $this->createOrUpdate($model, "update");
    }

    /**
     * Поскольку основной функционал для создания и обновления един - выносим в отдельный метод
     * @param  \yii\db\ActiveRecord $model    Инстанс модели
     * @param  string               $viewName Вьюшка для рендера
     * @return mixed
     */
    protected function createOrUpdate(\yii\db\ActiveRecord $model, string $viewName)
    {
        $authors = Authors::find()->all();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'authors' => $authors,
        ]);
    }

    /**
     * Deletes an existing Books model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel(Books::className(), $id)->delete();

        return $this->redirect(['index']);
    }
}
