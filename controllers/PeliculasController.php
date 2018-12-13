<?php

namespace app\controllers;

use app\models\BuscarForm;
use app\models\PeliculasForm;
use Yii;
use yii\data\Sort;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    public function actionPrueba()
    {
        Yii::$app->session->setFlash('error', 'Esto es un error.');
        return $this->redirect(['peliculas/index']);
    }

    public function actionIndex()
    {
        $sort = new Sort([
            'attributes' => [
                'titulo',
                'anyo',
                'duracion',
                'genero',
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

        $buscarForm = new BuscarForm();

        $where = [];
        $execute = [];

        if ($buscarForm->load(Yii::$app->request->post()) && $buscarForm->validate()) {
            if ($buscarForm->titulo !== '') {
                $where[] = 'titulo ILIKE :titulo';
                $execute[':titulo'] = '%' . $buscarForm->titulo . '%';
            }
            if ($buscarForm->genero_id !== '') {
                $where[] = 'p.genero_id = :genero_id';
                $execute[':genero_id'] = $buscarForm->genero_id;
            }
        }

        $where = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

        $filas = \Yii::$app->db
            ->createCommand("SELECT p.*, g.genero
                               FROM peliculas p
                               JOIN generos g
                                 ON p.genero_id = g.id
                             $where
                           ORDER BY $orderBy", $execute)->queryAll();

        return $this->render('index', [
            'filas' => $filas,
            'sort' => $sort,
            'listaGeneros' => ['' => ''] + $this->listaGeneros(),
            'buscarForm' => $buscarForm,
        ]);
    }

    public function actionCreate()
    {
        $peliculasForm = new PeliculasForm();

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('peliculas', $peliculasForm->attributes)
                ->execute();
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'peliculasForm' => $peliculasForm,
        ]);
    }

    public function actionVer($id)
    {
        $peliculasForm = new PeliculasForm(['attributes' => $this->buscarPelicula($id)]);
        $peliculasForm->genero_id = Yii::$app->db
            ->createCommand('SELECT genero
                               FROM generos
                              WHERE id = :id', [':id' => $peliculasForm->genero_id])
            ->queryScalar();

        return $this->render('ver', [
            'peliculasForm' => $peliculasForm,
        ]);
    }

    public function actionUpdate($id)
    {
        $peliculasForm = new PeliculasForm(['attributes' => $this->buscarPelicula($id)]);

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('peliculas', $peliculasForm->attributes, ['id' => $id])
                ->execute();
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
}
