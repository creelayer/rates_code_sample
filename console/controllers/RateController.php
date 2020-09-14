<?php

namespace console\controllers;

use common\services\RateService;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class RateController
 * @package console\controllers
 */
class RateController extends Controller
{

    /** @var RateService */
    private $rateService;

    /**
     * RateController constructor.
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

    /**
     * @param $code
     * @return int
     * @throws \yii\db\Exception
     */
    public function actionImport($code)
    {

        $currencies = explode(',', $code);

        $this->rateService->setCurrencies($currencies);

        $this->rateService->import();
        return ExitCode::OK;
    }

}