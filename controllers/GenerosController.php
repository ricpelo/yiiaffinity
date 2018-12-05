<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class GenerosController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $count = Yii::$app->db
            ->createCommand('SELECT count(*) FROM generos')
            ->queryScalar();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);

        $filas = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                           ORDER BY genero
                              LIMIT :limit
                             OFFSET :offset', [
                ':limit' => $pagination->limit,
                ':offset' => $pagination->offset,
            ])
            ->queryAll();
        return $this->render('index', [
            'filas' => $filas,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $generosForm = new GenerosForm();

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('generos', $generosForm->attributes)
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente.');
            return $this->redirect(['generos/index']);
        }

        return $this->render('create', [
            'generosForm' => $generosForm,
        ]);
    }

    public function actionUpdate($id)
    {
        $genero = $this->buscarGenero($id);
        $generosForm = new GenerosForm(['attributes' => $genero]);
        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('generos', $generosForm->attributes, ['id' => $id])
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente.');
            return $this->redirect(['generos/index']);
        }
        return $this->render('update', [
            'generosForm' => $generosForm,
        ]);
    }

    public function actionDelete($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT id
                               FROM peliculas
                              WHERE genero_id = :id
                              LIMIT 1', ['id' => $id])
            ->queryOne();
        if (!empty($fila)) {
            Yii::$app->session->setFlash('error', 'Hay películas de ese género.');
        } else {
            Yii::$app->db->createCommand()
            ->delete('generos', ['id' => $id])
            ->execute();
            Yii::$app->session->setFlash('success', 'Género borrado correctamente.');
        }
        return $this->redirect(['generos/index']);
    }

    private function buscarGenero($id)
    {
        $genero = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                              WHERE id = :id', [':id' => $id])
            ->queryOne();
        if (empty($genero)) {
            throw new NotFoundHttpException('El género no existe.');
        }
        return $genero;
    }
}
