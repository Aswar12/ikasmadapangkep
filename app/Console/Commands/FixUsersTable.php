<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FixUsersTable extends Command
{
    protected $signature = 'fix:users-table';
    protected $description = 'Fix users table structure and add missing columns';

    public function handle()
    {
        $this->info('Fixing users table structure...');
        
        // Check if users table exists
        if (!Schema::hasTable('users')) {
            $this->error('Users table does not exist!');
            return 1;
        }
        
        // Get current columns
        $currentColumns = Schema::getColumnListing('users');
        $this->info('Current columns: ' . implode(', ', $currentColumns));
        
        // Add missing columns
        $columnsToAdd = [
            'username' => ['type' => 'string', 'after' => 'name', 'nullable' => true],
            'phone' => ['type' => 'string', 'after' => 'email', 'nullable' => true, 'length' => 20],
            'is_active' => ['type' => 'boolean', 'after' => 'password', 'default' => true],
            'status' => ['type' => 'enum', 'after' => 'is_active', 'default' => 'approved', 'values' => ['pending', 'approved', 'rejected']],
            'role' => ['type' => 'string', 'after' => 'status', 'default' => 'user']
        ];
        
        foreach ($columnsToAdd as $column => $config) {
            if (!in_array($column, $currentColumns)) {
                $this->info("Adding column: $column");
                
                try {
                    Schema::table('users', function ($table) use ($column, $config) {
                        switch ($config['type']) {
                            case 'string':
                                $col = $table->string($column, $config['length'] ?? 255);
                                break;
                            case 'boolean':
                                $col = $table->boolean($column);
                                break;
                            case 'enum':
                                $col = $table->enum($column, $config['values']);
                                break;
                        }
                        
                        if (isset($config['after'])) {
                            $col->after($config['after']);
                        }
                        
                        if (isset($config['default'])) {
                            $col->default($config['default']);
                        }
                        
                        if (isset($config['nullable']) && $config['nullable']) {
                            $col->nullable();
                        }
                    });
                    
                    $this->info("✓ Column $column added successfully");
                } catch (\Exception $e) {
                    $this->error("✗ Failed to add column $column: " . $e->getMessage());
                }
            } else {
                $this->info("✓ Column $column already exists");
            }
        }
        
        // Update existing records
        $this->info('Updating existing records...');
        
        try {
            // Set default values for existing records
            DB::table('users')->whereNull('is_active')->update(['is_active' => true]);
            DB::table('users')->whereNull('status')->update(['status' => 'approved']);
            DB::table('users')->whereNull('role')->update(['role' => 'user']);
            
            // Generate usernames for users without one
            $usersWithoutUsername = DB::table('users')->whereNull('username')->get();
            
            foreach ($usersWithoutUsername as $user) {
                $username = $this->generateUsername($user->email);
                DB::table('users')->where('id', $user->id)->update(['username' => $username]);
                $this->info("Generated username for user {$user->id}: $username");
            }
            
            $this->info('✓ All existing records updated');
        } catch (\Exception $e) {
            $this->error('✗ Failed to update records: ' . $e->getMessage());
        }
        
        $this->info('Users table fix completed!');
        return 0;
    }
    
    private function generateUsername($email)
    {
        $username = explode('@', $email)[0];
        $username = preg_replace('/[^a-zA-Z0-9]/', '', $username);
        
        $counter = 1;
        $finalUsername = $username;
        
        while (DB::table('users')->where('username', $finalUsername)->exists()) {
            $finalUsername = $username . $counter;
            $counter++;
        }
        
        return $finalUsername;
    }
}
