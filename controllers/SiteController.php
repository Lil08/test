<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

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
    public function actionIndex(string $background = '', int $depth = 1)
    {
//        $background = '(0,1,15)';
//        $depth = 2;

        $depth = $this->getDepth($depth);
        $background = $this->getBackground($background);
        $data = $this->list($depth);

        return $this->render('index', compact('data', 'depth', 'background'));
    }

    private function list(int $depth = 1): array
    {
        $file = dirname(__DIR__, 1) . '/web/file/file.json';
        $content = file_get_contents($file);
        $content = Json::decode($content, true);

        if ($depth === 1) {
            foreach ($content as $item) {
                unset($item['value']['depth']);
            }
        }

        return $content;
    }

    private function getBackground(string $background): string
    {
        if (str_contains($background, 'http')) {
            $style = 'background-image: url(' . $background . ')';
        } elseif (str_contains($background, '(')) {
            $style = 'background-color: rgb' . $background;
        } else {
            $style = 'background:' . $background;
        }

        return $style;
    }

    private function getDepth(int $depth): int
    {
        $depth = $depth > 2 ? 2 : $depth;

        return $depth;
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
}
