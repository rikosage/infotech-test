<?php

namespace app\controllers;

use Yii;

use app\components\BaseController;

use app\models\Authors;

use app\models\search\AuthorsSearch;

use app\models\forms\TopAuthorsListForm;

use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * AuthorsController implements the CRUD actions for Authors model.
 */
class AuthorsController extends BaseController
{
    /**
     * @inheritdoc
     */
    public function behaviors() : array
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => array_merge([[
                    'allow' => true,
                    'actions' => ['top-list'],
                    'roles' => ['@'],
                ]], $this->getAccessRules()),
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
     * Lists all Authors models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AuthorsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = new TopAuthorsListForm;

        return $this->render('index', [
            'model' => $model,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Authors model.
     * @param int $id
     * @return mixed
     */
    public function actionView(int $id)
    {
        return $this->render('view', [
            'model' => $this->findModel(Authors::className(), $id),
        ]);
    }

    /**
     * Creates a new Authors model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Authors();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Authors model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id
     * @return mixed
     */
    public function actionUpdate(int $id)
    {
        $model = $this->findModel(Authors::className(), $id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Authors model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id
     * @return mixed
     */
    public function actionDelete(int $id)
    {
        $this->findModel(Authors::className(), $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Экшен для получения автором, выпустивших больше всего книг за год.
     * Год получается из POST-запроса
     * @return mixed
     */
    public function actionTopList(){
        $model = new TopAuthorsListForm;
        $model->load(Yii::$app->request->post());

        $selection = [];
        if ($model->validate()) {
            $selection = Authors::findTopByYear($model->year);
        }

        return $this->render("top-list", [
            'selection' => $selection,
            'year' => $model->year,
        ]);
    }
}
