<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UserTableSeeder::class);
        $this->call(GameTableSeeder::class);
        $this->call(VersionTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(CommentTableSeeder::class);
        $this->call(DiscussionTableSeeder::class);

        Model::reguard();
    }
}
