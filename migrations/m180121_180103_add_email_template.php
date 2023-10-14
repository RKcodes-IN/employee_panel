<?php

use yii\db\Migration;
use ymaker\email\templates\entities\EmailTemplate;

/**
 * Handles creating of email template.
 *
 * Generated by `yiimaker/yii2-email-templates`.
 * @see https://github.com/yiimaker/yii2-email-templates
 */
class m180121_180103_add_email_template extends Migration
{
    /**
     * Migration table name.
     *
     * @var string
     */
    public $tableName = '{{%email_template}}';
    /**
     * Migration table name.
     *
     * @var string
     */
    public $translationTableName = '{{%email_template_translation}}';


    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->insert($this->tableName, [
            'key' => 'preview',
        ]);

        $templateId = EmailTemplate::find()
            ->select('id')
            ->where(['key' => 'preview'])
            ->scalar();

        $this->insert($this->translationTableName, [
            'templateId'    => $templateId,
            'language'      => Yii::$app->language,
            'subject'       => 'Hello',
            'body'          => 'Hello, {username}!',
            'hint'          => 'This is hint',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->delete($this->tableName, '[[key]] = :key', [
            ':key' => 'preview',
        ]);
    }
}