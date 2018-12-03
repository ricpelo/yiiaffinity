<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class GenerosController extends Controller
{
    public function actionIndex()
    {
        $filas = Yii::$app->db
            ->createCommand('SELECT * FROM generos')
            ->queryAll();
        return $this->render('index', [
            'filas' => $filas,
        ]);
    }
}
