<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWechatWorkPushConfigsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        $table = config('admin.extensions.wechat-work-push.config_table', 'wechat_work_push_configs');
        Schema::connection($connection)->create($table, function (Blueprint $table) {
            $table->increments('id');
            $table->text('corp_id')->nullable()->comment('企业ID');
            $table->text('agent_id')->nullable()->comment('应用ID/agent_id');
            $table->text('secret')->nullable()->comment('应用Secret');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $connection = config('admin.database.connection') ?: config('database.default');
        $table = config('admin.extensions.wechat-work-push.config_table', 'wechat_work_push_configs');
        Schema::connection($connection)->dropIfExists($table);
    }
}
