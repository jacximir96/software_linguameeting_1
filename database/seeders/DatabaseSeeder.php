<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(ImportBasicTableSeeder::class);
        $this->call(ImportEnrollmentTypesSeeder::class);
        $this->call(ImportRolesSeeder::class);


        $this->call(ImportUsersSeeder::class);
        $this->call(ImportUniversitySeeder::class);
        $this->call(ImportGuideSeeder::class);
        $this->call(ImportCourseSeeder::class);
        $this->call(ImportUniversityInstructorSeeder::class);
        $this->call(ImportInfoUsers::class);
        $this->call(ImportEnrollmentSeeder::class);
        $this->call(FixConversationGuideFilePathSeeder::class);
        $this->call(ImportStudentReviewSeeder::class);
        $this->call(ImportSessionSeeder::class);
        $this->call(ImportZoomSeeder::class);
        $this->call(ImportBookstoreSeeder::class);
        $this->call(ImportExperienceLevelsSeeder::class);
        $this->call(ImportExperiencesSeeder::class);
        //$this->call(ImportCoachScheduleSeeder::class);
        $this->call(ImportCoachFeedbackSeeder::class);
        $this->call(ImportNotificationSeeder::class);
        $this->call(ImportCoachHelpSeeder::class);
        $this->call(ImportReviewsSeeder::class);
        $this->call(ImportSalaryCoordinatorSeeder::class);
        $this->call(ImportStudentHelpSeeder::class);
        $this->call(ImportIssueTypeSeeder::class);
        $this->call(ImportAccommodationTypeSeeder::class);
        $this->call(ImportUsersKeySeeder::class);
    }
}
