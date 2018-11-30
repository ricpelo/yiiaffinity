<?php

namespace app\controllers;

use app\models\PeliculasForm;
use Yii;
use yii\web\NotFoundHttpException;

/**
 * Definición del controlador prueba.
 */
class PruebaController extends \yii\web\Controller
{
    public function actionListado()
    {
        $filas = \Yii::$app->db
            ->createCommand('SELECT * FROM peliculas')->queryAll();
        return $this->render('listado', [
            'filas' => $filas,
        ]);
    }

    public function actionInsertar()
    {
        $peliculasForm = new PeliculasForm();

        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->insert('peliculas', $peliculasForm->attributes)
                ->execute();
            return $this->redirect(['prueba/listado']);
        }
        return $this->render('insertar', [
            'peliculasForm' => $peliculasForm,
        ]);
    }

    public function actionModificar($id)
    {
        $fila = Yii::$app->db
            ->createCommand('SELECT *
                               FROM peliculas
                              WHERE id = :id', [':id' => $id])->queryOne();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        $peliculasForm = new PeliculasForm(['attributes' => $fila]);
        if ($peliculasForm->load(Yii::$app->request->post()) && $peliculasForm->validate()) {
            Yii::$app->db->createCommand()
                ->update('peliculas', $peliculasForm->attributes, ['id' => $id])
                ->execute();
            return $this->redirect(['prueba/listado']);
        }

        return $this->render('modificar', [
            'peliculasForm' => $peliculasForm,
        ]);
    }

    public function actionBorrar($id)
    {
        Yii::$app->db->createCommand()->delete('peliculas', ['id' => $id])->execute();
        return $this->redirect(['prueba/listado']);
    }
}
