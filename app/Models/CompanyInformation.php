<?php
// app/Models/CompanyInformation.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name', 'tagline', 'about', 'mission', 'vision',
        'address', 'phone', 'email', 'website', 'working_hours',
        'facebook', 'twitter', 'linkedin', 'instagram'
    ];
}