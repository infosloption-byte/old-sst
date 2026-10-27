<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Route;
use DB;

class PermissionHandler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:permission';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('getting all permissions');
        $routeNames = $this->getAllRouteNames();
        $dbPermissions = $this->getAddedPermissions($routeNames);
        $this->info(json_encode($routeNames));

        $this->info('checking new permissions');
        if(count($dbPermissions) > 0){
            $availablePermissions = array_diff($routeNames, $dbPermissions);
        }else{
            $availablePermissions = $routeNames;
        }

        $this->info('found '.count($availablePermissions).' new permissions to insert');

        if(count($availablePermissions) > 0){
            $this->info('begining to insert');
            $this->info('---------------------------------');

            foreach ($availablePermissions as $key => $value) {
                DB::table('permissions')->insert([
                    'name' => $value,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s'),
                    'created_by' => 1,
                    'status' => 1
                ]);

                $this->info($value. ' permission added');
            }
            $this->info('---------------------------------');
            $this->error('end of insert');
        }
    }

    public function getAllRouteNames()
    {
        $routeCollection = Route::getRoutes();
        $routeNames = [];
        foreach ($routeCollection as $value) {
            if($value->getName() != ""){
                array_push($routeNames, $value->getName());
            }
        }

        return array_unique($routeNames);

    }

    public function getAddedPermissions($routeNames){
        $dbArray = DB::table('permissions')->whereIn('name', $routeNames)->pluck('name');
        return $dbArray;
    }
}
