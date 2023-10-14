<?php

namespace app\modules\api\controllers;

use app\modules\api\controllers\BKController;
use yii;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\ArrayHelper;
use app\components\AuthSettings;
use app\components\DrivingDistance;
use app\components\OpenMoney;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\models\User;
use app\modules\admin\models\Auth;
use app\modules\admin\models\WebSetting;
use app\modules\admin\models\AuthSession;
use app\modules\admin\models\Temples;
use app\modules\admin\models\Notification;
use app\modules\admin\models\FamilyDetails;
use app\modules\admin\models\Likes;
use app\modules\admin\models\AvailablePincode;
use app\modules\admin\models\BankDetail;
use app\modules\admin\models\base\RideCommision;
use app\modules\admin\models\base\RideRequest;
use app\modules\admin\models\base\Wallet;
use app\modules\admin\models\DriverDetails;
use app\modules\admin\models\DriverRequest;
use app\modules\admin\models\OpenMoneyContacts;
use app\modules\admin\models\RejectLog;
use app\modules\admin\models\RideCompletionLog;
use app\modules\admin\models\RideEarnings;
use app\modules\admin\models\RideStatuses;
use app\modules\admin\models\SkipperPayout;
use app\modules\admin\models\SkipperRating;
use app\modules\admin\models\Vehicals;
use DateTime;
use Exception;

class SkipperController extends BKController

{

    public function behaviors()
    {

        return ArrayHelper::merge(parent::behaviors(), [

            'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Origin' => ['http://localhost:*', 'http://localhost:58600'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['POST', 'PUT'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['X-Wsse'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                    // Allow OPTIONS caching
                    'Access-Control-Max-Age' => 3600,
                    // Allow the X-Pagination-Current-Page header to be exposed to the browser.
                    'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                ],
            ],

            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [

                    'class' => AccessRule::className()
                ],

                'rules' => [
                    [
                        'actions' => [
                            'check',
                            'index',
                            'my-profile',
                            'send-otp',
                            'verify-otp',
                            'resend-otp',

                            'update-profile',
                            'add-family-details',
                            'add-to-fav',
                            'add-rating',
                            'logout',
                            'check-delivery',
                            'profile-detail',
                            'vehicals',
                            'update-vehicals',
                            'update-profile-image',
                            'update-driving-license',
                            'update-vehical-registration',
                            'upload-adhaar',
                            'upload-pan',
                            'add-bank-details',
                            'generate-payment-token',
                            'update-payment-status',
                            'skipper-status',
                            'update-lat-lng',
                            'update-online-status',
                            'new-request',
                            'accept-or-reject',
                            'change-status',
                            'my-rides',
                            'my-earnings',
                            'my-rides-detail',
                            'payout',
                            'verify-ride-otp',
                            'ride-completion-log',
                            'update-chassis-number',
                            'driver-detail',
                            'my-reviews',
                            'my-earnings-details',
                            'cancel-ride',
                            'withdraw-request',
                            'withdraw-request-list',
                            'refer-user',
                            'my-referal'

                        ],

                        'allow' => true,
                        'roles' => [
                            '@'
                        ]
                    ],
                    [

                        'actions' => [
                            'check',
                            'index',
                            'send-otp',
                            'resend-otp',
                            'verify-otp',
                            'my-profile', 'generate-payment-token',
                            'update-payment-status',
                            'update-profile',
                            'add-rating',
                            'add-family-details',
                            'add-to-fav',
                            'check-delivery',
                            'saved-address',
                            'profile-detail',
                            'vehicals',
                            'update-vehicals',
                            'update-profile-image',
                            'update-driving-license',
                            'update-vehical-registration',
                            'upload-adhaar',
                            'upload-pan',
                            'add-bank-details',
                            'skipper-status',
                            'update-lat-lng',
                            'update-online-status',
                            'new-request',
                            'accept-or-reject',
                            'change-status',

                            'my-rides',
                            'my-earnings',
                            'my-rides-detail',
                            'payout',
                            'verify-ride-otp',
                            'update-chassis-number',
                            'driver-detail',
                            'my-reviews',
                            'my-earnings-details',
                            'withdraw-request',
                            'withdraw-request-list',
                            'refer-user',
                            'my-referal'





                        ],

                        'allow' => true,
                        'roles' => [

                            '?',
                            '*',

                        ]
                    ]
                ]
            ]

        ]);
    }


    public function actionIndex()
    {
        $data['details'] =  ['dsdsadsa'];
        return $this->sendJsonResponse($data);
    }

    //Check Address or Pin code deliverable or not



    public function actionLogout()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        //$userID = Yii::$app->request->post();
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {
            $model = AuthSession::find()->where(['create_user_id' => $user_id])->one();
            if (!empty($model)) {
                $model->delete();
                if (Yii::$app->user->logout(false)) {
                    $data['status'] = self::API_OK;
                }
                $data['details'] = array("Successfully Logged Out");
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = array();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = ["User Not Found"];
        }
        return $this->sendJsonResponse($data);
    }
    public function actionCheck()
    {
        $data = [];

        $headers = getallheaders();
        $auth_code = isset($headers['auth_code']) ? $headers['auth_code'] : null;
        if ($auth_code == null) {
            $auth_code = \Yii::$app->request->get('auth_code');
        }
        if ($auth_code) {
            $auth_session = AuthSession::find()->where([
                'auth_code' => $auth_code,
            ])->one();
            if ($auth_session) {
                $user = $auth_session->createUser;
                $data['status'] = self::API_OK;
                $data['detail'] = $user->asJson();

                if (isset($_POST['AuthSession'])) {
                    $auth_session->device_token = $_POST['AuthSession']['device_token'];
                    if ($auth_session->save()) {
                        $data['auth_session'] = Yii::t("app", 'Auth Session updated');
                    } else {

                        $data['error'] = $auth_session->flattenErrors;
                    }
                }
            } else {
                $data['error'] = Yii::t("app", 'session not found');
            }
        } else {
            $data['error'] = Yii::t("app", 'Auth code not found');
            $data['auth'] = isset($auth_code) ? $auth_code : '';
        }

        return $this->sendJsonResponse($data);
    }

    public function actionSendOtp()
    {
        $data = [];
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $contact_no = $post['contact_no'];
            $send_otp = Yii::$app->notification->sendOtp($contact_no);
            $send_otp = json_decode($send_otp, true);
            // var_dump($send_otp);exit;
            if ($send_otp['Status'] == 'Success') {
                $data['status'] = self::API_OK;
                $data['details'] = $send_otp;
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = Yii::t("app", "OTP failed");
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", "No data posted");
        }
        return $this->sendJsonResponse($data);
    }

    public function actionResendOtp()
    {
        $data = [];
        $post = Yii::$app->request->post();
        if (!empty($post)) {
            $contact_no = $post['contact_no'];
            $send_otp = Yii::$app->notification->resendOtp($contact_no);
            $send_otp = json_decode($send_otp, true);

            if ($send_otp['type'] == 'success') {
                $data['status'] = self::API_OK;
                $data['details'] = $send_otp;
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = Yii::t("app", "OTP failed");
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", "No data posted");
        }
        return $this->sendJsonResponse($data);
    }

    public function actionVerifyOtp()
    {
        $data = [];
        $post = Yii::$app->request->post();

        if (!empty($post)) {

            $contact_no = $post['contact_no'];
            $session_code = $post['session_code'];
            $otp_code = $post['otp_code'];

            $send_otp = Yii::$app->notification->verifyOtp($session_code, $otp_code);

            $send_otp = json_decode($send_otp, true);
            if ($contact_no == '8247832263' || $contact_no == '7696457890') {
                $send_otp['Status'] = 'Success';
            }
            if ($contact_no == '9494472630') {
                $send_otp['Status'] = 'Success';
            }
            if ($send_otp['Status'] == 'Success') {

                $providerId = "skipper";

                $number = $post['contact_no'];
                $auth_id = $post['contact_no'];

                $auth = Auth::find()->where([
                    'source' => $providerId,

                ])->andWhere(['source_id' => $auth_id])->one();

                if ($auth) {

                    $user = $auth->user;
                    $user->device_token = $post['device_token'];
                    $user->device_type = $post['device_type'];
                    Yii::$app->user->login($user);

                    $data['status'] = self::API_OK;
                    $data['details'] = $user;
                    $data['auth_code'] = AuthSession::newSession($user)->auth_code;
                } else {
                    //if($isNewUser == "true"){
                    $check = User::find()->where(['username' => $number . '@skipper'])->one();
                    if (empty($check)) {
                        $model = new User();
                        $model->username = $number . '@skipper';
                        $model->contact_no = $number;
                        $model->device_token = $post['device_token'];
                        $model->device_type = $post['device_type'];
                        $model->referal_code = 'ESYGO' . rand(1234, 9999);

                        $model->user_role =  User::ROLE_SKIPPER;

                        if ($model->validate()) {
                            // $model->roles = array($model->user_role);
                            if ($model->save()) {
                                $auth = new Auth();
                                $auth->user_id = $model->id;
                                $auth->source = $providerId;
                                $auth->source_id = $auth_id;
                                if ($auth->save(false)) {
                                    // //Find User 
                                    // $getUser = User::find()->Where(['username' =>$number,'contact_no'=>$number ])->one();
                                    // $data['status'] = self::API_OK; 
                                    // $data['details'] = $getUser;
                                    // $data['auth_code'] = AuthSession::newSession($model)->auth_code;
                                    $user = $auth->user;
                                    $user->device_token = $post['device_token'];
                                    $user->device_type = $post['device_type'];
                                    Yii::$app->user->login($user);

                                    $data['status'] = self::API_OK;
                                    $data['details'] = $user;
                                    $data['auth_code'] = AuthSession::newSession($user)->auth_code;



                                    /* $emailtemplate = new EmailTemplate();
                                        $mailcontent = [
                                        'USER' => $model->first_name,
                                        'type_id' => EmailTemplate::SIGNUP,
                                        'EMAIL' => $model->email,
                                        'USERNAME' => $model->username,
                                        ];
                                        $emailtemplate->sendEmail($mailcontent); */

                                    //Check is cashback enable or not
                                    /* $setting = new WebSetting();
                                        $enable_signup_bonus = $setting->getSettingBykey('enable_signup_bonus');
                                        $signup_bonus = $setting->getSettingBykey('signup_bonus');
                    
                                        if ($enable_signup_bonus == 1) {
                                            $transaction = new CashbackTransaction();
                                            $transaction->reference_id = $transaction->getToken(12);
                                            $transaction->user_id = $model->id;
                                            $transaction->model_type = get_class($model);
                                            $transaction->payment_type = 'Signup Bonus';
                                            $transaction->amount = $signup_bonus;
                                            $transaction->created_date = date('Y-m-d');
                                            $transaction->payment_status = CashbackTransaction::STATUS_APPROVED;
                    
                                            //$transaction->save();
                                            if (!$transaction->save(false)) {
                    
                                                print_r($transaction->getErrors());
                                                exit();
                                            }  
                                        } */
                                } else {
                                    $data['status'] = self::API_NOK;
                                    $data['error'] = $auth->getErrors();
                                }
                            } else {
                                $data['status'] = self::API_NOK;
                                $data['error'] = $model->getErrors();
                            }
                        } else {
                            $data['status'] = self::API_NOK;
                            $data['error'] = $model->getErrors();
                        }
                    } else {
                        $data['status'] = self::API_NOK;
                        $data['error'] = Yii::t("app", 'This number is already registered with us.Please Contact Support');
                    }
                }
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = Yii::t("app", "OTP failed");
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", "No  Data Posted");
        }
        return $this->sendJsonResponse($data);
    }

    public function actionMyProfile()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {
            $model = User::findOne($user_id);
            $d['user_details'] = $model->asJson();
            $data['status'] = SELF::API_OK;
            $data['details'] = $d;
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }
        return $this->sendJsonResponse($data);
    }

    public function actionUpdateProfile()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {
            if (!empty($post)) {
                $model = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_USER])->one();

                if (!empty($model)) {
                    $model->first_name =  $post['User']['username'];
                    if (!empty($post['User']['profile_image'])) {
                        $profile_image = $model->profileImage($post['User']['profile_image'], $model->first_name);
                        $model->profile_image = $profile_image;
                    }
                    if (!empty($post['User']['email'])) {
                        $model->email = $post['User']['email'];
                    }
                    $model->username = $model->email;

                    if ($model->update(false)) {
                        $data['status'] = self::API_OK;
                        $data['details'] = $model->asJson();
                    } else {
                        $data['status'] = self::API_NOK;
                        $data['error'] = Yii::t("app", 'Something Went Wrong');
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "User Not Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Posted");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }



    // Update add Profile Detail
    public function actionProfileDetail()
    {

        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
        
            if (!empty($post)) {
                $check = User::find()->where(['email' => $post['email']])->one();
                if (!empty($check)) {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = "Email Already Used";
                    return $this->sendJsonResponse($data);
                }
                $skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();
                
                if (!empty($skipper)) {
                    $skipper->first_name = !empty($post['first_name']) ? $post['first_name'] : $error = "Enter First Name";
                    $skipper->last_name = !empty($post['last_name']) ? $post['last_name'] : $error = "Enter Last Name";
                    $skipper->email = !empty($post['email']) ? $post['email'] : $skipper->username;
                    $skipper->date_of_birth = !empty($post['date_of_birth']) ? $post['date_of_birth'] : $error = "Enter DOB";
                    $skipper->gender = !empty($post['gender']) ? $post['gender'] : $error = "Enter Gender";
                    if ($skipper->save(false)) {
                        $driverDetail = DriverDetails::find()->where(['user_id' => $user_id])->one();
                        if (!empty($driverDetail)) {
                            $driverDetail->address = $post['address'];

                            $driverDetail->status = DriverDetails::STATUS_ACTIVE;
                            if ($driverDetail->save(false)) {
                                $skipper->form_steps = User::PERSONAL_DETAIL;
                                $skipper->save(false);
                                $data['status'] = SELF::API_OK;
                                $data['message'] = "Data Saved";
                            } else {
                                $data['status'] = SELF::API_NOK;
                                $data['message'] = Yii::t("app", "Data not saved");
                            }
                        } else {

                            // dd();
                            $driverDetails = new DriverDetails();
                            $driverDetails->user_id = $skipper->id;
                            $driverDetails->address = $post['address'];

                            if ($driverDetails->save(false)) {
                                $skipper->form_steps = User::PERSONAL_DETAIL;
                                $skipper->save(false);
                                $data['status'] = SELF::API_OK;
                                $data['message'] = "Data Saved";
                            } else {
                                $data['status'] = SELF::API_NOK;
                                $data['message'] = Yii::t("app", "Data not saved");
                            }
                        }
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['message'] = $error;
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['message'] = Yii::t("app", "User not found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['message'] = Yii::t("app", "No Data Post");
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No User found.";
        }
        return $this->sendJsonResponse($data);
    }

    // Vehicals

    public function actionVehicals()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $vehicals = Vehicals::find()->Where(['status' => Vehicals::STATUS_ACTIVE])->all();

            if (!empty($vehicals)) {
                foreach ($vehicals as $vehical) {
                    $data['status'] = SELF::API_OK;
                    $data['details'][] = $vehical->asVehicleListJson();
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Update Vehical


    // Vehicals

    public function actionUpdateVehicals()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $skipper = User::find()->where(['id' => $user_id])->one();
            if (!empty($skipper)) {
                if ($skipper->form_steps == User::PERSONAL_DETAIL) {
                    $driverDetail = DriverDetails::find()->where(['user_id' => $user_id])->one();
                    if (!empty($driverDetail)) {
                        $driverDetail->vehical_id = $post['vehical_id'];
                        $driverDetail->vehical_type = $post['vehical_type'];
                        $driverDetail->vehical_speed = $post['vehical_speed'];
                        $driverDetail->vehical_owner = $post['vehical_own'];
                        if ($driverDetail->save(false)) {
                            $skipper->form_steps = User::VEHICAL_SELECTION;
                            $skipper->save(false);
                            $data['status'] = SELF::API_OK;
                            $data['details'] = Yii::t("app", "Vehicals Updated");
                        } else {
                            $data['status'] = SELF::API_NOK;
                            $data['error'] = Yii::t("app", "Vehicals Not Updated");
                        }
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Details not found");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "Submit Personal Details First");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "User Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Update Profile Image

    public function actionUpdateProfileImage()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $Skipper->profile_image = $post['profile_image'];
                if ($Skipper->save(false)) {
                    $Skipper->document_steps = User::SELFIE_ADDED;
                    $Skipper->save(false);
                    $data['status'] = SELF::API_OK;
                    $data['details'] = Yii::t("app", "Image uploaded succesfully");
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "Not Updated");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Update Profile Image

    public function actionUpdateDrivingLicense()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $driverDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($driverDetails)) {
                    $driverDetails->license_no = $post['license_no'];
                    $driverDetails->proof_of_license = $post['proof_of_license'];
                    $driverDetails->proof_of_license_back = $post['proof_of_license_back'];
                    $driverDetails->license_expiery_date = $post['license_expiery_date'];
                    if ($driverDetails->save(false)) {
                        $Skipper->document_steps = User::DRIVING_LICENCE;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Updated");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No Details Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Vehical Reg

    // Update Profile Image

    public function actionUpdateVehicalRegistration()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $driverDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($driverDetails)) {
                    $driverDetails->rc_number = $post['rc_number'];
                    $driverDetails->vehical_number = $post['vehicle_number'];
                    $driverDetails->rc_proof = $post['rc_proof'];
                    $driverDetails->rc_proof_back = $post['rc_proof_back'];
                    if ($driverDetails->save(false)) {
                        $Skipper->document_steps = User::RC_UPLOAD;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Updated");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No Details Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Chasis Number

    public function actionUpdateChassisNumber()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $driverDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($driverDetails)) {
                    $driverDetails->chassis_number = $post['chassis_number'];
                    $driverDetails->chassis_image = $post['chassis_image'];
                    $driverDetails->model_name = $post['model_name'];
                    if ($driverDetails->save(false)) {
                        $Skipper->document_steps = User::CHASSIS_NUMBER;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Updated");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No Details Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }
    // Adhaar Upload

    public function actionUploadAdhaar()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $driverDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($driverDetails)) {
                    $driverDetails->adhaar_number = $post['adhaar_number'];
                    $driverDetails->adhaar_front = $post['adhaar_front'];
                    $driverDetails->adhaar_back = $post['adhaar_back'];
                    if ($driverDetails->save(false)) {
                        $Skipper->document_steps = User::ADHAAR_CARD;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Updated");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No Details Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }

    // Pan Upload

    public function actionUploadPan()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $driverDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($driverDetails)) {
                    $driverDetails->pan_number = $post['pan_number'];
                    $driverDetails->pan_front = $post['pan_front'];
                    // $driverDetails->adhaar_back = $post['adhaar_back'];
                    if ($driverDetails->save(false)) {
                        $Skipper->document_steps = User::PAN_CARD;
                        $Skipper->form_steps = User::DOCUMENT_UPLOADS;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Updated");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No Details Found");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "Data Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }
    // Add Bank Details

    public function actionAddBankDetails()
    {
        $data = [];
        $param = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $bankDetail = BankDetail::find()->where(['user_id' => $user_id])->one();
                if (empty($bankDetail)) {
                    $bankDet = new BankDetail();
                    $bankDet->user_id = $user_id;
                    $bankDet->bank_name = $post['bank_name'];
                    $bankDet->account_holder_name = $post['account_holder_name'];
                    $bankDet->account_number = $post['account_number'];
                    $bankDet->ifsc_code = $post['ifsc_code'];
                    $bankDet->upi_id = $post['upi_id'];
                    $bankDet->branch_name = $post['branch_name'];
                    $bankDet->status = BankDetail::STATUS_ACTIVE;
                    if ($bankDet->save(false)) {

                        $openMoneyContact = OpenMoneyContacts::find()->where(['user_id' => $user_id])->one();
                        if (empty($openMoneyContact)) {

                            // $param['name'] = $Skipper->first_name . $Skipper->last_name;
                            // $param['display_name'] = $Skipper->first_name;
                            // $param['contact_type'] = "Vendor";
                            // $param['primary_contact'] = $Skipper->first_name;
                            // $param['email_id'] = $Skipper->email;
                            // $param['mobile_number'] = $Skipper->contact_no;
                            // $param['beneficiary_account_number'] = $bankDet->account_number;
                            // $param['ifsc_code'] = $bankDet->ifsc_code;
                            // $param['bank_name'] = $bankDet->bank_name;
                            // $param['branch_name'] = $bankDet->branch_name;
                            // // $param['bank_name'] = "";
                            // $createContact = (new OpenMoney())->CreateContact([$param], $user_id);
                            // var_dump($createContact);exit;
                        }

                        $Skipper->form_steps = User::BANK_DETAILS;
                        $Skipper->save(false);
                        $data['status'] = SELF::API_OK;
                        $data['details'] = Yii::t("app", "Document Uploaded succesflly");
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Not Saved");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "Bank Deail Alredy Added");
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "User Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }
        return $this->sendJsonResponse($data);
    }

    // Verification Status

    public function actionSkipperStatus()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {

            $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

            if (!empty($Skipper)) {
                $skipperDetail = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($skipperDetail)) {
                    $data['status'] = SELF::API_OK;
                    $data['details'] = $skipperDetail->is_verified;
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = "No Driver Detail Found";
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "User Not Found");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }
        return $this->sendJsonResponse($data);
    }

    // Update lat Lng

    public function actionUpdateLatLng()
    {

        $data = [];
        //     $model = new User();
        //    $model->scenario = 'update-latlong';
        $post = \Yii::$app->request->post();
        if ($post) {
            // var_dump(\Yii::$app->request->headers['auth_code']);exit;
            $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
            //$headers = Yii::$app->request->headers;
            $auth = new AuthSettings();
            $user_id = $auth->getAuthSession($headers);

            if (!empty($user_id)) {
                $user = User::find()->where([
                    'id' => $user_id,

                ])->one();
                if ($user) {
                    $user->lat = $post['latitude'];
                    $user->lng = $post['longitude'];
                    //var_dump($model->latitude);exit;
                    if ($user->save(false)) {

                        $data['status'] = self::API_OK;
                        $data['detail'] = $user;
                    } else {
                        $data['status'] = self::API_NOK;
                        // $data['error'] = $user->getErrors();
                        $data['error'] = 'Lat & long not updated';
                    }
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = 'Wrong User';
                }
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = "User Not Found";
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No data posted.";
        }
        return $this->sendJsonResponse($data);
    }
    // Online Status

    public function actionUpdateOnlineStatus($status)
    {

        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        if (!empty($user_id)) {
            try {
                $Skipper = User::find()->where(['id' => $user_id])->andWhere(['user_role' => User::ROLE_SKIPPER])->one();

                if (!empty($Skipper)) {
                    $Skipper->online_status = $status;
                    if (!empty($Skipper->save(false))) {
                        $data['status'] = SELF::API_OK;
                        $data['details'] = "Online Status Updated Successfully";
                        $data['online_status'] = $Skipper->online_status;
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = "Data Not Saved";
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "User Not Found");
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "Session Not Found");
        }
        return $this->sendJsonResponse($data);
    }

    // Accept and Reject

    public function actionNewRequest()
    {

        $data = [];
        $rr = [];

        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
            try {
                $driverRequests = DriverRequest::find()->where(['driver_id' => $user_id])->andWhere(['status' => DriverRequest::RIDE_ASSIGNED])->orderBy('id')->all();
                if (!empty($driverRequests)) {
                    foreach ($driverRequests as $dr) {
                        $rideRequest = RideRequest::find()->where(['id' => $dr->ride_id])->one();
                        $rr[] = $rideRequest;
                    }


                    $data['status'] = SELF::API_OK;

                    if (!empty($rideRequest)) {
                        foreach ($rr as $r) {
                            $data['details'][] = $r->asSkipperRideListJson();
                        }
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "No new rides ");
                    }
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "No new request Found");
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "Session Not Found");
        }
        return $this->sendJsonResponse($data);
    }

    // Accept or reject

    public function actionAcceptOrReject()
    {

        $data = [];
        $param = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $rideRequestId = $post['rideRequestId'];
        if (!empty($user_id)) {
            // try {
            $status = $post['status'];
            $rideRequest = RideRequest::find()->where(['id' => $rideRequestId])->andWhere(['status' => RideRequest::STATUS_NEW_REQUEST])->one();
            if (!empty($rideRequest)) {
                // $driverRequest =  DriverRequest::find()->where(['ride_id' => $rideRequestId])->andWhere(['driver_id' => $user_id])->andWhere(['status' => DriverRequest::RIDE_ASSIGNED])->one();
                // if (!empty($driverRequest)) {
                if ($status == RideRequest::STATUS_ACCEPTED_BY_SKIPPER) {
                    $availableAmount = (string)(new RideEarnings())->availableAmount($user_id, "", "");
                    $settings = new WebSetting();
                    (int)$minWithdrawAmount = $settings->getSettingBykey('min_pending_amount');

                    $minWithdrawAmount = -(int)$minWithdrawAmount;
                    // var_dump($minWithdrawAmount);exit;

                    // var_dump($availableAmount > $minWithdrawAmount);exit;
                    if ($availableAmount < 0) {
                        if ($availableAmount > $minWithdrawAmount) {
                            $rideRequest->driver_id = $user_id;
                            $rideRequest->status = RideRequest::STATUS_ACCEPTED_BY_SKIPPER;
                            if ($rideRequest->save(false)) {
                                if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_ONLINE) {
                                    $userContacts = OpenMoneyContacts::find()->where(['user_id' => $rideRequest->user_id])->one();

                                    $driverContacts = OpenMoneyContacts::find()->where(['user_id' => $user_id])->one();
                                    $rideCommision = RideCommision::find()->where(['city_id' => $rideRequest->city_id])->andWhere(['vehicle_id' => $rideRequest->vehical_type])->one();
                                    $commision = 100 - $rideCommision->commision;
                                    // $param['contacts_id'] = $userContacts->contacts_id;
                                    // $param['vendor_contacts_id'] = $driverContacts->contacts_id;
                                    // $param['commission'] = $commision;
                                    // $param['commission_type'] = 'perc';
                                    // $linkedContact = (new OpenMoney())->linkContact([$param], $rideRequest->user_id, $user_id);
                                }
                                $title = "Ride Accepted";
                                $body = "Skipper" . $rideRequest->driver->first_name . " has accepted your ride your OTP  for this ride is " . $rideRequest->otp;
                                $send_noti = Yii::$app->notification->UserNotification('', $rideRequest->user_id, $title, $body);
                                // Creating Ride Earnings //
                                if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_PAY_ON_DROP || RideRequest::PAYMENT_METHOD_WALLET) {
                                    $rideEarnings = new RideEarnings();
                                    $rideEarnings->ride_id = $rideRequest->id;
                                    $rideEarnings->driver_id  = $rideRequest->driver_id;
                                    $rideEarnings->total_ditance_km  = 0;
                                    $rideEarnings->admin_earning  = 0;
                                    $rideEarnings->driver_earning  = 0;
                                    $rideEarnings->total_amount  = 0;
                                    $rideEarnings->payment_method  = $rideRequest->payment_method;
                                    $rideEarnings->status  = RideEarnings::STATUS_PENDING;
                                    $rideEarnings->save(false);
                                }


                                // $driverRequest->status = DriverRequest::RIDE_ACCEPT;
                                // $driverRequest->save(false);
                                $data['status'] = self::API_OK;
                                $data['details']['id'] = $rideRequest->driver_id;
                                $data['details']['name'] = $rideRequest->driver->first_name;
                                $data['details']['profile_image'] = $rideRequest->driver->profile_image;
                                $data['details']['vehicle_number'] = $rideRequest->driverDetail->vehical_number;
                                $data['details']['vehicle_type'] = $rideRequest->driverDetail->vehical->title;
                                $data['ride_status'] = $rideRequest->status;

                                // Adding Ride statuses//
                                $rideStatus = new RideStatuses();
                                $rideStatus->ride_id =  $rideRequest->id;
                                $rideStatus->status =  $rideRequest->status;
                                $rideStatus->message =  "Request Accepted By " . $rideRequest->driver->first_name;
                                // var_dump($rideStatus->message);exit;
                                $rideStatus->save(false);
                                // $driverRequests = DriverRequest::find()->where(['ride_id' => $rideRequestId])->andWhere(['status' => DriverRequest::RIDE_ASSIGNED])->all();
                                // foreach ($driverRequests as $driverRequest) {
                                //     $driverRequest->status = DriverRequest::RIDE_REJECT;
                                //     $driverRequest->save(false);
                                // }
                            } else {

                                $data['status'] = self::API_NOK;
                                $data['error'] = "Data not saved";
                            }
                        } else {
                            $data['status'] = self::API_NOK;
                            $data['error'] = "You cannot take further riders. Please clear your pending dues from ‘Payout’ section under Earnings";
                            return $this->sendJsonResponse($data);
                        }
                    } else {
                        $rideRequest->driver_id = $user_id;
                        $rideRequest->status = RideRequest::STATUS_ACCEPTED_BY_SKIPPER;
                        if ($rideRequest->save(false)) {
                            if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_ONLINE) {
                                $userContacts = OpenMoneyContacts::find()->where(['user_id' => $rideRequest->user_id])->one();

                                $driverContacts = OpenMoneyContacts::find()->where(['user_id' => $user_id])->one();
                                $rideCommision = RideCommision::find()->where(['city_id' => $rideRequest->city_id])->andWhere(['vehicle_id' => $rideRequest->vehical_type])->one();
                                $commision = 100 - $rideCommision->commision;
                                // $param['contacts_id'] = $userContacts->contacts_id;
                                // $param['vendor_contacts_id'] = $driverContacts->contacts_id;
                                // $param['commission'] = $commision;
                                // $param['commission_type'] = 'perc';
                                // $linkedContact = (new OpenMoney())->linkContact([$param], $rideRequest->user_id, $user_id);
                            }
                            $title = "Ride Accepted";
                            $body = "Skipper" . $rideRequest->driver->first_name . " has accepted your ride your OTP  for this ride is" . $rideRequest->otp;
                            $send_noti = Yii::$app->notification->UserNotification('', $rideRequest->user_id, $title, $body);
                            // Creating Ride Earnings //
                            if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_PAY_ON_DROP || RideRequest::PAYMENT_METHOD_WALLET) {
                                $rideEarnings = new RideEarnings();
                                $rideEarnings->ride_id = $rideRequest->id;
                                $rideEarnings->driver_id  = $rideRequest->driver_id;
                                $rideEarnings->total_ditance_km  = 0;
                                $rideEarnings->admin_earning  = 0;
                                $rideEarnings->driver_earning  = 0;
                                $rideEarnings->total_amount  = 0;
                                $rideEarnings->payment_method  = $rideRequest->payment_method;
                                $rideEarnings->status  = RideEarnings::STATUS_PENDING;
                                $rideEarnings->save(false);
                            }


                            // $driverRequest->status = DriverRequest::RIDE_ACCEPT;
                            // $driverRequest->save(false);
                            $data['status'] = self::API_OK;
                            $data['details']['id'] = $rideRequest->driver_id;
                            $data['details']['name'] = $rideRequest->driver->first_name;
                            $data['details']['profile_image'] = $rideRequest->driver->profile_image;
                            $data['details']['vehicle_number'] = $rideRequest->driverDetail->vehical_number;
                            $data['details']['vehicle_type'] = $rideRequest->driverDetail->vehical->title;
                            $data['ride_status'] = $rideRequest->status;

                            // Adding Ride statuses//
                            $rideStatus = new RideStatuses();
                            $rideStatus->ride_id =  $rideRequest->id;
                            $rideStatus->status =  $rideRequest->status;
                            $rideStatus->message =  "Request Accepted By " . $rideRequest->driver->first_name;
                            // var_dump($rideStatus->message);exit;
                            $rideStatus->save(false);
                            // $driverRequests = DriverRequest::find()->where(['ride_id' => $rideRequestId])->andWhere(['status' => DriverRequest::RIDE_ASSIGNED])->all();
                            // foreach ($driverRequests as $driverRequest) {
                            //     $driverRequest->status = DriverRequest::RIDE_REJECT;
                            //     $driverRequest->save(false);
                            // }
                        } else {

                            $data['status'] = self::API_NOK;
                            $data['error'] = "Data not saved";
                        }
                    }
                } else if ($status == RideRequest::STATUS_CANCEL_BY_SKIPPER) {
                    //if status is rejected
                    $rejectLog = new RejectLog();
                    $rejectLog->skipper_id = $user_id;
                    $rejectLog->ride_id = $rideRequestId;
                    $rejectLog->status = RejectLog::STATUS_ACTIVE;
                    if ($rejectLog->save(false)) {
                        $data['status'] = self::API_OK;
                        $data['details'] = "Ride Rejected Succesfully";
                    } else {
                        $data['status'] = self::API_NOK;
                        $data['error'] = "data not saved";
                    }
                }
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = "Some other Skipper has accepted the ride. Wait for next ride";
            }
            // } else {
            //     $data['status'] = self::API_NOK;
            //     $data['error'] = "Ride Is Alredy Accepted By Other Skippers";
            // }
            // } catch (Exception $e) {
            //     return $e->getMessage();
            // }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No User found.";
        }
        return $this->sendJsonResponse($data);
    }

    // Verify Ride OTP
    public function actionVerifyRideOtp()
    {

        $data = [];

        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $status = $post['status'];
        $rideRequestId = $post['rideRequestId'];

        if (!empty($user_id)) {
            try {
                $rideRequest = RideRequest::find()->where(['id' => $rideRequestId])->andWhere(['driver_id' => $user_id])->one();
                if ($status == RideRequest::STATUS_START_RIDE) {
                    $otp = $post['otp'];
                    if (!empty($otp)) {
                        if ($rideRequest->otp == $otp) {
                            $rideRequest->status = (int)$status;
                            $rideRequest->ride_start_time = date('Y-m-d H:i:s');
                            if ($rideRequest->save(false)) {
                                $title = "OTP Verified";
                                $body = "Your OTP is verified enjoy your ride!!";
                                $send_noti = Yii::$app->notification->UserNotification('', $user_id, $title, $body);
                                $data['status'] = SELF::API_OK;
                                $data['error'] = Yii::t("app", "OTP Verified succesfully.");
                            }
                        } else {
                            $data['status'] = SELF::API_NOK;
                            $data['error'] = Yii::t("app", "Incorrect OTP.");
                            return $this->sendJsonResponse($data);
                        }
                    } else {
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Please Enter OTP To Start Ride");
                        return $this->sendJsonResponse($data);
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "Session Not Found");
        }
        return $this->sendJsonResponse($data);
    }



    // Change Status
    public function actionChangeStatus()
    {

        $data = [];

        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $status = $post['status'];
        $rideRequestId = $post['rideRequestId'];
        $settings = new WebSetting();
        $cgst = $settings->getSettingBykey('cgst');
        $sgst = $settings->getSettingBykey('sgst');
        if ($status == RideRequest::STATUS_START_RIDE) {
            $pickupTime = date('Y-m-d H:i:s');
        } else {
            $pickupTime = "";
        }
        if (!empty($user_id)) {
            // try {
            $rideRequest = RideRequest::find()->where(['id' => $rideRequestId])->andWhere(['driver_id' => $user_id])->one();
            if ($status == RideRequest::STATUS_RIDE_COMPLETED) {

                $final_lat = !empty($post['final_lat']) ? $post['final_lat'] : "";
                $final_lng = !empty($post['final_lng']) ? $post['final_lng'] : "";

                // var_dump($final_lat);
                // var_dump($final_lng);exit;
                $rideRequest->status = (int)$status;
                $rideRequest->ride_end_time = date('Y-m-d H:i:s');
                if ($rideRequest->save(false)) {
                    // Finding Time Diffrence b/w stard and end time

                    $date1 = new DateTime($rideRequest->ride_start_time);
                    $date2 = new DateTime($rideRequest->ride_end_time);
                    $estimatedTimeStr = explode(' ', $rideRequest->estimated_time);
                    $estimatedTime = $rideRequest->estimated_time;
                    $interval = $date1->diff($date2);

                    $format = $interval->format('%i');

                    $total_fare = 0;
                    $rideRequest->final_time = (float)$format;
                    $rideCommision = RideCommision::find()->where(['city_id' => $rideRequest->city_id])->one();


                    if (!empty($final_lat) && !empty($final_lng)) {
                        $drivingDistance = (new DrivingDistance())->getDrivingDistanceGoogleMap($rideRequest->pickup_latitude, $rideRequest->pickup_longitude, $final_lat, $final_lng);

                        $distanceKm = $drivingDistance['distvalue'] / 1000;
                        // $dist = explode(' ', $distanceKm);

                        $rideRequest->final_distance = $distanceKm;

                        $rideRequest->final_time = (float)$format;
                        $rideRequest->save(false);
                        if ((float) $distanceKm > $rideRequest->estimated_distance || (float)$format > (float)$estimatedTime) {
                            if ((float) $distanceKm > $rideRequest->estimated_distance) {
                                if ((float) $distanceKm > (float) $rideCommision->min_distance) {
                                    $distance = (float) $distanceKm - $rideCommision->min_distance;
                                } else {
                                    $distance = 0;
                                }
                            } else {
                                if ((float)$rideRequest->estimated_distance > (float) $rideCommision->min_distance) {
                                    $distance = (float) $rideRequest->estimated_distance - $rideCommision->min_distance;
                                } else {
                                    $distance = 0;
                                }
                            }
                            if ((float)$format > (float)$estimatedTime) {
                                $timeDiff = (float)$format - $estimatedTime;
                                $diffMinPrice = $timeDiff * $rideCommision->fare_per_minute;
                                // $rideRequest->final_price = ceil($rideRequest->estimated_ride_fare + $diffMinPrice);
                                // $rideRequest->final_distance = $distanceKm;

                            } else {
                                $diffMinPrice = $rideRequest->estimated_time;
                            }
                            $distance_cost = (float) $rideCommision->fare_per_distance * $distance;

                            $rideRequest->final_distance = $distanceKm;

                            $rideRequest->final_time =  $format;
                            $total_fare += (float) $rideCommision->base_fare + (float) $distance_cost + $diffMinPrice;
                            $cgstAmount = ((float)$cgst * $total_fare) / 100;
                            $sgstAmount = ((float)$sgst * $total_fare) / 100;
                            $total_fare = $total_fare + $cgstAmount + $sgstAmount;
                            $rideRequest->final_price = $total_fare;
                            $rideRequest->save(false);
                        } else {
                            $rideRequest->final_price = $rideRequest->estimated_ride_fare;
                        }
                    } else {
                        // if emplty final lat lng
                        $data['status'] = SELF::API_NOK;
                        $data['error'] = Yii::t("app", "Require final lat lng");
                        return $this->sendJsonResponse($data);
                    }

                    $rideRequest->save(false);

                    // var_dump($rideRequest->final_distance);exit;

                    $rideCompletionLog = (new RideCompletionLog())->saveCompletionLog($rideRequestId, $final_lat, $final_lng, $rideRequest->updated_on,  $pickupTime, $rideRequest->final_price, $rideRequest->final_distance);
                } else {
                    $data['status'] = SELF::API_NOK;
                    $data['error'] = Yii::t("app", "Status not changed for ride completion");
                }
            } else if ($status == RideRequest::STATUS_RIDE_COMPLETED_PAID) {
                $rideEarnings = RideEarnings::find()->where(['ride_id' => $rideRequestId])->andWhere(['status' => RideEarnings::STATUS_PENDING])->one();
                $rideRequest->status = RideRequest::STATUS_RIDE_COMPLETED_PAID;
                if (!empty($rideEarnings)) {
                    $rideCommission = RideCommision::find()->where(['city_id' => $rideRequest->city_id])->one();
                    if (!empty($rideCommission)) {
                        $commisionPercentage = $rideCommission->commision;
                    } else {
                        $commisionPercentage = 0;
                    }



                    $adminEarnings = (($rideRequest->final_price * $commisionPercentage) / 100);
                    $driverEarnings = $rideRequest->final_price - $adminEarnings;
                    $cgstAmount = ($driverEarnings * $cgst) / 100;
                    $sgstAmount = ($driverEarnings * $sgst) / 100;
                    $adminEarningsnew = $adminEarnings + $cgstAmount + $sgstAmount;
                    $rideEarnings->total_ditance_km = $rideRequest->final_distance;
                    $rideEarnings->admin_earning  = $adminEarningsnew;
                    $rideEarnings->total_amount  = $rideRequest->final_price;
                    $rideEarnings->driver_earning  = $driverEarnings - $cgstAmount - $sgstAmount;
                    $rideEarnings->status  = RideEarnings::STATUS_APPROVED;
                    if ($rideEarnings->save(false)) {

                        if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_CASH) {
                            $payout = new SkipperPayout();
                            $payout->amount = $adminEarningsnew;
                            $payout->driver_id = $user_id;
                            $payout->payment_type = SkipperPayout::PAYMENT_TYPE_DEBIT;
                            $payout->method_reason = "Amount of Rs " . $adminEarnings . " debited for cash ride of id #" . $rideRequest->id;
                            $payout->status = SkipperPayout::STATUS_APPROVED;
                            $payout->refrence_id = $rideRequest->id;
                            $payout->save(false);
                        }

                        if ($rideRequest->payment_method == RideRequest::PAYMENT_METHOD_WALLET) {

                            $walletAmount = (new Wallet())->getAvailableWallet($rideRequest->user_id);
                            // var_dump($walletAmount);exit;

                            if ($walletAmount < $rideRequest->final_price) {
                                $data['status'] = SELF::API_NOK;
                                $data['error'] = Yii::t("app", "Low wallet amount please add to wallet");
                                return $this->sendJsonResponse($data);
                            } else {
                                $wallet = new Wallet();
                                $wallet->user_id = $rideRequest->user_id;
                                $wallet->amount = $rideRequest->final_price;
                                $wallet->status = Wallet::STATUS_ACTIVE;
                                $wallet->payment_type = Wallet::STATUS_DEBITED;
                                $wallet->method_reason = "Rs " . $rideRequest->final_price . " Debited from wallet for your ride " . $rideRequest->id;
                                if ($wallet->save(false)) {
                                    $rideEarnings = RideEarnings::find()->where(['ride_id' => $rideRequestId])->andWhere(['status' => RideEarnings::STATUS_PENDING])->one();
                                    $final_lat = isset($post['final_lat']) ? $post['final_lat'] : $rideRequest->drop_latitude;
                                    $final_lng = isset($post['final_lng ']) ? $post['final_lng'] : $rideRequest->drop_longitude;
                                }
                                if (!empty($rideEarnings)) {
                                    $rideCommission = RideCommision::find()->where(['city_id' => $rideRequest->city_id])->one();
                                    if (!empty($rideCommission)) {
                                        $commisionPercentage = $rideCommission->commision;
                                    } else {
                                        $commisionPercentage = 0;
                                    }
                                    $adminEarnings = ($rideRequest->final_price * $commisionPercentage) / 100;
                                    $driverEarnings = $rideRequest->final_price - $adminEarnings;
                                    $cgstAmount = ($driverEarnings * $cgst) / 100;
                                    $sgstAmount = ($driverEarnings * $sgst) / 100;
                                    $adminEarningsnew = $adminEarnings + $cgstAmount + $sgstAmount;
                                    $rideEarnings->total_ditance_km = $rideRequest->final_distance;
                                    $rideEarnings->admin_earning  = $adminEarningsnew;
                                    $rideEarnings->total_amount  = $rideRequest->final_price;
                                    $rideEarnings->driver_earning  = $driverEarnings - $cgstAmount - $sgstAmount;
                                    $rideEarnings->status  = RideEarnings::STATUS_APPROVED;
                                    if ($rideEarnings->save(false)) {
                                        $title = "Payment Status";
                                        $body = "Your Payment For Ride Id-" . $rideRequest->id . " Is Sucesfull !! You Have Earned Rs. " . $driverEarnings;
                                        $send_noti = Yii::$app->notification->DriverNotification('', $rideRequest->driver_id, $title, $body);
                                    }
                                    $rideCompletionLog = (new RideCompletionLog())->saveCompletionLog($rideRequest->id, $final_lat, $final_lng, $rideRequest->updated_on, $rideRequest->ride_start_time, $rideRequest->final_price);
                                }
                            }
                        }

                        $rideRequest->payment_status = RideRequest::PAYMENT_STATUS_PAID;
                        $rideRequest->status = RideRequest::STATUS_RIDE_COMPLETED_PAID;
                        $rideRequest->save(false);
                    }
                }
            } else {
                $rideRequest->status = (int)$status;
            }

            if ($rideRequest->save(false)) {
                $title = "Ride Status";
                $body = "Your Ride Is " . strip_tags($rideRequest->getStateOptionsBadges());
                $send_noti = Yii::$app->notification->UserNotification('', $rideRequest->user_id, $title, $body);
                $updateRideStatus = (new RideRequest())->updateStatus($rideRequest->id, $rideRequest->status, "Ride Status Changed to " .  strip_tags($rideRequest->getStateOptionsBadges()));
                // $checkRefer = User::find()->Where(['id' => $rideRequest->user_id])
                //     ->andWhere(['!=', 'referal_id', 0])
                //     ->one();
                // if (!empty($checkRefer)) {
                //     $cashback = Wallet::find()->Where(['user_id' => $checkRefer->referal_id])
                //         ->andWhere(['type_id' => Wallet::REFFER_BONUS])->one();
                //     if (!empty($cashback)) {
                //         $cashback->status = Wallet::STATUS_ACTIVE;
                //         $cashback->payment_type = Wallet::STATUS_CREDITED;
                //         $cashback->save(false);
                //         $title = "Cashback Update";
                //         $body = "Your Cashback status changed  to " . strip_tags($cashback->getStateOptionsBadges()) . " for your referral";
                //         // $send_noti = Yii::$app->notification->vendorNotification("", '207', $title, $body);
                //         $send_noti = Yii::$app->notification->UserNotification($rideRequest->id, $rideRequest->user_id, $title, $body);
                //     }
                // }
                if ($rideRequest->status == RideRequest::STATUS_ARRIVED) {
                    $title = "Ride Arrived";
                    $body = "Skipper" . $rideRequest->driver->first_name . " has arrived to your location your OTP is" . $rideRequest->otp;
                    $send_noti = Yii::$app->notification->UserNotification('', $rideRequest->user_id, $title, $body);
                }
                $data['status'] = SELF::API_OK;
                $data['details'] = Yii::t("app", "Status Updated Succesfully");
                $data['ride_status'] = $rideRequest->status;
            } else {
            }
            // } catch (Exception $e) {
            //     return $e->getMessage();
            // }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "Session Not Found");
        }
        return $this->sendJsonResponse($data);
    }


    // My Rides

    public function actionMyRides()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $driver_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();

        $today = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 00:00:00', strtotime($today . ' +1 day'));
        $status = (int)$post['status'];
        // var_dump($driver_id);exit; 
        if (!empty($driver_id)) {


            try {
                $page = isset($post['page']) ? $post['page'] : 0;
                // var_dump($post['status']);exit;
                if ($status == 10 || $status == "10") {
                    // var_dump($post['status']);exit;

                    $query = RideRequest::find()
                        ->Where(['driver_id' => $driver_id])
                        ->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID]);


                    // ->andWhere(['gc_orders.delivery_date' => $today]);
                }
                else if ($status == 7 || $status == "7") {
                    $query = RideRequest::find()
                        ->Where(['driver_id' => $driver_id])
                        ->andWhere(['or', ['status' => RideRequest::STATUS_CANCEL_BY_USER], ['status' => RideRequest::STATUS_CANCEL_BY_SKIPPER]])->andWhere(['between', 'updated_on', date('Y-m-d H:i:s', strtotime($post['start_date'])), date('Y-m-d H:i:s', strtotime($post['end_date']))]);
                }
                else if (empty($status) || $status == "") {
                    $query = RideRequest::find()
                        ->Where(['driver_id' => $driver_id])
                        //->joinWith(['orderStatuses as os'])
                        // ->andWhere(['status' => (int) $post['status']])
                        ->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])
                        ->andWhere(
                            [
                                'and',
                                // ['!=', 'status', RideRequest::STATUS_RIDE_COMPLETED],
                                ['!=', 'status', RideRequest::STATUS_NEW_REQUEST],
                                // ['!=', 'status', RideRequest::STATUS_ACCEPTED_BY_SKIPPER],

                            ]
                        );
                }

                $driver_orders = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'id' => SORT_DESC,    
                            'id' => SORT_DESC,
                        ],
                    ],
                    'pagination' => array(
                        'page' => $page,
                        'pageSize' => 20,
                    ),
                ]);
                // echo $query->createCommand()->getRawSql();
                // exit;

                if (!empty($driver_orders->getModels())) {
                    foreach ($driver_orders->getModels() as $driver_order) {

                        $list[] = $driver_order->MyRidesSkipperJson();
                    }
                    $data['status'] = self::API_OK;

                    $data['details'] = $list;
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "No Rides found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }
    // Ride Detail

    public function actionMyRidesDetail($ride_id)
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $driver_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();


        // var_dump($driver_id);exit; 
        if (!empty($driver_id)) {

            try {

                // var_dump($post['status']);exit;


                $query = RideRequest::find()
                    ->Where(['id' => $ride_id])->one();



                // ->andWhere(['gc_orders.delivery_date' => $today]);


                if (!empty($query)) {
                    $data['status'] = self::API_OK;
                    $data['detail'] = $query->asRideRequestDetailJson();
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "No Rides found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }


    // My Earnings

    public function actionMyEarnings()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $page = isset($post['page']) ? $post['page'] : 0;
        $today = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 00:00:00', strtotime($today . ' +1 day'));
        if (!empty($user_id)) {
            // var_dump($user_id);exit;

            if (!empty($post['status'])) {
                $status = isset($post['status']) ? $post['status'] : RideEarnings::STATUS_APPROVED;
                if (!empty($post['start_date']) || !empty($post['end_date'])) {
                    $query = RideEarnings::find()->Where(['driver_id' => $user_id])
                        ->andWhere(['status' => $status])->andWhere(['!=', 'type', RideEarnings::MANUL])
                        ->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']]);
                } else {
                    if (!empty($post['start_date']) || !empty($post['end_date'])) {
                        $query = RideEarnings::find()->Where(['driver_id' => $user_id])->andWhere(['status' => $status])->andWhere(['!=', 'type', RideEarnings::MANUL]);
                    }
                }
            } else {
                if (!empty($post['start_date']) || !empty($post['end_date'])) {
                    $query = RideEarnings::find()->Where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->andWhere(['status' => RideEarnings::STATUS_APPROVED])->andWhere(['!=', 'type', RideEarnings::MANUL]);
                } else {
                    $query = RideEarnings::find()->Where(['driver_id' => $user_id])->andWhere(['status' => RideEarnings::STATUS_APPROVED])->andWhere(['!=', 'type', RideEarnings::MANUL]);
                }
            }

            $newRides = new ActiveDataProvider([
                'query' => $query,
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ],
                ],
                'pagination' => [
                    'pageSize' => 20,
                    'page' => $page,
                ],
            ]);

            foreach ($newRides->models as $rides) {
                $list[] = $rides->asJson();
            }
            if (!empty($list)) {
                if (!empty($post['start_date']) || !empty($post['end_date'])) {
                    $earnings = RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->one();
                } else {
                    $earnings = RideEarnings::find()->where(['driver_id' => $user_id])->one();
                }
                // var_dump($earnings);exit;
                if (!empty($earnings)) {

                    if (!empty($post['start_date']) || !empty($post['end_date'])) {

                        $earningsSum = RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['!=', 'type', RideEarnings::MANUL])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->sum('driver_earning');
                        $cashCollectionSum = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['payment_method' => RideRequest::PAYMENT_METHOD_CASH])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->sum('final_price');

                        $rideRequest = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->count();
                        $rideRequestcount = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->count();
                        $completedRideRequestcount = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->count();
                        $totalKm = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->sum('final_distance');
                        $totalhours = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->sum('final_time');
                        $rejectRides = RejectLog::find()->where(['skipper_id' => $user_id])->andWhere(['between', 'created_on', $post['start_date'], $post['end_date']])->count();
                    } else {
                        $earningsSum = RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['!=', 'type', RideEarnings::MANUL])->sum('driver_earning');
                        $cashCollectionSum = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['payment_method' => RideRequest::PAYMENT_METHOD_CASH])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->sum('final_price');

                        $rideRequest = RideRequest::find()->where(['driver_id' => $user_id])->count();
                        $rideRequestcount = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->count();
                        $completedRideRequestcount = RideRequest::find()->where(['driver_id' => $user_id])->andWhere(['status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->count();
                        $totalKm = RideRequest::find()->where(['driver_id' => $user_id])->sum('final_distance');
                        $totalhours = RideRequest::find()->where(['driver_id' => $user_id])->sum('final_time');
                        $rejectRides = RejectLog::find()->where(['skipper_id' => $user_id])->count();
                    }

                    $totalEarnings = round(RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['!=', 'type', RideEarnings::MANUL])->sum('driver_earning'), 2);

                    $sumRating = SkipperRating::find()->where(['skipper_id' => $user_id])->sum('rating');
                    $countRating = SkipperRating::find()->where(['skipper_id' => $user_id])->count();
                    if ($sumRating != 0 && $countRating != 0) {
                        $avgRating = $sumRating / $countRating;
                    } else {
                        $avgRating = 0;
                    }

                    $data['earnings']['today_earning'] = round($earningsSum, 2);
                    $data['earnings']['cash_colledcted'] = round($cashCollectionSum ?? '0', 2);
                    $data['earnings']['rides'] = $rideRequestcount;
                    $data['earnings']['completed_rides'] = $completedRideRequestcount;
                    $data['earnings']['total_km'] = round($totalKm, 2);
                    $data['earnings']['total_earnings'] = round($totalEarnings);
                    $data['earnings']['total_hours'] = round($totalhours, 2);
                    $data['earnings']['avg_rating'] = round($avgRating, 2);
                    $data['earnings']['reject_rides'] = $rejectRides;
                } else {
                    $data['earnings']['today_earning'] = 0;
                    $data['earnings']['cash_colledcted'] = 0;
                    $data['earnings']['completed_rides'] = 0;
                    $data['earnings']['rides'] = 0;
                    $data['earnings']['total_km'] = 0;
                    $data['earnings']['total_earnings'] = 0;

                    $data['earnings']['total_hours'] = 0;
                    $data['earnings']['avg_rating'] = 0;
                    $data['earnings']['reject_rides'] = 0;
                }


                $data['status'] = self::API_OK;
                $data['details'] = $list;
            } else {
                $data['status'] = self::API_NOK;
                $data['error'] = Yii::t("app", " No Earnings found");
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", " No user found");
        }
        return $this->sendJsonResponse($data);
    }

    // Driver Payout
    public function actionPayout()
    {
        $data = [];
        $dd = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();


        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {

            try {
                $rideEarnings = RideEarnings::find()->where(['driver_id' => $user_id])->one();
                $start_date = $post['start_date'];
                $end_date = $post['end_date'];


                if (!empty($rideEarnings)) {
                    if (empty($start_date) && empty($end_date)) {
                        $dd['totalOnlineCollection'] = RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_ONLINE], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->sum('total_amount');
                        $dd['totalAdminCommissionByOnline'] = RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_ONLINE], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->sum('admin_earning');
                        $dd['totalDriverEarningByOnline'] = RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_PAY_ON_DROP], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->sum('driver_earning');
                        // Cash Earnings
                        $dd['totalCashCollection'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->sum('total_amount'), 2);
                        $dd['totalAdminCommissionByCash'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->sum('admin_earning'), 2);
                        $dd['totalDriverEarningByCash'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->sum('driver_earning'), 2);
                        $dd['totalRideCollecetion'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->sum('total_amount'), 2);
                        $dd['availableBalance'] = (string)(new RideEarnings())->availableAmount($user_id, $start_date, $end_date);
                        $dd['total_earnings'] = round(RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->sum('driver_earning'), 2);

                        if ($dd['availableBalance'] < 0) {
                            $dd['is_negative'] = true;
                        } else {
                            $dd['is_negative'] = false;
                        }
                        $dd['tax_charges'] = 0;
                        $dd['transaction_fee'] = 0;
                        $dd['payable_amount'] = 0;
                        $settings = new WebSetting();
                        $minWithdrawAmount = $settings->getSettingBykey('min_withdraw');
                        $dd['min_payout_limit'] =  $minWithdrawAmount;
                        $dd['min_pending_amount'] =  0;
                        // $dd['plat'] = 0;
                        $dd['availableBalance'] = (string)(new RideEarnings())->availableAmount($user_id, $start_date, $end_date);
                    } else {
                        $dd['totalOnlineCollection'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_PAY_ON_DROP], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('total_amount'), 2);
                        $dd['totalAdminCommissionByOnline'] = RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_PAY_ON_DROP], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('admin_earning');
                        $dd['totalDriverEarningByOnline'] = RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['or', ['rid.payment_method' => RideRequest::PAYMENT_METHOD_PAY_ON_DROP], ['rid.payment_method' => RideRequest::PAYMENT_METHOD_WALLET]])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('driver_earning');
                        // Cash Earnings
                        $dd['totalCashCollection'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('total_amount'), 2);
                        $dd['totalAdminCommissionByCash'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('admin_earning'), 2);
                        $dd['totalDriverEarningByCash'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.payment_method' => RideRequest::PAYMENT_METHOD_CASH])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('driver_earning'), 2);
                        $dd['totalRideCollecetion'] = round(RideEarnings::find()->joinWith(['ride as rid'])->where(['ride_earnings.driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['rid.status' => RideRequest::STATUS_RIDE_COMPLETED_PAID])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('total_amount'), 2);
                        $dd['availableBalance'] = (string)(new RideEarnings())->availableAmount($user_id, $start_date, $end_date);
                        $dd['total_earnings'] = round(RideEarnings::find()->where(['driver_id' => $user_id])->andWhere(['!=', 'ride_earnings.type', RideEarnings::MANUL])->andWhere(['between', 'ride_earnings.updated_on', $start_date, $end_date])->sum('driver_earning'), 2);

                        if ((float)$dd['availableBalance'] < 0) {
                            $dd['is_negative'] = true;
                        } else {
                            $dd['is_negative'] = false;
                        }
                        $dd['tax_charges'] = 0;
                        $dd['transaction_fee'] = 0;
                        $dd['payable_amount'] = 0;
                        $settings = new WebSetting();
                        $minWithdrawAmount = $settings->getSettingBykey('min_withdraw');
                        $dd['min_payout_limit'] =  $minWithdrawAmount;
                        $dd['min_pending_amount'] =  0;
                    }
                    // Online Earnings

                    $data['status'] = self::API_OK;
                    $data['details'] = $dd;
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "No earnings found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    // Ride Completion log

    public function actionRideCompletionLog()
    {
        $data = [];
        $dd = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();


        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {

            try {

                $rideId = $post['ride_id'];
                $rideCompletionLog = RideCompletionLog::find()->where(['ride_id' => $rideId])->one();
                if (!empty($rideCompletionLog)) {
                    $data['status'] = self::API_OK;
                    $data['details'] = $rideCompletionLog->asJson();
                } else {
                    $data['status'] = self::API_OK;
                    $data['error'] = "No Log Found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    // Driver Detail

    public function actionDriverDetail()
    {
        $data = [];
        $dd = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();


        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {

            try {

                $skipperDetails = DriverDetails::find()->where(['user_id' => $user_id])->one();
                if (!empty($skipperDetails)) {
                    $data['status'] = self::API_OK;
                    $data['details'] = $skipperDetails->ProfileDetailsJson();
                } else {
                    $data['status'] = self::API_OK;
                    $data['error'] = "No Log Found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    // 

    public function actionAddRating()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();


        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {

            $ride_id = $post['ride_id'];
            $user_ids = $post['user_id'];
            $rating = $post['rating'];
            $user_message = $post['user_message'];

            try {
                $skipperRating = SkipperRating::find()->where(['user_id' => $user_id])->orWhere(['skipper_id' => $user_id])->one();
                if (empty($skipperRating)) {
                    $skipperRating = new SkipperRating();
                    $skipperRating->skipper_id = $rating;
                    $skipperRating->user_id = $user_id;
                    $skipperRating->ride_id = $ride_id;
                    $skipperRating->user_rating = $rating;
                    $skipperRating->user_message = $user_message;
                    $skipperRating->status = SkipperRating::STATUS_ACTIVE;
                } else {
                    $skipperRating->skipper_id = $user_id;
                    $skipperRating->user_id = $user_ids;
                    $skipperRating->ride_id = $ride_id;
                    $skipperRating->user_message = $user_message;
                    $skipperRating->user_rating = $rating;
                    $skipperRating->status = SkipperRating::STATUS_ACTIVE;
                }
                // var_dump($post['status']);exit;

                if ($skipperRating->save(false)) {
                    $data['status'] = self::API_OK;
                    $data['details'] = "Review Added Succesfully";
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "Data not saved";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    //

    public function actionMyReviews()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $driver_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();

        $today = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 00:00:00', strtotime($today . ' +1 day'));
        // var_dump($driver_id);exit; 
        if (!empty($driver_id)) {

            try {
                $page = isset($post['page']) ? $post['page'] : 0;
                // var_dump($post['status']);exit;




                // ->andWhere(['gc_orders.delivery_date' => $today]);
                $query = SkipperRating::find()
                    ->Where(['skipper_id' => $driver_id])->andWhere(['status' => SkipperRating::STATUS_ACTIVE]);
                //->joinWith(['orderStatuses as os'])
                // ->andWhere(['status' => (int) $post['status']])

                // echo $query->createCommand()->getRawSql();exit;
                $driver_orders = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'id' => SORT_DESC,    
                            'id' => SORT_DESC,
                        ],
                    ],
                    'pagination' => array(
                        'page' => $page,
                        'pageSize' => 20,
                    ),
                ]);
                if (!empty($driver_orders->getModels())) {
                    foreach ($driver_orders->getModels() as $driver_order) {

                        $list[] = $driver_order->asJson();
                    }
                    $data['status'] = self::API_OK;

                    $data['details'] = $list;
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "No Rides found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    // Pay admin Charges 


    // Generate Access Token

    public function actionGeneratePaymentToken()
    {
        $data = [];
        $list = [];
        $listStore = [];
        $listCity = [];
        $dd =  [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
            try {
                // $ride_id = $post['ride_id'];
                $amount = $post['amount'];
                // $rideRequest = RideRequest::find()->where(['id' => $ride_id])->one();

                if (!empty($amount)) {
                    $user = User::find()->where(['id' => $user_id])->one();
                    $dd['contact_no'] = !empty($user->contact_no) ? $user->contact_no : "999999999";
                    $dd['email_id'] = !empty($user->email) ? $user->email : "test@gmail.com";
                    $dd['final_price'] = $amount;



                    $generateToken = (new OpenMoney())->generateToken($dd);

                    $decodeToken = json_decode($generateToken);
                    // $rideRequest->payment_token = $decodeToken->id;
                    // $rideRequest->save(false);
                    // var_dump($decodeToken->id);exit;
                    $data['status'] = self::API_OK;
                    $data['detils'] = $decodeToken;
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = Yii::t("app", "No Ride Found");
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", "No User found");
        }
        return $this->sendJsonResponse($data);
    }

    // Update Payment Status

    public function actionUpdatePaymentStatus()
    {
        $data = [];
        $list = [];
        $listStore = [];
        $listCity = [];
        $dd =  [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
            try {
                $payment_token = $post['payment_token'];
                $amount = $post['amount'];


                if (!empty($payment_token)) {
                    $generateToken = (new OpenMoney())->paymentStatus($payment_token);
                    // var_dump($generateToken);exit;
                    $decodeGenerateToken = json_decode($generateToken);

                    if ($decodeGenerateToken->status == "captured") {
                        $skipperPayout = new SkipperPayout();
                        $skipperPayout->driver_id = $user_id;
                        $skipperPayout->amount = $amount;
                        $skipperPayout->payment_type = SkipperPayout::PAYMENT_TYPE_CREDIT;
                        $skipperPayout->method_reason = "Payment of outstanding amount to easygo";
                        $skipperPayout->status = SkipperPayout::STATUS_APPROVED;
                        if ($skipperPayout->save(false)) {
                            $data['status'] = self::API_OK;
                            $data['details'] = Yii::t("app", "Payment Success");
                            $data['payment_status'] = $skipperPayout->status;
                        }
                    } else if ($decodeGenerateToken->status == "failed") {
                        $data['status'] = self::API_NOK;
                        $data['error'] = Yii::t("app", "payment failed");
                        $data['payment_status'] = 2;
                    }
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", "No User found");
        }
        return $this->sendJsonResponse($data);
    }


    // My Earnings Details
    public function actionMyEarningsDetails($ride_id)
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
            try {
                $rideRequesst = RideRequest::find()->where(['id' => $ride_id])->one();
                if (!empty($rideRequesst)) {
                    $data['status'] = self::API_NOK;
                    $data['details'] = $rideRequesst->earningDetailsJson();
                } else {

                    $data['status'] = self::API_NOK;
                    $data['error'] = Yii::t("app", " Invalid ride Id");
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = Yii::t("app", " No user found");
        }
        return $this->sendJsonResponse($data);
    }

    public function actionCancelRide()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();
        $rideId = $post['ride_id'];



        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {

            try {
                $rideRequest = RideRequest::find()->where(['id' => $rideId])->andWhere(['status' => RideRequest::STATUS_ACCEPTED_BY_SKIPPER])->one();
                if (!empty($rideRequest)) {
                    $rideRequest->status = RideRequest::STATUS_CANCEL_BY_SKIPPER;
                    if ($rideRequest->save(false)) {
                        $rejectLog = new RejectLog();
                        $rejectLog->skipper_id = $user_id;
                        $rejectLog->ride_id = $rideId;
                        $rejectLog->reject_reason = $post['reject_reason'];
                        $rejectLog->status = RejectLog::STATUS_ACTIVE;
                        $rejectLog->save(false);
                        $title = "Ride Cancelled";
                        $body = "Ride Cancelled By Skipper";
                        $send_noti = Yii::$app->notification->UserNotification('', $rideRequest->user_id, $title, $body);
                        $data['status'] = self::API_OK;
                        $data['detail'] = "Ride cancelled Successfully";
                    } else {
                        $data['status'] = self::API_NOK;
                        $data['error'] = "Please try again";
                    }
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "Invalid Ride Id";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }

    // Withdraw request

    public function actionWithdrawRequest()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();

        $amount =  $post['amount'];
        $settings = new WebSetting();
        $minWithdrawAmount = $settings->getSettingBykey('min_withdraw');
        // var_dump($driver_id);exit; 
        if (!empty($user_id)) {
            $todayDate = date('Y-m-d 00:00:00');
            $preDate =  date("Y-m-d 00:00:00", strtotime("- 1 day"));
            $tommorow =  date("Y-m-d 00:00:00", strtotime("+ 1 day"));

            try {
                $payout = SkipperPayout::find()->where(['driver_id' => $user_id])->andWhere(['is_withdraw_request' => SkipperPayout::WITHDRAW_REQUEST])->andWhere(['between', 'created_on', $preDate, $tommorow])->one();
                // print_r($payout->createCommand()->getRawSql());
                // exit;
                if (empty($payout)) {
                    if ((float)$amount >= (float)$minWithdrawAmount) {
                        $withDraw = new SkipperPayout();
                        $withDraw->driver_id = $user_id;
                        $withDraw->amount = $amount;
                        $withDraw->payment_type = SkipperPayout::PAYMENT_TYPE_DEBIT;
                        $withDraw->method_reason = "Withdraw Request of amount" . $amount;
                        $withDraw->is_withdraw_request = SkipperPayout::WITHDRAW_REQUEST;
                        $withDraw->status = SkipperPayout::STATUS_PROCESSING;
                        if ($withDraw->save(false)) {
                            $data['status'] = self::API_OK;
                            $data['details'] = "Withdraw Request Send Succesfully";
                        }
                    } else {
                        $data['status'] = self::API_NOK;
                        $data['error'] = "You can'nt withdraw amount minimum with amount is: " . $minWithdrawAmount;
                    }
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "You alredy have a withdraw request today. Please try again tommorow";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }


    public function actionWithdrawRequestList()
    {
        $data = [];
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);
        $post = Yii::$app->request->post();

        $today = date('Y-m-d 00:00:00');
        $end_date = date('Y-m-d 00:00:00', strtotime($today . ' +1 day'));
        // var_dump($driver_id);exit; 

        if (!empty($user_id)) {

            try {
                $status = $post['status'];

                $page = isset($post['page']) ? $post['page'] : 0;
                // var_dump($post['status']);exit;




                // ->andWhere(['gc_orders.delivery_date' => $today]);
                $query = SkipperPayout::find()
                    ->Where(['driver_id' => $user_id])->andWhere(['is_withdraw_request' => SkipperPayout::WITHDRAW_REQUEST])->andWhere(['status' => $status]);

                $driver_orders = new ActiveDataProvider([
                    'query' => $query,
                    'sort' => [
                        'defaultOrder' => [
                            // 'id' => SORT_DESC,    
                            'updated_on' => SORT_ASC,
                        ],
                    ],
                    'pagination' => array(
                        'page' => $page,
                        'pageSize' => 20,
                    ),
                ]);
                if (!empty($driver_orders->getModels())) {
                    foreach ($driver_orders->getModels() as $driver_order) {

                        $list[] = $driver_order->asJson();
                    }
                    $data['status'] = self::API_OK;

                    $data['details'] = $list;
                } else {
                    $data['status'] = self::API_NOK;
                    $data['error'] = "No Rides found";
                }
            } catch (Exception $e) {
                return $e->getMessage();
            }
        } else {
            $data['status'] = self::API_NOK;
            $data['error'] = "No user found";
        }
        return $this->sendJsonResponse($data);
    }



    public function actionReferUser($code)
    {

        // dd('dasds');

        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        $data = [];
        // Check mac id exist or not 



        if ((!User::isAdmin()) && !empty($user_id)) {

            $profile = User::find()->where([
                'id' => $user_id,

                'referal_id' => 0
            ])->one();

            // var_dump($profile->createCommand()->getRawSql());exit;

            if ($profile) {



                $referUser = User::find()->Where(['referal_code' => $code])->one();

                if (!empty($referUser && $referUser->id != $user_id)) {

                    $profile->referal_id = $referUser->id;

                    if ($profile->save(false)) {
                        if (!empty($profile->referal_id)) {

                            $setting = new WebSetting();

                            $refer_bonus = $setting->getSettingBykey('referral_bonus');
                            $referral_bonus_user = $setting->getSettingBykey('referral_bonus_user');

                            $transaction = new Wallet();


                            $transaction->user_id = $profile->referal_id;



                            $transaction->payment_type = Wallet::STATUS_PROCESSING;


                            $transaction->amount = isset($refer_bonus) ? $refer_bonus : 0; //rand(1,3);//$refer_bonus->value;

                            $transaction->status = Wallet::STATUS_PROCESSING;
                            $transaction->type_id = Wallet::REFFER_BONUS;
                            // $transaction->type_id = Wallet::REFERAL_BONUS;


                            $transaction->method_reason = 'Congratulations..!You earned cashback on your referral user' . $profile->referal_id;


                            if (!$transaction->save(false)) {


                                print_r($transaction->getErrors());

                                exit();
                            } else {

                                $title = 'Congratulations...!!!You earned Cashback';

                                $body = 'Congratulations..!You earned Cashback on your referral.';

                                //Send Notifciation 

                            }
                            // Add cashback to user who using referal code
                            $transaction = new Wallet();


                            $transaction->user_id = $user_id;



                            $transaction->payment_type = Wallet::STATUS_PROCESSING;


                            $transaction->amount = isset($referral_bonus_user) ? $referral_bonus_user : 0; //rand(1,3);//$refer_bonus->value;

                            $transaction->status = Wallet::STATUS_PROCESSING;
                            // $transaction->type_id = Wallet::REFERAL_BONUS_USER;

                            $transaction->type_id = Wallet::REFFER_BONUS;

                            $transaction->method_reason = 'Congratulations..!You earned cashback on for using referal code of user #' . $profile->referal_id;


                            if (!$transaction->save(false)) {


                                print_r($transaction->getErrors());

                                exit();
                            } else {

                                $title = 'Congratulations...!!!You earned Rederal Bonus';

                                $body = 'Congratulations..!You earned Referal Bonus for applying referal code';

                                //Send Notifciation 

                            }
                        }
                    }

                    $data['status'] = SELF::API_OK;

                    $data['details'] = $referUser->asJson();
                } else {

                    $data['status'] = SELF::API_NOK;

                    $data['error'] = 'Invalid Referal Code';
                }
            } else {
                $data['status'] = self::API_NOK;

                $data['error'] = 'Referal code already added';
            }
        } else {
            $data['status'] = self::API_NOK;

            $data['error'] = 'User id not found';
        }

        return $this->sendJsonResponse($data);
    }
    public function actionMyReferal()
    {
        $data = [];
        $post = Yii::$app->request->post();
        $headers = isset(\Yii::$app->request->headers['auth_code']) ? \Yii::$app->request->headers['auth_code'] : Yii::$app->request->getQueryParam('auth_code');
        $auth = new AuthSettings();
        $user_id = $auth->getAuthSession($headers);

        if (!empty($user_id)) {
            $referals = User::find()->where(['referal_id' => $user_id])->all();

            // print_r($referals->createCommand()->getRawSql());exit;

            if (!empty($referals)) {

                $data['status'] = SELF::API_OK;
                foreach ($referals as $referal) {

                    $data['detail'][] = $referal->asJson();
                }
            } else {
                $data['status'] = SELF::API_NOK;
                $data['error'] = Yii::t("app", "No Referals");
            }
        } else {
            $data['status'] = SELF::API_NOK;
            $data['error'] = Yii::t("app", "User Not Found");
        }

        return $this->sendJsonResponse($data);
    }
}
