<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;
 
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;



class Enquiries extends Authenticatable{

    use HasApiTokens, HasFactory, Notifiable;

	

	protected $table = 'contacts';



    /**



     * The attributes that are mass assignable.



     *



     * @var array<int, string>



     */



    protected $fillable = [

		'name',

		'email',

		'contact',

		'subject',

		'message',

		'read_status',

		'status'

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