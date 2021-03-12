<?php
namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Currency;

class CurrencyController extends Controller
{
    public function actionInit()
    {
        $currencies = $this->getCurrencyTable();
        $data = json_decode(json_encode(simplexml_load_string($currencies)), true);

        if (!isset($data['Valute'])) {
            echo 'CURRENCIES NOT FOUND' . "\n";
            return ExitCode::UNAVAILABLE;
        }

        if (Currency::find()->count()) {
            $this->updateCurrencies($data);
        } else {
            $this->insertCurrencies($data);
        }
    }

    private function setData(array $data)
    {
        $currencies = [];
        foreach ($data as $key => $currency) {
            $currencies[$key]['name'] = (string) $currency['CharCode'];
            $currencies[$key]['rate'] = (float) str_replace(',', '.', $currency['Value']);
        }

        return $currencies;
    }

    private function getCurrencyTable()
    {
        return file_get_contents('http://www.cbr.ru/scripts/XML_daily.asp');
    }

    private function insertCurrencies($data) {
        $data = $this->setData($data['Valute']);

        if ($data) {
            $db = \Yii::$app->db;
            $sql = $db->queryBuilder->batchInsert('currency', ['name', 'rate'], $data);
            $db->createCommand($sql)->execute();
            echo 'CURRENCIES INSERT' . "\n";

            return ExitCode::OK;
        }
    }

    private function updateCurrencies($data)
    {
        $data = $this->setData($data['Valute']);

        foreach ($data as $key => $item) {
            $insertValues = [
                'name' => $item['name'],
                'rate' =>  $item['rate']
            ];

            \Yii::$app->db->createCommand()->upsert('currency', $insertValues, true)->execute();
        }
        echo 'CURRENCIES UPDATE' . "\n";

        return ExitCode::OK;
    }
}
