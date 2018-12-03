<?php

namespace app\controllers;

use app\models\GenerosForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

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

    private function buscarGenero($id)
    {
        $genero = Yii::$app->db
            ->createCommand('SELECT *
                               FROM generos
                              WHERE id = :id', [':id' => $id])
            ->queryOne();
        if ($genero === false) {
            throw new NotFoundHttpException('El género no existe.');
        }
        return $genero;
    }
}
