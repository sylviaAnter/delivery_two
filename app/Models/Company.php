<?php
//The model is responsible for interacting with
// the companies table in the database

namespace App\Models;

use App\Admin\Controllers\CompanyController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//This line defines the Company class, which extends the Model class,

class Company extends Model
{
    use HasFactory;

    //The boot method is a special method in Eloquent
    //models that allows you to hook into the model's
    //lifecycle events.

    protected static function boot()
    {

        //parent::boot();: This calls the parent class's
        //  boot method to ensure that any booting done
        //by the parent class is not overridden and lost.

        parent::boot();

        // This line adds a model event listener for
        //the created event.
        //When a new Company model is created and
        //saved to the database, this event listener
        //will be triggered.
        static::updated(function ($company) {
            $owner = User::find($company->owner_id);
            if ($owner == null) {
                throw new \Exception("Owner not found");
            }
            //this code updates the company_id
            // attribute of the User model to match
            // the id of the updated Company model
            //($company)
            $owner->company_id = $company->id;
            $owner->save();
        });


        static::created(function ($company) {
            $owner = User::find($company->owner_id);
            //dd($company->owner_id);
            if ($owner == null) {
                throw new \Exception("Owner not found");
            }
            $owner->company_id = $company->id;
            $owner->save();
        });
    }
}
