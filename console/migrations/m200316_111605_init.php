<?php

use common\models\User;
use icy2003\php\iextensions\yii2\db\Migration;

class m200316_111605_init extends Migration
{

    public function up()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->unique(),
            'portrait' => $this->text(),
            'status' => $this->tinyInteger(1)->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
        $this->batchInsert('{{%user}}', ['username', 'password_hash', 'status', 'created_at'], [
            ['admin', Yii::$app->security->generatePasswordHash(123456), User::STATUS_ACTIVE, time()],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');

        return false;
    }
}
