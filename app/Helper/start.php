<?php

if (!function_exists('superAdmin')) {
    function superAdmin()
    {
        return auth()->user();
    }
}
if (!function_exists('company')) {
    function company()
    {
        if(auth()->user()) {
            $companyId = auth()->user()->company_id;
            $company = \App\Company::find($companyId);
            return $company;
        }

        return false;
    }
}