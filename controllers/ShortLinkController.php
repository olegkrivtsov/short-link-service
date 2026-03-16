<?php

declare(strict_types=1);

namespace app\controllers;

use Yii;
use app\models\ShortLink;
use app\models\Visit;
use yii\web\Controller;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class ShortLinkController extends Controller
{
    public function actionIndex(string $link): Response|string
    {
        $shortLink = ShortLink::findOne(['short_link' => $link]);
        
        if (!$shortLink) {
            throw new NotFoundHttpException();
        }

        $shortLink->visit_count ++;
        $shortLink->save();

        $visit = new Visit();
        $visit->ip_address = Yii::$app->request->userIP;
        $visit->short_link_id = $shortLink->id;
        $visit->save();

        return $this->redirect($shortLink->url);
    }
}
