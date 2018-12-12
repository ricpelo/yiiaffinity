<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class ParticipantesController extends Controller
{
    public function actionQuitar($id)
    {
        $pelicula_id = Yii::$app->db
            ->createCommand('SELECT pelicula_id
                               FROM participantes
                              WHERE id = :id', [':id' => $id])
            ->queryScalar();
        Yii::$app->db->createCommand()
            ->delete('participantes', ['id' => $id])
            ->execute();
        return $this->redirect(['peliculas/update', 'id' => $pelicula_id]);
    }
}
