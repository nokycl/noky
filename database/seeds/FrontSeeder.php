<?php

use Illuminate\Database\Seeder;

class FrontSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $frontDetails = new \App\FrontDetail();
        $frontDetails->header_title = 'Project Management System';
        // $frontDetails->image = 'dashboard.jpg';
        $frontDetails->header_description = 'The most powerful and simple way to collaborate with your team';
        $frontDetails->get_started_show = 'yes';
        $frontDetails->sign_in_show = 'yes';
        $frontDetails->feature_title = 'Team communications for the 21st century.';
        $frontDetails->price_title = 'Affordable Pricing';
        $frontDetails->price_description = 'Worksuite for Teams is a single workspace for your small- to medium-sized company or team.';
        $frontDetails->address = 'Company address';
        $frontDetails->phone = '+91 1234567890';
        $frontDetails->email = 'company@example.com';
        $frontDetails->save();

        $feature = new \App\Feature();
        $feature->title = 'Business Needs.';
        // $feature->image = 'drag.png';
        $feature->description = '<p>Manage your projects and your talent in a single system, resulting in empowered teams, satisfied clients, and increased profitability.</p>';
        $feature->type = 'image';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Reports';
        // $feature->image = 'everywhere.png';
        $feature->description = '<p>Reports section to analyse what\'s working and what\'s not for your business</p>';
        $feature->type = 'image';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Tickets';
        // $feature->image = 'tools.png';
        $feature->description = '<p>Whether someone\'s internet is not working, someone is facing issue with housekeeping or need something regarding their work they can raise ticket for all their problems. Admin can assign the tickets to respective department agents.</p>';
        $feature->type = 'image';
        $feature->save();


        $feature = new \App\Feature();
        $feature->title = 'Responsive';
        $feature->description = 'Your website works on any device: desktop, tablet or mobile.';
        $feature->icon = 'fas fa-desktop';
        $feature->type = 'icon';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Customizable';
        $feature->description = 'You can easily read, edit, and write your own code, or change everything.';
        $feature->icon = 'fas fa-wrench';
        $feature->type = 'icon';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'UI Elements';
        $feature->description = 'There is a bunch of useful and necessary elements for developing your website.';
        $feature->icon = 'fas fa-cubes';
        $feature->type = 'icon';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Clean Code';
        $feature->description = 'You can find our code well organized, commented and readable.';
        $feature->icon = 'fas fa-code';
        $feature->type = 'icon';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Documented';
        $feature->description = 'As you can see in the source code, we provided a comprehensive documentation.';
        $feature->icon = 'far fa-file-alt';
        $feature->type = 'icon';
        $feature->save();

        $feature = new \App\Feature();
        $feature->title = 'Free Updates';
        $feature->description = "When you purchase this template, you'll freely receive future updates.";
        $feature->icon = 'fas fa-download';
        $feature->type = 'icon';
        $feature->save();

//
    }
}
