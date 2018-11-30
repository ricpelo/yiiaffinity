<?php

namespace app\controllers;

use app\models\PeliculasForm;
use Yii;

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

        if (Yii::$app->request->post()) {
            $peliculasForm->attributes = Yii::$app->request->post();
            if ($peliculasForm->validate()) {
                Yii::$app->db->createCommand()
                    ->insert('peliculas', $peliculasForm->attributes)
                    ->execute();
                return $this->redirect(['prueba/listado']);
            }
        }
        return $this->render('insertar', [
            'peliculasForm' => $peliculasForm,
        ]);
    }
}
