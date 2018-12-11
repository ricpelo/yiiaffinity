<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\data\Pagination;
use yii\data\Sort;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Response;

/**
 * Definición del controlador generos.
 */
class GenerosController extends \yii\web\Controller
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

    /**
     * Muestra la lista de generos paginada.
     * @return string La vista del listado de géneros
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'genero' => ['label' => 'Género'],
                'cantidad' => ['label' => 'Cantidad'],
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
        ->createCommand('SELECT count(*) FROM generos')
        ->queryScalar();

        $pagination = new Pagination([
            'defaultPageSize' => 5,
            'totalCount' => $count,
        ]);

        $filas = \Yii::$app->db
            ->createCommand("SELECT g.*, count(p.id) as cantidad
                               FROM generos g
                          LEFT JOIN peliculas p
                                 ON g.id = genero_id
                           GROUP BY g.id
                           ORDER BY $orderBy
                              LIMIT :limit
                             OFFSET :offset", [
                                 ':limit' => $pagination->limit,
                                 ':offset' => $pagination->offset,
                             ])
            ->queryAll();
        return $this->render('index', [
            'filas' => $filas,
            'pagination' => $pagination,
            'sort' => $sort,
        ]);
    }

    /**
     * Crea un nuevo género.
     * @return string|Response El formulario de modificacion o una redirección
     */
    public function actionCreate()
    {
        $generosForm = new GenerosForm();

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('generos', $generosForm->attributes)
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila insertada correctamente');
            return $this->redirect(['generos/index']);
        }
        return $this->render('create', [
            'generosForm' => $generosForm,
        ]);
    }

    /**
     * Modifica un género.
     * @param  int              $id El ID del genero a modificar
     * @return string|Response      El formulario de modificacion o una redirección
     */
    public function actionUpdate($id)
    {
        $generosForm = new GenerosForm(['attributes' => $this->buscarGenero($id)]);

        if ($generosForm->load(Yii::$app->request->post()) && $generosForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('generos', $generosForm->attributes, ['id' => $id])
                ->execute();
            Yii::$app->session->setFlash('success', 'Fila modificada correctamente');
            return $this->redirect(['generos/index']);
        }

        return $this->render('update', [
            'generosForm' => $generosForm,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    /**
     * Borra un género.
     * @param  int      $id El id del género a borrar.
     * @return Response     Una redirección.
     */
    public function actionDelete($id)
    {
        $peliculas = Yii::$app->db
        ->createCommand('SELECT id
                           FROM peliculas
                          WHERE genero_id = :id
                          LIMIT 1', [':id' => $id])->queryOne();
        if (empty($peliculas)) {
            Yii::$app->session->setFlash('success', 'Fila borrada correctamente');
            Yii::$app->db->createCommand()->delete('generos', ['id' => $id])->execute();
        } else {
            Yii::$app->session->setFlash('error', 'No se puede borrar un género asociado a una película');
        }
        return $this->redirect(['generos/index']);
    }

    /**
     * Lista de todos los géneros.
     * @return array Devuelve un array con la tabla generos.
     */
    private function listaGeneros()
    {
        $generos = Yii::$app->db->createCommand('SELECT * FROM generos')->queryAll();
        $listaGeneros = [];
        foreach ($generos as $genero) {
            $listaGeneros[$genero['id']] = $genero['genero'];
        }
        return $listaGeneros;
    }

    /**
     * Busca un género.
     * @param  int                  $id El id de la pelicula a buscar.
     * @return array                    Devuelve el genero si existe.
     * @throws NotFoundHttpException    Si el genero no existe.
     */
    private function buscarGenero($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                              WHERE id = :id', [':id' => $id])->queryOne();
        if (empty($fila)) {
            throw new NotFoundHttpException('Esa genero no existe.');
        }
        return $fila;
    }
}
