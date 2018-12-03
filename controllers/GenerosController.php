<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador generos.
 */
class GenerosController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $filas = \Yii::$app->db
            ->createCommand('SELECT * FROM generos')->queryAll();
        return $this->render('index', [
            'filas' => $filas,
        ]);
    }

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

    public function actionUpdate($id)
    {
        $generosForm = new GenerosForm(['attributes' => $this->buscarPelicula($id)]);

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

    public function actionDelete($id)
    {
        $peliculas = Yii::$app->db->createCommand('SELECT *
            FROM peliculas p JOIN generos g ON genero_id=g.id
            WHERE genero_id = :id', [':id' => $id])->queryAll();
        if (empty($peliculas)) {
            Yii::$app->session->setFlash('success', 'Fila borrada correctamente');
            Yii::$app->db->createCommand()->delete('generos', ['id' => $id])->execute();
        } else {
            Yii::$app->session->setFlash('error', 'No se puede borrar un género asociado a una película');
        }
        return $this->redirect(['generos/index']);
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
                               FROM generos
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa genero no existe.');
        }
        return $fila;
    }
}
