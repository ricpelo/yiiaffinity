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

        $buscarForm = new BuscarForm();

        $query = (new \yii\db\Query())
            ->select(['p.*', 'g.genero'])
            ->from('peliculas p')
            ->innerJoin('generos g', 'p.genero_id = g.id');

        if ($buscarForm->load(Yii::$app->request->post()) && $buscarForm->validate()) {
            $query->andFilterWhere(['ilike', 'titulo', $buscarForm->titulo]);
            $query->andFilterWhere(['p.genero_id' => $buscarForm->genero_id]);
        }

        if (empty($sort->orders)) {
            $query->orderBy(['p.id' => SORT_ASC]);
        } else {
            $query->orderBy($sort->orders);
        }

        return $this->render('index', [
            'filas' => $query->all(),
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
        $peliculasForm->genero_id = (new \yii\db\Query())
            ->select('genero')
            ->from('generos')
            ->where(['id' => $peliculasForm->genero_id])
            ->scalar();

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
        return (new \yii\db\Query())
            ->select('genero')
            ->from('generos')
            ->indexBy('id')
            ->column();
    }

    private function buscarPelicula($id)
    {
        $fila = (new \yii\db\Query())
            ->from('peliculas')
            ->where(['id' => $id])
            ->one();
        if ($fila === false) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
