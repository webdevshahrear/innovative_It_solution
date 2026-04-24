<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->string('father_name')->nullable()->after('full_name');
            $table->string('mother_name')->nullable()->after('father_name');
            $table->date('dob')->nullable()->after('mother_name');
            $table->string('gender')->nullable()->after('dob');
            $table->string('blood_group')->nullable()->after('gender');
            $table->string('nid_birth_number')->nullable()->after('blood_group');
            $table->string('district')->nullable()->after('nid_birth_number');
            $table->text('permanent_address')->nullable()->after('address');
            $table->string('institute_name')->nullable()->after('education');
            $table->string('passing_year')->nullable()->after('institute_name');
            $table->string('linkedin_url')->nullable()->after('portfolio_url');
            $table->string('emergency_contact_name')->nullable()->after('linkedin_url');
            $table->string('emergency_contact_relationship')->nullable()->after('emergency_contact_name');
            $table->string('emergency_contact_phone')->nullable()->after('emergency_contact_relationship');
        });
    }

    public function down(): void
    {
        Schema::table('internship_applications', function (Blueprint $table) {
            $table->dropColumn([
                'father_name', 'mother_name', 'dob', 'gender', 'blood_group',
                'nid_birth_number', 'district', 'permanent_address',
                'institute_name', 'passing_year', 'linkedin_url',
                'emergency_contact_name', 'emergency_contact_relationship', 'emergency_contact_phone'
            ]);
        });
    }
};
