<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\ListasForm;
use app\models\LoginForm;
use app\models\UploadForm;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSaluda($nombre = 'Manolo')
    {
        return $this->render('saluda', [
            'nombre' => $nombre,
        ]);
    }

    public function actionAjax()
    {
        return $this->render('ajax');
    }

    // ID de la acción: dame-numero
    public function actionDameNumero()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return Yii::$app->request->post('numero') * 2;
        }
        throw new MethodNotAllowedHttpException('Debe ser AJAX');
    }

    public function actionEjemploListas()
    {
        $listasForm = new ListasForm();
        return $this->render('ejemplo-listas', [
            'listasForm' => $listasForm,
            'provincias' => $this->getProvincias(),
            'municipios' => [],
        ]);
    }

    public function actionMunicipios($provincia)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        if ($provincia === 'CA') {
            return ['', 'Sanlúcar', 'Jerez', 'Puerto Real', 'Chipiona'];
        } elseif ($provincia === 'SE') {
            return ['', 'Sevilla', 'Dos Hermanas', 'El Cuervo', 'Camas'];
        } elseif ($provincia === 'HU') {
            return ['', 'Huelva', 'Palos', 'Moguer', 'Lepe'];
        }
        return [];
    }

    public function actionSubir()
    {
        $model = new UploadForm();

        if (Yii::$app->request->isPost) {
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');
            if ($model->upload()) {
                // file is uploaded successfully
                return $this->redirect(['site/index']);
            }
        }

        return $this->render('subir', ['model' => $model]);
    }

    private function getProvincias()
    {
        return [
            '' => '',
            'CA' => 'Cádiz',
            'SE' => 'Sevilla',
            'HU' => 'Huelva',
        ];
    }
}
