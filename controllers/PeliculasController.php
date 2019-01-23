<?php

namespace app\controllers;

use app\models\BuscarForm;
use app\models\Generos;
use app\models\Peliculas;
use Yii;
use yii\data\Sort;
use yii\helpers\ArrayHelper;
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
        $query = Peliculas::find()->with('genero');

        if ($buscarForm->load(Yii::$app->request->post()) && $buscarForm->validate()) {
            $query->andFilterWhere(['ilike', 'titulo', $buscarForm->titulo]);
            $query->andFilterWhere(['genero_id' => $buscarForm->genero_id]);
        }

        if (empty($sort->orders)) {
            $query->orderBy(['id' => SORT_ASC]);
        } else {
            $query->orderBy($sort->orders);
        }

        return $this->render('index', [
            'peliculas' => $query->all(),
            'sort' => $sort,
            'listaGeneros' => ['' => ''] + $this->listaGeneros(),
            'buscarForm' => $buscarForm,
        ]);
    }

    public function actionCreate()
    {
        $pelicula = new Peliculas();

        if ($pelicula->load(Yii::$app->request->post()) && $pelicula->save()) {
            return $this->redirect(['peliculas/index']);
        }
        return $this->render('create', [
            'pelicula' => $pelicula,
        ]);
    }

    public function actionVer($id)
    {
        $pelicula = $this->buscarPelicula($id);

        $participantes = (new \yii\db\Query())
            ->select(['personas.nombre', 'papeles.papel'])
            ->from('participaciones')
            ->innerJoin('personas', 'persona_id = personas.id')
            ->innerJoin('papeles', 'papel_id = papeles.id')
            ->where(['pelicula_id' => $pelicula->id])
            ->all();

        $participantes = ArrayHelper::index($participantes, null, 'papel');

        return $this->render('ver', [
            'pelicula' => $pelicula,
            'participantes' => $participantes,
        ]);
    }

    public function actionUpdate($id)
    {
        $pelicula = $this->buscarPelicula($id);

        if ($pelicula->load(Yii::$app->request->post()) && $pelicula->save()) {
            return $this->redirect(['peliculas/index']);
        }

        return $this->render('update', [
            'pelicula' => $pelicula,
            'listaGeneros' => $this->listaGeneros(),
        ]);
    }

    public function actionDelete($id)
    {
        $this->buscarPelicula($id)->delete();
        return $this->redirect(['peliculas/index']);
    }

    private function listaGeneros()
    {
        return Generos::find()
            ->select('genero')
            ->indexBy('id')
            ->column();
    }

    private function buscarPelicula($id)
    {
        $fila = Peliculas::find()
            ->where(['id' => $id])
            ->with([
                'participaciones.persona',
                'participaciones.papel',
            ])
            ->one();
        if ($fila === null) {
            throw new NotFoundHttpException('Esa película no existe.');
        }
        return $fila;
    }
}
