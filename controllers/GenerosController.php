<?php

namespace app\controllers;

use app\models\GenerosForm;
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

    public function actionVer($id)
    {
        $genero = $this->buscarGenero($id);
        $peliculas = Yii::$app->db
            ->createCommand('SELECT *
                               FROM peliculas
                              WHERE genero_id = :id', [':id' => $id])
            ->queryAll();
        return $this->render('ver', [
            'genero' => $genero,
            'peliculas' => $peliculas,
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

    /**
     * Borra un género.
     * @param  int      $id El id del género a borrar
     * @return Response     Una redirección
     */
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

    /**
     * Localiza un género por su id.
     * @param  int                   $id El id del género
     * @return array                     El género si existe
     * @throws NotFoundHttpException     Si el género no existe
     */
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
