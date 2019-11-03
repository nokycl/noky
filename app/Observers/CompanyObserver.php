<?php

namespace App\Observers;

use App\Company;
use App\Currency;
use App\GlobalCurrency;
use App\LeadSource;
use App\LeadStatus;
use App\LeaveType;
use App\LogTimeFor;
use App\MessageSetting;
use App\ModuleSetting;
use App\Package;
use App\PackageSetting;
use App\Role;
use App\StorageSetting;
use App\TaskboardColumn;
use App\ThemeSetting;
use App\TicketChannel;
use App\TicketGroup;
use App\TicketType;
use App\GlobalSetting;
use Carbon\Carbon;

class CompanyObserver
{

    public function created(Company $company) {

        // Package setting for get trial package active or not
        $packageSetting = PackageSetting::where('status', 'active')->first();
        $packages = Package::all();

        // get trial package data
        $trialPackage = $packages->filter(function ($value, $key) {
            return $value->default == 'trial';
        })->first();

        // get default package data
        $defaultPackage = $packages->filter(function ($value, $key) {
            return $value->default == 'yes';
        })->first();

        // get another  package data if trial and default package not found
        $otherPackage = $packages->filter(function ($value, $key) {
            return $value->default == 'no';
        })->first();

        // if trial package is active set package to company
        if($packageSetting && !is_null($trialPackage)){
            $company->package_id = $trialPackage->id;
            // set company license expire date
            $noOfDays = (!is_null($packageSetting->no_of_days) && $packageSetting->no_of_days != 0) ? $packageSetting->no_of_days : 30;
            $company->licence_expire_on = Carbon::now()->addDays($noOfDays)->format('Y-m-d');
        }

        // if trial package is not active set default package to company
        elseif(!is_null($defaultPackage))
            $company->package_id = $defaultPackage->id;
        else {
            $company->package_id = $otherPackage->id;
        }

        $company->save();

        $this->addTaskBoard($company);
        $this->addTicketChannel($company);
        $this->addTicketType($company);
        $this->addTicketGroup($company);
        $this->addLeaveType($company);
        $this->addEmailNotificationSettings($company);
        $this->addDefaultCurrencies($company);
        $this->addDefaultThemeSettings($company);
        $this->addPaymentGatewaySettings($company);
        $this->addInvoiceSettings($company);
        $this->addSlackSettings($company);
        $this->addAttendanceSettings($company);
        $this->addCustomFieldGroup($company);
        $this->addRoles($company);
        $this->addMessageSetting($company);
        $this->addStorageSetting($company);
        $this->addLogTImeForSetting($company);
        $this->addLeadSourceAndLeadStatus($company);
        $this->addProjectCategory($company);
    }

    public function updated(Company $company) {

        if ($company->isDirty('package_id')) {

            ModuleSetting::where('company_id', $company->id)->delete();
            ModuleSetting::whereNull('company_id')->delete();

            $moduleInPackage = (array)json_decode($company->package->module_in_package);
            $clientModules = ['projects', 'tickets', 'invoices', 'estimates', 'events', 'tasks', 'messages'];
            foreach ($moduleInPackage as $module) {

                if(in_array($module, $clientModules)){
                    $moduleSetting = new ModuleSetting();
                    $moduleSetting->company_id = $company->id;
                    $moduleSetting->module_name = $module;
                    $moduleSetting->status = 'active';
                    $moduleSetting->type = 'client';
                    $moduleSetting->save();
                }

                $moduleSetting = new ModuleSetting();
                $moduleSetting->company_id = $company->id;
                $moduleSetting->module_name = $module;
                $moduleSetting->status = 'active';
                $moduleSetting->type = 'employee';
                $moduleSetting->save();

                $moduleSetting = new ModuleSetting();
                $moduleSetting->company_id = $company->id;
                $moduleSetting->module_name = $module;
                $moduleSetting->status = 'active';
                $moduleSetting->type = 'admin';
                $moduleSetting->save();
            }
        }
    }

    public function addTaskBoard($company) {
        TaskboardColumn::whereNull('company_id')->delete();

        $uncatColumn = new TaskboardColumn();
        $uncatColumn->company_id = $company->id;
        $uncatColumn->column_name = 'Incomplete';
        $uncatColumn->slug = 'incomplete';
        $uncatColumn->label_color = '#d21010';
        $uncatColumn->label_color = '#d21010';
        $uncatColumn->priority = 1;
        $uncatColumn->save();

        $completeColumn = new TaskboardColumn();
        $completeColumn->company_id = $company->id;
        $completeColumn->column_name = 'Completed';
        $completeColumn->slug = 'completed';
        $completeColumn->label_color = '#679c0d';
        $completeColumn->priority = $uncatColumn->priority + 1;
        $completeColumn->save();
    }

    public function addTicketChannel($company) {
        $channel = new TicketChannel();
        $channel->company_id = $company->id;
        $channel->channel_name = 'Email';
        $channel->save();

        $channel = new TicketChannel();
        $channel->company_id = $company->id;
        $channel->channel_name = 'Phone';
        $channel->save();

        $channel = new TicketChannel();
        $channel->company_id = $company->id;
        $channel->channel_name = 'Twitter';
        $channel->save();

        $channel = new TicketChannel();
        $channel->company_id = $company->id;
        $channel->channel_name = 'Facebook';
        $channel->save();
    }

    public function addTicketType($company) {
        $type = new TicketType();
        $type->company_id = $company->id;
        $type->type = 'Question';
        $type->save();

        $type = new TicketType();
        $type->company_id = $company->id;
        $type->type = 'Problem';
        $type->save();

        $type = new TicketType();
        $type->company_id = $company->id;
        $type->type = 'Incident';
        $type->save();

        $type = new TicketType();
        $type->company_id = $company->id;
        $type->type = 'Feature Request';
        $type->save();
    }

    public function addTicketGroup($company) {
        $group = new TicketGroup();
        $group->company_id = $company->id;
        $group->group_name = 'Sales';
        $group->save();

        $group = new TicketGroup();
        $group->company_id = $company->id;
        $group->group_name = 'Code';
        $group->save();

        $group = new TicketGroup();
        $group->company_id = $company->id;
        $group->group_name = 'Management';
        $group->save();
    }

    public function addLeaveType($company) {
        $category = new LeaveType();
        $category->company_id = $company->id;
        $category->type_name = 'Casual';
        $category->color = 'success';
        $category->save();

        $category = new LeaveType();
        $category->company_id = $company->id;
        $category->type_name = 'Sick';
        $category->color = 'danger';
        $category->save();

        $category = new LeaveType();
        $category->company_id = $company->id;
        $category->type_name = 'Earned';
        $category->color = 'info';
        $category->save();
    }

    public function addEmailNotificationSettings($company) {
        // When new expense added by member
        \App\EmailNotificationSetting::create([
            'setting_name' => 'New Expense/Added by Admin',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When new expense added by member
        \App\EmailNotificationSetting::create([
            'setting_name' => 'New Expense/Added by Member',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When expense status changed
        \App\EmailNotificationSetting::create([
            'setting_name' => 'Expense Status Changed',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // New Support Ticket Request
        \App\EmailNotificationSetting::create([
            'setting_name' => 'New Support Ticket Request',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When new user registers or added by admin
        \App\EmailNotificationSetting::create([
            'setting_name' => 'User Registration/Added by Admin',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When employee is added to project
        \App\EmailNotificationSetting::create([
            'setting_name' => 'Employee Assign to Project',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When notice published by admin
        \App\EmailNotificationSetting::create([
            'setting_name' => 'New Notice Published',
            'send_email' => 'no',
            'company_id' => $company->id
        ]);

        // When user is assigned to a task
        \App\EmailNotificationSetting::create([
            'setting_name' => 'User Assign to Task',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When new leave application added
        \App\EmailNotificationSetting::create([
            'setting_name' => 'New Leave Application',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When task completed
        \App\EmailNotificationSetting::create([
            'setting_name' => 'Task Completed',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

        // When task completed
        \App\EmailNotificationSetting::create([
            'setting_name' => 'Invoice Create/Update Notification',
            'send_email' => 'yes',
            'company_id' => $company->id
        ]);

    }

    public function addDefaultCurrencies($company) {
        $globalCurrencies = GlobalCurrency::all();

        $globalSetting = GlobalSetting::first();
        foreach($globalCurrencies as $globalCurrency){
            $currency = new Currency();
            $currency->company_id = $company->id;
            $currency->currency_name = $globalCurrency->currency_name;
            $currency->currency_symbol = $globalCurrency->currency_symbol;
            $currency->currency_code = $globalCurrency->currency_code;
            $currency->save();

            if($globalSetting->currency_id == $globalCurrency->id) {
                $company->currency_id = $currency->id;
                $company->save();        
            }
        }
    }

    public function addDefaultThemeSettings($company) {
        $theme = new ThemeSetting();
        $theme->company_id = $company->id;
        $theme->panel = "admin";
        $theme->header_color = "#ed4040";
        $theme->sidebar_color = "#292929";
        $theme->sidebar_text_color = "#cbcbcb";
        $theme->save();

        // project admin panel
        $theme = new ThemeSetting();
        $theme->company_id = $company->id;
        $theme->panel = "project_admin";
        $theme->header_color = "#5475ed";
        $theme->sidebar_color = "#292929";
        $theme->sidebar_text_color = "#cbcbcb";
        $theme->save();

        // employee panel
        $theme = new ThemeSetting();
        $theme->company_id = $company->id;
        $theme->panel = "employee";
        $theme->header_color = "#f7c80c";
        $theme->sidebar_color = "#292929";
        $theme->sidebar_text_color = "#cbcbcb";
        $theme->save();

        // client panel
        $theme = new ThemeSetting();
        $theme->company_id = $company->id;
        $theme->panel = "client";
        $theme->header_color = "#00c292";
        $theme->sidebar_color = "#292929";
        $theme->sidebar_text_color = "#cbcbcb";
        $theme->save();
    }

    public function addPaymentGatewaySettings($company) {
        $credential = new \App\PaymentGatewayCredentials();
        $credential->company_id = $company->id;
        $credential->paypal_client_id = null;
        $credential->paypal_secret = null;
        $credential->save();
    }

    public function addInvoiceSettings($company) {
        $setting = new \App\InvoiceSetting();
        $setting->company_id = $company->id;
        $setting->invoice_prefix = 'INV';
        $setting->template = 'invoice-1';
        $setting->due_after = 15;
        $setting->invoice_terms = 'Thank you for your business. Please process this invoice within the due date.';
        $setting->save();
    }

    public function addSlackSettings($company) {
        $slack = new \App\SlackSetting();
        $slack->company_id = $company->id;
        $slack->slack_webhook = null;
        $slack->slack_logo = null;
        $slack->save();
    }

    public function addAttendanceSettings($company) {
        $setting = new \App\AttendanceSetting();
        $setting->company_id = $company->id;
        $setting->office_start_time = '09:00:00';
        $setting->office_end_time = '18:00:00';
        $setting->late_mark_duration = '20';
        $setting->save();
    }

    public function addCustomFieldGroup($company) {
        \DB::table('custom_field_groups')->insert([
            'name' => 'Client',
            'model' => 'App\ClientDetails',
            'company_id' => $company->id
        ]);

        \DB::table('custom_field_groups')->insert([
            'name' => 'Employee',
            'model' => 'App\EmployeeDetails',
            'company_id' => $company->id
        ]);

        \DB::table('custom_field_groups')->insert([
            'name' => 'Project',
            'model' => 'App\Project',
            'company_id' => $company->id
        ]);
    }

    public function addRoles($company) {
        $admin = new Role();
        $admin->company_id = $company->id;
        $admin->name = 'admin';
        $admin->display_name = 'App Administrator'; // optional
        $admin->description = 'Admin is allowed to manage everything of the app.'; // optional
        $admin->save();

        $employee = new Role();
        $employee->company_id = $company->id;
        $employee->name = 'employee';
        $employee->display_name = 'Employee'; // optional
        $employee->description = 'Employee can see tasks and projects assigned to him.'; // optional
        $employee->save();

        $client = new Role();
        $client->company_id = $company->id;
        $client->name = 'client';
        $client->display_name = 'Client'; // optional
        $client->description = 'Client can see own tasks and projects.'; // optional
        $client->save();
    }

    public function addMessageSetting($company) {
        $setting = new MessageSetting();
        $setting->company_id = $company->id;
        $setting->allow_client_admin = 'no';
        $setting->allow_client_employee = 'no';
        $setting->save();
    }

    public function addStorageSetting($company) {
        $storage = new StorageSetting();
        $storage->company_id = $company->id;
        $storage->filesystem = 'local';
        $storage->status = 'enabled';
        $storage->save();
    }

    public function addLogTImeForSetting($company) {
        $storage = new LogTimeFor();
        $storage->company_id = $company->id;
        $storage->log_time_for = 'project';
        $storage->save();
    }

    public function addLeadSourceAndLeadStatus($company) {
        $sources = [
            ['type' => 'email', 'company_id' => $company->id],
            ['type' => 'google', 'company_id' => $company->id],
            ['type' => 'facebook', 'company_id' => $company->id],
            ['type' => 'friend', 'company_id' => $company->id],
            ['type' => 'direct visit', 'company_id' => $company->id],
            ['type' => 'tv ad', 'company_id' => $company->id]
        ];

        LeadSource::insert($sources);

        $status = [
            ['type' => 'pending', 'company_id' => $company->id],
            ['type' => 'inprocess', 'company_id' => $company->id],
            ['type' => 'converted', 'company_id' => $company->id]
        ];

        LeadStatus::insert($status);
    }

    public function addProjectCategory($company) {
        $category = new \App\ProjectCategory();
        $category->category_name = 'Laravel';
        $category->company_id = $company->id;
        $category->save();

        $category = new \App\ProjectCategory();
        $category->category_name = 'Java';
        $category->company_id = $company->id;
        $category->save();
    }
}
