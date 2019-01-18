<?php

namespace app\controllers;

use app\models\Generos;
use app\models\Peliculas;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

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

    /**
     * Listado de géneros.
     * @return string La vista del listado de géneros
     */
    public function actionIndex()
    {
        $count = Generos::find()->count();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);

        $filas = Generos::find()
            ->orderBy('genero')
            ->limit($pagination->limit)
            ->offset($pagination->offset)
            ->all();

        return $this->render('index', [
            'filas' => $filas,
            'pagination' => $pagination,
        ]);
    }

    public function actionCreate()
    {
        $genero = new Generos();

        if ($genero->load(Yii::$app->request->post()) && $genero->save()) {
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente.');
            return $this->redirect(['generos/index']);
        }

        return $this->render('create', [
            'genero' => $genero,
        ]);
    }

    public function actionVer($id)
    {
        return $this->render('ver', [
            'genero' => $this->buscarGenero($id),
            'peliculas' => Peliculas::findAll(['genero_id' => $id]),
        ]);
    }

    /**
     * Modifica un género.
     * @param  int             $id El id del género a modificar
     * @return string|Response     El formulario de modificación o una redirección
     */
    public function actionUpdate($id)
    {
        $genero = $this->buscarGenero($id);
        if ($genero->load(Yii::$app->request->post()) && $genero->save()) {
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente.');
            return $this->redirect(['generos/index']);
        }
        return $this->render('update', [
            'genero' => $genero,
        ]);
    }

    /**
     * Borra un género.
     * @param  int      $id El id del género a borrar
     * @return Response     Una redirección
     */
    public function actionDelete($id)
    {
        $genero = $this->buscarGenero($id);
        if (empty($genero->peliculas)) {
            $genero->delete();
            Yii::$app->session->setFlash('success', 'Género borrado correctamente.');
        } else {
            Yii::$app->session->setFlash('error', 'Hay películas de ese género.');
        }
        return $this->redirect(['generos/index']);
    }

    /**
     * Localiza un género por su id.
     * @param  int                   $id El id del género
     * @return array                     El género si existe
     * @throws NotFoundHttpException     Si el género no existe
     */
    private function buscarGenero($id)
    {
        $genero = Generos::findOne($id);
        if ($genero === null) {
            throw new NotFoundHttpException('El género no existe.');
        }
        return $genero;
    }
}
