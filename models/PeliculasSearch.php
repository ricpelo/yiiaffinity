<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PeliculasSearch represents the model behind the search form of `app\models\Peliculas`.
 */
class PeliculasSearch extends Peliculas
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'genero_id'], 'integer'],
            [['titulo', 'duracion', 'sinopsis', 'genero.genero'], 'safe'],
            [['anyo', 'precio'], 'number'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['genero.genero']);
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied.
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Peliculas::find()->joinWith('genero');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['genero.genero'] = [
            'asc' => ['generos.genero' => SORT_ASC],
            'desc' => ['generos.genero' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'anyo' => $this->anyo,
            'precio' => $this->precio,
            'genero_id' => $this->genero_id,
        ]);

        $query->andFilterWhere(['ilike', 'titulo', $this->titulo])
            ->andFilterWhere(['ilike', 'sinopsis', $this->sinopsis])
            ->andFilterWhere(['ilike', 'generos.genero', $this->getAttribute('genero.genero')]);

        return $dataProvider;
    }
}
