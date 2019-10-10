<?php

namespace App\Console\Commands;

use App\Admin;
use App\Navbar;
use App\NavGroup;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class DefaultNavs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mcchst:createadmin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create default navigation for admin';

    private function createNavbar($name, $navGroupId, Admin $admin){
        $navbar = Navbar::create([
            'name' => $name,
            'navgroup_id' => $navGroupId
        ]);
        $admin->navbar()->syncWithoutDetaching($navbar->id);
    }
    public function handle()
    {
        try {
            $admin = Admin::create([
                'username' => 'Admin',
                'password' => Hash::make('admin') 
            ]);
            $groups = [
                ['name' => 'Department'],
                ['name' => 'Exams'],
                ['name' => 'Staff'],
                ['name' => 'Students']
            ];
            foreach ($groups as $group) {
                NavGroup::create($group);
            }
            
            $navGroup = NavGroup::all();
            foreach ($navGroup as $key => $value) {
                switch ($value->name) {
                    case 'Department':
                        $this::createNavbar('Departments', $value->id, $admin);
                        $this::createNavbar('Courses', $value->id, $admin);
                        break;
                    case 'Exams':
                        $this::createNavbar('Section Questions', $value->id, $admin);
                        $this::createNavbar('Exam Questions', $value->id, $admin);
                        $this::createNavbar('Create Exam', $value->id, $admin);
                        break;
                    case 'Staff':
                        $this::createNavbar('Create Staff', $value->id, $admin);
                        break;
                    case 'Students':
                        $this::createNavbar('Upload Students', $value->id, $admin);
                        break;
                    
                    default:
                        break;
                }
            }
            $this->info($admin->name .' Created successfully. Username: Admin, Password: admin.' );
        } catch (\Throwable $th) {
            $this->error($th);
        }
    }
}
