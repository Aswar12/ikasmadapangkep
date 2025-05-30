<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class AddProfilePhotoColumn extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'profile:add-photo-column';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add profile_photo column to profiles table if it does not exist';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking profiles table...');
        
        if (!Schema::hasTable('profiles')) {
            $this->error('Profiles table does not exist!');
            $this->info('Please run: php artisan migrate');
            return 1;
        }
        
        $this->info('Profiles table exists.');
        
        if (Schema::hasColumn('profiles', 'profile_photo')) {
            $this->info('✓ Column profile_photo already exists in profiles table.');
            return 0;
        }
        
        $this->info('Adding profile_photo column...');
        
        try {
            Schema::table('profiles', function (Blueprint $table) {
                $table->string('profile_photo')->nullable()->after('user_id');
            });
            
            $this->info('✓ Successfully added profile_photo column to profiles table!');
            
            // Clear cache
            $this->call('cache:clear');
            $this->call('config:clear');
            
            return 0;
            
        } catch (\Exception $e) {
            $this->error('Failed to add column: ' . $e->getMessage());
            $this->info('');
            $this->info('You can manually add the column using phpMyAdmin or MySQL:');
            $this->info('ALTER TABLE profiles ADD COLUMN profile_photo VARCHAR(255) NULL AFTER user_id;');
            return 1;
        }
    }
}
