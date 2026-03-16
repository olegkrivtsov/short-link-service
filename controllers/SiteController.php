<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\ShortLink;
use yii\web\Controller;
use yii\web\ErrorAction;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public function actions(): array
    {
        return [
            'error' => [
                'class' => ErrorAction::class,
            ],
        ];
    }

    public function actionIndex(): Response|string|array
    {
        $shortLink = new ShortLink();

        if ($this->request->isPost && 
            $shortLink->load($this->request->post()) && 
            $shortLink->validate()) 
        {
            $shortLink->generateShortLink();
            $shortLink->save();
        } 

        return $this->render('index', ['shortLink' => $shortLink]);
    }

    public function actionShowQr(int $id): Response|string
    {
        $shortLink = ShortLink::findOne(['id' => $id]);

        if (!$shortLink) {
            throw new NotFoundHttpException();
        }

        return $this->render('show-qr', ['shortLink' => $shortLink]);
    }
}
