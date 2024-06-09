<?php

namespace App\Models\client\profile;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ClientCard extends Model
{
    protected $table = 'clientCard';
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }
    protected $fillable = [
        'guid',
        'name',
        'companyGroup',
        'bin',
        'address',
        'sourceBase',
        'code',
        'isClient',
        'isProvider',
        'isCompany',
        'partnerGuid',
        'isDiller',
        'kato',
        'buisnessRegion',
        'manager'
    ];
}
