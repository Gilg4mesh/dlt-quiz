<?php

use Illuminate\Database\Seeder;
use Encore\Admin\Auth\Database\AdminTablesSeeder;
use Carbon\Carbon as Carbon;


class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        
        $this->call(AdminTablesSeeder::class);

        DB::table('admin_menu')->insert([
            [
            'parent_id' => 0,
            'order' => 0,
            'title' => 'Students',
            'icon' => 'fa-users',
            'uri' => 'users'
            ],
            [
            'parent_id' => 0,
            'order' => 0,
            'title' => 'Tags',
            'icon' => 'fa-tags',
            'uri' => 'tags'
            ],
            [
            'parent_id' => 0,
            'order' => 0,
            'title' => 'Questions',
            'icon' => 'fa-question',
            'uri' => 'questions'
            ],
            [
            'parent_id' => 0,
            'order' => 0,
            'title' => 'Tests',
            'icon' => 'fa-pencil',
            'uri' => 'tests'
            ],
            [
            'parent_id' => 0,
            'order' => 0,
            'title' => 'Textbooks',
            'icon' => 'fa-book',
            'uri' => 'textbooks'
            ]
        ]);

        DB::table('qtypes')->insert([
            [ 'name' => '單選題' ],
            [ 'name' => '多選題' ],
            [ 'name' => '是非題' ],
            [ 'name' => '簡答題' ],
            [ 'name' => '申論題' ]
        ]);
        
        
        DB::table('admin_permissions')->insert([
            [
            'name' => 'Users',
            'slug' => 'users',
            'http_path' => '/users*',
            ],
            [
            'name' => 'Tags',
            'slug' => 'tags',
            'http_path' => '/tags*',
            ],
            [
            'name' => 'Questions',
            'slug' => 'questions',
            'http_path' => '/questions*',
            ],
            [
            'name' => 'Tag_question',
            'slug' => 'tag_question',
            'http_path' => '/tag_question*',
            ],
            [
            'name' => 'Textbooks',
            'slug' => 'textbooks',
            'http_path' => '/textbooks*',
            ],
            [
            'name' => 'Tests',
            'slug' => 'tests',
            'http_path' => '/tests*',
            ],
        ]);
        */
    }
}
