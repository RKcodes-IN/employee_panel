<?php

namespace app\components;

use app\modules\admin\models\AuthSession;
use app\modules\admin\models\OpenMoneyContacts;
use app\modules\admin\models\OpenMoneyLinkedContact;
use app\modules\admin\models\WebSetting;
use Yii;
use yii\base\Component;

class OpenMoney extends Component
{




    public function generateToken($data)

    {
        $settings = new WebSetting();
        $secerate_key = $settings->getSettingBykey('open_money_secret');
        $api_key = $settings->getSettingBykey('open_money_key');

        $token = $api_key . ':' . $secerate_key;
        // var_dump($token);exit;
        $curl = curl_init();

        curl_setopt_array($curl, array(
             CURLOPT_URL => 'https://icp-api.bankopen.co/api/payment_token', //https://icp-api.bankopen.co/api/payment_token
           // CURLOPT_URL => 'https://sandbox-icp-api.bankopen.co/api/payment_token', //https://icp-api.bankopen.co/api/payment_token
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
     "amount": "' . $data["final_price"] . '",
     "udf": "",
     "contact_number": "' . $data["contact_no"] . '",
     "email_id": "' . $data["email_id"] . '",
     "currency": "INR",
     "mtx": "' . rand(0000000000, 111111100) . date('Y-m-d-H-i-s') . '"
}',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    // Payment Status

    public function paymentStatus($paymentToken)
    {

        $settings = new WebSetting();
        $secerate_key = $settings->getSettingBykey('open_money_secret');
        $api_key = $settings->getSettingBykey('open_money_key');

        $token = $api_key . ':' . $secerate_key;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://icp-api.bankopen.co/api/payment_token/' . $paymentToken . '/payment',
            //CURLOPT_URL => 'https://sandbox-icp-api.bankopen.co/api/payment_token/' . $paymentToken . '/payment',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }

    // Create Contact


    public function CreateContact($param, $user_id)
    {
        print_r($param);exit;
        $settings = new WebSetting();
        $secerate_key = $settings->getSettingBykey('open_money_secret');
        $api_key = $settings->getSettingBykey('open_money_key');

        $token = $api_key . ':' . $secerate_key;

        // var_dump($token);exit;
        $encodePram = json_encode($param);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v2-api.bankopen.co/v1/virtual_accounts/marketplace/contacts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $encodePram,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Cookie: Path=/'
            ),
        ));
        $responseCode = http_response_code();

        $response = curl_exec($curl);

        $decodeResponse = json_decode($response);

// var_dump($decodeResponse->message);exit;
if($decodeResponse->message == "Could not create contact.contact already exists for email or mobile provided. contacts_id : "){
    return $response;
}else{
    if ($responseCode == 200) {

            foreach ($decodeResponse->data as $res) {

                // print_r($res->contacts_id);exit;
                $openMoneyContact = OpenMoneyContacts::find()->where(['user_id' => $user_id])->one();
                if (!empty($openMoneyContact)) {
                    $openMoneyContact->user_id = $user_id;
                    $openMoneyContact->contacts_id = $res->contacts_id;
                    $openMoneyContact->virtual_account_number = $res->virtual_account_number;
                    $openMoneyContact->vpa = $res->vpa;
                    $openMoneyContact->virtual_account_ifsc = $res->virtual_account_ifsc;
                    $openMoneyContact->account_type = $res->contact_type;
                    $openMoneyContact->status = OpenMoneyContacts::STATUS_ACTIVE;
                } else {
                    $openMoneyContact = new OpenMoneyContacts();
                    $openMoneyContact->user_id = $user_id;
                    $openMoneyContact->contacts_id = $res->contacts_id;
                    $openMoneyContact->virtual_account_number = $res->virtual_account_number;
                    $openMoneyContact->vpa = $res->vpa;
                    $openMoneyContact->virtual_account_ifsc = $res->virtual_account_ifsc;
                    $openMoneyContact->account_type = $res->contact_type;
                    $openMoneyContact->status = OpenMoneyContacts::STATUS_ACTIVE;
                }

                $openMoneyContact->save(false);
            }
    
    }
}
        


        curl_close($curl);

        return $response;
    }

    // Link Contact

    public function linkContact($param, $user_id, $driver_id)
    {
        $settings = new WebSetting();
        $secerate_key = $settings->getSettingBykey('open_money_secret');
        $api_key = $settings->getSettingBykey('open_money_key');

        $token = $secerate_key . ':' . $api_key;

        $curl = curl_init();
        $encodePram = json_encode($param);
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v2-api.bankopen.co/v1/virtual_accounts/marketplace/map_contacts',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $encodePram,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Cookie: Path=/'
            ),
        ));
        $responseCode = http_response_code();
        $response = curl_exec($curl);
        $decodeResponse = json_decode($response);
        if ($responseCode == 200) {
            foreach ($decodeResponse->data as $res) {

                // print_r($res->contacts_id);exit;
                $openMoneyContact = OpenMoneyLinkedContact::find()->where(['user_id' => $user_id])->andWhere(['skipper_id' => $driver_id])->one();
                if (!empty($openMoneyContact)) {
                    $openMoneyContact->user_id = $user_id;
                    $openMoneyContact->skipper_id = $driver_id;

                    $openMoneyContact->map_contacts_id = $res->map_contacts_id;
                    $openMoneyContact->va_account_number = $res->va_account_number;
                    $openMoneyContact->va_ifsc = $res->va_ifsc;
                    $openMoneyContact->vpa = $res->vpa;
                    $openMoneyContact->commision_type = $res->commision_type;
                    $openMoneyContact->commision = $res->commision;
                    $openMoneyContact->status = OpenMoneyContacts::STATUS_ACTIVE;
                } else {
                    $openMoneyContact = new OpenMoneyLinkedContact();
                    $openMoneyContact->user_id = $user_id;
                    $openMoneyContact->skipper_id = $driver_id;

                    $openMoneyContact->map_contacts_id = $res->map_contacts_id;
                    $openMoneyContact->va_account_number = $res->va_account_number;
                    $openMoneyContact->va_ifsc = $res->va_ifsc;
                    $openMoneyContact->vpa = $res->vpa;
                    $openMoneyContact->commision_type = $res->commision_type;
                    $openMoneyContact->commision = $res->commision;
                    $openMoneyContact->status = OpenMoneyContacts::STATUS_ACTIVE;
                }

                $openMoneyContact->save(false);
            }
        }
        curl_close($curl);
        return $response;
    }
}
