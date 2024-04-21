<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSmsVerificationFieldsToClientsTable extends Migration
{
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('sms_verification_code')->nullable()->after('password');
            $table->dateTime('sms_verification_code_sent_at')->nullable()->after('sms_verification_code');
        });
    }

    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['sms_verification_code', 'sms_verification_code_sent_at']);
        });
    }
}
