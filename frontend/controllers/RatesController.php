<?php

namespace frontend\controllers;

use common\models\User;
use common\services\RateService;
use frontend\models\RateFilter;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\PageCache;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Class RatesController
 * @package frontend\controllers
 */
class RatesController extends Controller
{

    /** @var RateService */
    private $rateService;

    /**
     * RatesController constructor.
     * @param $id
     * @param $module
     * @param RateService $rateService
     * @param array $config
     */
    public function __construct($id, $module, RateService $rateService, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->rateService = $rateService;
    }

//    /**
//     * @return array|array[]|\string[][]
//     */
//    public function behaviors()
//    {
//        $behaviors = parent::behaviors();
//        $behaviors['basicAuth'] = [
//            'class' => HttpBasicAuth::class,
//            'auth' => function ($username, $password) {
//                $user = User::findByUsername($username);
//                if ($user && $user->validatePassword($password)) {
//                    return $user;
//                }
//                return null;
//            }
//        ];
//        return $behaviors;
//    }

    /**
     * @return array
     * @throws \Exception
     */
    public function actionIndex()
    {
        $filter = new RateFilter();
        $filter->codes = $this->rateService->getCurrencies();

        if ($filter->load(\Yii::$app->request->get(), '') && $filter->validate()) {
            return $this->rateService->findByFilter($filter);
        }

        throw new BadRequestHttpException(current($filter->getFirstErrors()));
    }

    /**
     * @param string $code
     * @return \common\models\Rate|null
     * @throws BadRequestHttpException
     */
    public function actionView(string $code)
    {
        $filter = new RateFilter();
        $filter->codes = $this->rateService->getCurrencies();
        $filter->code = $code;
        if ($filter->validate()) {
            return $this->rateService->findByCode($code);
        }

        throw new BadRequestHttpException(current($filter->getFirstErrors()));
    }

}