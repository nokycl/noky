<?php

use Illuminate\Database\Seeder;

class ProjectCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\ProjectCategory();
        $category->category_name = 'Laravel';
        $category->save();
    }
}
