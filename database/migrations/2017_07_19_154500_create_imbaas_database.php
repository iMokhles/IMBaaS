<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImbaasDatabase extends Migration {

        /**
         * Run the migrations.
         *
         * @return void
         */
         public function up()
         {
            
	    /**
	     * Table: analytics
	     */
	    Schema::create('analytics', function($table) {
                $table->increments('id')->unsigned();
                $table->string('event_name', 255);
                $table->text('event_info');
                $table->string('device_id', 255);
                $table->string('device_type', 255);
                $table->string('device_system', 255);
                $table->string('device_os_name', 255);
                $table->string('device_os_version', 255);
                $table->string('device_carrier', 255);
                $table->string('device_resolution', 255);
                $table->string('device_locale', 255);
                $table->string('device_app_version', 255);
                $table->string('device_app_build', 255);
                $table->boolean('device_app_has_watch');
                $table->boolean('device_app_watch_installed');
                $table->integer('device_connection_type');
                $table->double('device_free_ram', 8,2);
                $table->double('device_total_ram', 8,2);
                $table->double('device_free_disk', 8,2);
                $table->double('device_total_disk', 8,2);
                $table->integer('device_battery_level');
                $table->integer('device_orientation');
                $table->boolean('device_is_jailbroken');
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: classes
	     */
	    Schema::create('classes', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 255)->nullable();
                $table->string('table_name', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: files
	     */
	    Schema::create('files', function($table) {
                $table->increments('id')->unsigned();
                $table->string('filename', 255)->nullable();
                $table->string('content_type', 255)->nullable();
                $table->string('size', 255)->nullable();
                $table->string('md5', 255)->nullable();
                $table->string('ext', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: installations
	     */
	    Schema::create('installations', function($table) {
                $table->increments('id')->unsigned();
                $table->string('gcm_sender_id', 255)->nullable();
                $table->string('device_token', 255)->nullable();
                $table->string('locale_identifier', 255)->nullable();
                $table->string('badge', 255)->nullable();
                $table->string('imbaas_version', 255)->nullable();
                $table->string('app_identifier', 255)->nullable();
                $table->string('app_name', 255)->nullable();
                $table->string('device_type', 255)->nullable();
                $table->string('installation_id', 255)->nullable();
                $table->string('app_version', 255)->nullable();
                $table->string('push_type', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: languages
	     */
	    Schema::create('languages', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 100);
                $table->string('app_name', 100);
                $table->string('flag', 100)->nullable();
                $table->string('abbr', 3);
                $table->string('script', 20)->nullable();
                $table->string('native', 20)->nullable();
                $table->boolean('active')->default("1")->unsigned();
                $table->boolean('default')->unsigned();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });
             /**
              * Table: roles
              */
             Schema::create('roles', function($table) {
                 $table->increments('id')->unsigned();
                 $table->string('name', 255);
                 $table->string('guard_name', 255);
                 $table->timestamp('created_at')->nullable();
                 $table->timestamp('updated_at')->nullable();
             });

             /**
              * Table: permissions
              */
             Schema::create('permissions', function($table) {
                 $table->increments('id')->unsigned();
                 $table->string('name', 255);
                 $table->string('guard_name', 255);
                 $table->timestamp('created_at')->nullable();
                 $table->timestamp('updated_at')->nullable();
             });

	    /**
	     * Table: model_has_permissions
	     */
	    Schema::create('model_has_permissions', function($table) {
                $table->integer('permission_id')->unsigned();
                $table->integer('model_id')->unsigned();
                $table->string('model_type', 255);
                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');
                $table->primary(['permission_id', 'model_id']);
//                $table->index('model_has_permissions_model_id_model_type_index');
//                $table->index('model_has_permissions_model_id_model_type_index');
            });


	    /**
	     * Table: model_has_roles
	     */
	    Schema::create('model_has_roles', function($table) {
                $table->integer('role_id')->index('role_id')->unsigned();
                $table->integer('model_id')->index('model_id')->unsigned();
                $table->string('model_type', 255);

                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade');
                $table->primary(['role_id', 'model_id']);

//                $table->index('model_has_roles_model_id_model_type_index');
//                $table->index('model_has_roles_model_id_model_type_index');
            });


	    /**
	     * Table: password_resets
	     */
	    Schema::create('password_resets', function($table) {
                $table->increments('id')->unsigned();
                $table->string('email', 255)->index();
                $table->string('token', 255);
                $table->timestamp('created_at')->nullable();
            });





	    /**
	     * Table: pushs
	     */
	    Schema::create('pushs', function($table) {
                $table->increments('id')->unsigned();
                $table->text('device_tokens')->nullable();
                $table->string('badge', 255)->nullable();
                $table->text('data')->nullable();
                $table->string('push_uuid', 255)->nullable();
                $table->string('push_type', 255)->nullable();
                $table->text('pushs_clicked')->nullable();
                $table->text('pushs_reached')->nullable();
                $table->text('pushs_unreached')->nullable();
                $table->text('pushs_invalid')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: role_has_permissions
	     */
	    Schema::create('role_has_permissions', function($table) {
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();
                $table->foreign('permission_id')
                    ->references('id')
                    ->on('permissions')
                    ->onDelete('cascade');
                $table->foreign('role_id')
                    ->references('id')
                    ->on('roles')
                    ->onDelete('cascade');
                $table->primary(['permission_id', 'role_id']);
            });



	    /**
	     * Table: sessions
	     */
	    Schema::create('sessions', function($table) {
                $table->increments('id')->unsigned();
                $table->string('session_token', 255)->nullable();
                $table->integer('user_id')->index('user_id')->nullable()->unsigned();
                $table->boolean('active')->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: sidemenu_classes
	     */
	    Schema::create('sidemenu_classes', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 255)->nullable();
                $table->string('path', 255)->nullable();
                $table->string('icon', 255)->nullable();
                $table->integer('class_id')->index('class_id')->nullable();
                $table->integer('parent_id')->nullable()->unsigned();
                $table->integer('lft')->nullable()->unsigned();
                $table->integer('rgt')->nullable()->unsigned();
                $table->integer('depth')->nullable()->unsigned();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: user_activations
	     */
	    Schema::create('user_activations', function($table) {
                $table->increments('id')->unsigned();
                $table->integer('user_id')->unsigned();
                $table->string('token', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


	    /**
	     * Table: users
	     */
	    Schema::create('users', function($table) {
                $table->increments('id')->unsigned();
                $table->string('name', 255)->unique();
                $table->string('username', 255)->unique()->nullable();
                $table->string('email', 255)->unique();
                $table->boolean('emailVerified');
                $table->string('password', 255);
                $table->string('remember_token', 100)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
                $table->timestamp('deleted_at')->nullable();
            });


	    /**
	     * Table: users_roles
	     */
	    Schema::create('users_roles', function($table) {
                $table->increments('id')->unsigned();
                $table->integer('acl_id')->nullable();
                $table->string('name', 255)->nullable();
                $table->string('user_id', 255)->nullable();
                $table->timestamp('created_at')->nullable();
                $table->timestamp('updated_at')->nullable();
            });


         }

        /**
         * Reverse the migrations.
         *
         * @return void
         */
         public function down()
         {
            
	            Schema::drop('analytics');
	            Schema::drop('classes');
	            Schema::drop('files');
	            Schema::drop('installations');
	            Schema::drop('languages');
	            Schema::drop('model_has_permissions');
	            Schema::drop('model_has_roles');
	            Schema::drop('password_resets');
	            Schema::drop('pushs');
	            Schema::drop('role_has_permissions');
                Schema::drop('permissions');
                Schema::drop('roles');
	            Schema::drop('sessions');
	            Schema::drop('sidemenu_classes');
	            Schema::drop('user_activations');
	            Schema::drop('users');
	            Schema::drop('users_roles');
         }

}