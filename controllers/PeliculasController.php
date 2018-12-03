<?php

namespace app\controllers;

use app\models\PeliculasForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador peliculas.
 */
class PeliculasController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $filas = \Yii::$app->db
            ->createCommand('SELECT * FROM peliculas')->queryAll();
        return $this->render('index', [
            'filas' => $filas,
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
