<?php
namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class InnerPages extends Authenticatable{

    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'seo_title',
		'seo_description',
        'seo_keywords',
		'robot_tags',
		'banner',
		'banner_status',
		'status',
		'heading',
		'sub_heading',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */

	public function GetRecordById($id){
		return $this::where('id', $id)->first();
	}
	public function UpdateRecord($Details){
		$Record = $this::where('id', $Details['id'])->update($Details);
		return true;
	}
	public function CreateRecord($Details){
		$Record = $this::create($Details);
		return $Record;
	}

    public function ExistingRecord($email){
		return $this::where('email',$email)->where('status','!=', 3)->exists();
	}
	public function ExistingRecordUpdate($email, $id){
		return $this::where('email',$email)->where('id','!=', $id)->where('status','!=', 3)->exists();
	}
	
}