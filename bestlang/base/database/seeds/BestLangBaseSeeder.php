<?php
class BestLangBaseSeeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(ModelHasPermissionsTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(HashConfigTableSeeder::class);
    }
}