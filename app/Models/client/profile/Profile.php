<?php

namespace App\Models\client\profile;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model{

    protected $table = 'client_profiles';
    protected $fillable = ['id', 'client_id', 'regionId', 'districtId', 'street', 'building_number', 'affilated_company'];

}
