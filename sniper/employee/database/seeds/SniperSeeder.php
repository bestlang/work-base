<?php
class SniperSeeder
{
    public function run()
    {
        $this->call(SniperEmployeePositionsTableSeeder::class);
        $this->call(SniperEmployeeJobsTableSeeder::class);
        $this->call(SniperEmployeeEmployeeTableSeeder::class);
        $this->call(SniperEmployeeEducationTableSeeder::class);
        $this->call(SniperEmployeeDepartmentsTableSeeder::class);
    }
}