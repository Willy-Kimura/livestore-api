<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable =
    [
        'type', 'secondary_id', 'fingerprint_id', 'first_name', 'middle_name', 'last_name',
        'username', 'email', 'password', 'gender', 'date_of_birth', 'document_type', 'default_phone',
        'default_phone_sha256', 'default_address', 'country', 'status', 'avatar', 'notes'
    ];
}
