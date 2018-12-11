<?php

namespace app\controllers;

use app\models\PeliculasForm;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => \yii\filters\VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['update', 'delete'],
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
        $sort = new Sort([
           'attributes' => [
               'titulo' => ['label' => 'Título'],
               'anyo' => ['label' => 'Año'],
               'duracion' => ['label' => 'Duración'],
               'genero' => ['label' => 'Género'],
           ],
        ]);
        if (empty($sort->orders)) {
            $orderBy = '1';
        } else {
            $res = [];
            foreach ($sort->orders as $columna => $sentido) {
                $res[] = $sentido == SORT_ASC ? "$columna ASC" : "$columna DESC";
            }
            $orderBy = implode(',', $res);
        }

        $count = Yii::$app->db
        ->createCommand('SELECT count(*) FROM peliculas')
        ->queryScalar();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);

        $filas = Yii::$app->db
            ->createCommand("SELECT p.*, g.genero
                               FROM peliculas p JOIN generos g ON genero_id=g.id
                           ORDER BY $orderBy
                              LIMIT :limit
                             OFFSET :offset", [
                                ':limit' => $pagination->limit,
                                ':offset' => $pagination->offset,
                                ])->queryAll();
        return $this->render('index', [
            'filas' => $filas,
            'sort' => $sort,
            'pagination' => $pagination,
        ]);
    }

    public function actionVer($id)
    {
        return $this->render('ver', [
            'pelicula' => $this->buscarPelicula($id),
            'participantes' => $this->buscarParticipante($id),
        ]);
    }

    public function actionCreate()
    {
        $peliculasForm = new PeliculasForm();

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('peliculas', $peliculasForm->attributes)
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente');
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'peliculasForm' => $peliculasForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    public function actionUpdate($id)
    {
        $peliculasForm = new PeliculasForm(['attributes' => $this->buscarPelicula($id)]);

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('peliculas', $peliculasForm->attributes, ['id' => $id])
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente');
            return $this->redirect(['peliculas/index']);
        }

        return $this->render('update', [
            'peliculasForm' => $peliculasForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    public function actionDelete($id)
    {
        Yii::$app->db->createCommand()->delete('peliculas', ['id' => $id])->execute();
        Yii::$app->session->setFlash('success', 'Fila borrada correctamente');
        return $this->redirect(['peliculas/index']);
    }

    private function listaGeneros()
    {
        $generos = Yii::$app->db->createCommand('SELECT * FROM generos')->queryAll();
        $listaGeneros = [];
        foreach ($generos as $genero) {
            $listaGeneros[$genero['id']] = $genero['genero'];
        }
        return $listaGeneros;
    }

    private function buscarPelicula($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM peliculas
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }

    private function buscarParticipante($id)
    {
        return Yii::$app->db
        ->createCommand('SELECT pa.*, nombre, rol
                        FROM participantes pa
                        JOIN roles r
                        ON rol_id = r.id
                        JOIN personas p
                        ON persona_id = p.id
                        WHERE pelicula_id = :id', [':id' => $id])
        ->queryAll();
    }
}
