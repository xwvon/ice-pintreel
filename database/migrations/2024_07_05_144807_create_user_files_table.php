<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('name', 128)->index()->comment('名称, 用于展示');
            $table->string('disk')->comment('文件存储位置,public, local, s3, oss');
            $table->string('path');
            $table->string('type', 32)->comment('文件类型, image, video, audio, text, document, other');
            $table->string('ext', 32)->nullable()->comment('文件扩展名');
            $table->bigInteger('size')->default(0);
            $table->string('mime', 64)->nullable();
            $table->string('labels', 128)->nullable()->comment('标签, 用于搜索');
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
        Schema::dropIfExists('user_files');
    }
}
