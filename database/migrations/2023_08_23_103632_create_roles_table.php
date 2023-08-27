<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->autoIncrement();
            $table->string('name');
            $table->string('permissions')->nullable();
            $table->timestamps();
        });

        // Insert default roles
        DB::table('roles')->insert([
                [
                    'id' => 1,
                    'name' => 'Administrator',
                    'permissions' =>
                        json_encode( [
                            'posts' => [
                                'viewAny' => true,
                                'view' => true,
                                'create' => true,
                                'update' => true,
                                'delete' => true,
                            ],
                            'users' => [
                                'viewAny' => true,
                                'view' => true,
                                'create' => true,
                                'update' => true,
                                'delete' => true,
                            ]
                        ])
                ],
                [
                    'id' => 2,
                    'name' => 'Editor',
                    'permissions' =>
                       json_encode( [
                            'posts' => [
                                'viewAny' => true,
                                'view' => true,
                                'create' => true,
                                'update' => true,
                                'delete' => true,
                            ]
                        ]
                       )
                ]
            ]
        );

    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
};
