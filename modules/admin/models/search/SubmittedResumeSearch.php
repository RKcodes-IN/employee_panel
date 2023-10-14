<?php

namespace app\modules\admin\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\admin\models\SubmittedResume;

/**
 * app\modules\admin\models\search\SubmittedResumeSearch represents the model behind the search form about `app\modules\admin\models\SubmittedResume`.
 */
 class SubmittedResumeSearch extends SubmittedResume
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'resume_id', 'status', 'create_user_id', 'update_user_id'], 'integer'],
            [['first_name', 'middle_name', 'last_name', 'date_of_birth', 'gender', 'nationality', 'marital_status', 'passport', 'hobbies', 'languages', 'address', 'landmark', 'city', 'state', 'pincode', 'mobile', 'email', 'ssc_result', 'ssc_board', 'ssc_pass_year', 'hsc_result', 'hsc_board', 'hsc_pass_year', 'graduation_degree', 'graduation_result', 'graduation_univesity', 'graduation_year', 'post_graduatiion_degree', 'post_graduatiion_result', 'post_graduatiion_year', 'post_graduatiion_univesity', 'high_level_education', 'total_work_experience', 'total_work_experience_in', 'no_of_companies', 'last_employer', 'submission_status', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = SubmittedResume::find()->where(['status'=>SubmittedResume::STATUS_ACTIVE])->orWhere(['status'=>SubmittedResume::STATUS_INACTIVE]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_on' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'resume_id' => $this->resume_id,
            'status' => $this->status,
            'create_user_id' => $this->create_user_id,
            'update_user_id' => $this->update_user_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'date_of_birth', $this->date_of_birth])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'hobbies', $this->hobbies])
            ->andFilterWhere(['like', 'languages', $this->languages])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'pincode', $this->pincode])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ssc_result', $this->ssc_result])
            ->andFilterWhere(['like', 'ssc_board', $this->ssc_board])
            ->andFilterWhere(['like', 'ssc_pass_year', $this->ssc_pass_year])
            ->andFilterWhere(['like', 'hsc_result', $this->hsc_result])
            ->andFilterWhere(['like', 'hsc_board', $this->hsc_board])
            ->andFilterWhere(['like', 'hsc_pass_year', $this->hsc_pass_year])
            ->andFilterWhere(['like', 'graduation_degree', $this->graduation_degree])
            ->andFilterWhere(['like', 'graduation_result', $this->graduation_result])
            ->andFilterWhere(['like', 'graduation_univesity', $this->graduation_univesity])
            ->andFilterWhere(['like', 'graduation_year', $this->graduation_year])
            ->andFilterWhere(['like', 'post_graduatiion_degree', $this->post_graduatiion_degree])
            ->andFilterWhere(['like', 'post_graduatiion_result', $this->post_graduatiion_result])
            ->andFilterWhere(['like', 'post_graduatiion_year', $this->post_graduatiion_year])
            ->andFilterWhere(['like', 'post_graduatiion_univesity', $this->post_graduatiion_univesity])
            ->andFilterWhere(['like', 'high_level_education', $this->high_level_education])
            ->andFilterWhere(['like', 'total_work_experience', $this->total_work_experience])
            ->andFilterWhere(['like', 'total_work_experience_in', $this->total_work_experience_in])
            ->andFilterWhere(['like', 'no_of_companies', $this->no_of_companies])
            ->andFilterWhere(['like', 'last_employer', $this->last_employer])
            ->andFilterWhere(['like', 'submission_status', $this->submission_status])
            ->andFilterWhere(['like', 'created_on', $this->created_on])
            ->andFilterWhere(['like', 'updated_on', $this->updated_on]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with managersearch query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function managersearch($params)
    {
        $query = SubmittedResume::find()
                     ->where(['city_id' => \Yii::$app->user->identity->city_id])
        ;

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_on' => SORT_DESC,
                ],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'resume_id' => $this->resume_id,
            'status' => $this->status,
            'create_user_id' => $this->create_user_id,
            'update_user_id' => $this->update_user_id,
        ]);

        $query->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'date_of_birth', $this->date_of_birth])
            ->andFilterWhere(['like', 'gender', $this->gender])
            ->andFilterWhere(['like', 'nationality', $this->nationality])
            ->andFilterWhere(['like', 'marital_status', $this->marital_status])
            ->andFilterWhere(['like', 'passport', $this->passport])
            ->andFilterWhere(['like', 'hobbies', $this->hobbies])
            ->andFilterWhere(['like', 'languages', $this->languages])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'landmark', $this->landmark])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'pincode', $this->pincode])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'ssc_result', $this->ssc_result])
            ->andFilterWhere(['like', 'ssc_board', $this->ssc_board])
            ->andFilterWhere(['like', 'ssc_pass_year', $this->ssc_pass_year])
            ->andFilterWhere(['like', 'hsc_result', $this->hsc_result])
            ->andFilterWhere(['like', 'hsc_board', $this->hsc_board])
            ->andFilterWhere(['like', 'hsc_pass_year', $this->hsc_pass_year])
            ->andFilterWhere(['like', 'graduation_degree', $this->graduation_degree])
            ->andFilterWhere(['like', 'graduation_result', $this->graduation_result])
            ->andFilterWhere(['like', 'graduation_univesity', $this->graduation_univesity])
            ->andFilterWhere(['like', 'graduation_year', $this->graduation_year])
            ->andFilterWhere(['like', 'post_graduatiion_degree', $this->post_graduatiion_degree])
            ->andFilterWhere(['like', 'post_graduatiion_result', $this->post_graduatiion_result])
            ->andFilterWhere(['like', 'post_graduatiion_year', $this->post_graduatiion_year])
            ->andFilterWhere(['like', 'post_graduatiion_univesity', $this->post_graduatiion_univesity])
            ->andFilterWhere(['like', 'high_level_education', $this->high_level_education])
            ->andFilterWhere(['like', 'total_work_experience', $this->total_work_experience])
            ->andFilterWhere(['like', 'total_work_experience_in', $this->total_work_experience_in])
            ->andFilterWhere(['like', 'no_of_companies', $this->no_of_companies])
            ->andFilterWhere(['like', 'last_employer', $this->last_employer])
            ->andFilterWhere(['like', 'submission_status', $this->submission_status])
            ->andFilterWhere(['like', 'created_on', $this->created_on])
            ->andFilterWhere(['like', 'updated_on', $this->updated_on]);

        if(isset ($this->created_on)&&$this->created_on!=''){ 
           
           //you dont need the if function if yourse sure you have a not null date
            $date_explode=explode(" - ",$this->created_on);
         //   var_dump($date_explode);exit;
            $date1=trim($date_explode[0]);
           $date2=trim($date_explode[1]);
           $query->andFilterWhere(['between','created_on',$date1,$date2]);
          // var_dump($query->createCommand()->getRawSql());exit;
          }
       if(isset ($this->updated_on)&&$this->updated_on!=''){ 
      
           //you dont need the if function if yourse sure you have a not null date
            $date_explode=explode(" - ",$this->updated_on);
         //   var_dump($date_explode);exit;
            $date1=trim($date_explode[0]);
           $date2=trim($date_explode[1]);
           $query->andFilterWhere(['between','updated_on',$date1,$date2]);
          //  var_dump($query->createCommand()->getRawSql());exit;
          }

        return $dataProvider;
    }
}
