<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Notifications\Notifiable;

use Laravel\Sanctum\HasApiTokens;



class User extends Authenticatable{

	

    use HasApiTokens, HasFactory, Notifiable;



    /**

     * The attributes that are mass assignable.

     *

     * @var array<int, string>

     */

    protected $fillable = [

        'type',

        'otp',

        'emp_id',

        'first_name',

        'middle_name',

		'last_name',

		'name',

		'email',

		'password',

		'temp_password',

        'salary',

		'father_name',

		'profile',

		'aadhaar',

		'correspondence_address',

		'permanent_address',

		'dob',

		'marital_status',

        'address',

        'city',

		'state',

		'country',

        'zipcode',

        'latitude',

        'longitude',

        'mobile',

		'telephone',

        'pan_card',

        'blood_group',

        'account_no',

        'ifsc',

        'bank_name',

        'account_holder_name',

        'account_image',        

		'emergency_name',

        'emergency_relation',

		'emergency_contact',

		'education_degree',

		'education_university',

		'education_from',

		'education_to',

		'billing_details',

		'education_percentage',

		'education_specialization',

		'employee_organisation',

        'employee_designation',

        'employee_from_service_period',

		'employee_to_service_period',

		'employee_ctc',

        'family_name',

        'family_relation',

        'family_occupation',

        'family_dob',

		'professional_name',

        'professional_organisation',

		'professional_designation',

		'professional_contact',

		'remember_token',

		'email_verified_at',

		'status'

    ];



    /**

     * The attributes that should be hidden for serialization.

     *

     * @var array<int, string>

     */

    protected $hidden = [

        'password',

        'remember_token',

		'otp'

    ];



    /**

     * The attributes that should be cast.

     *

     * @var array<string, string>

     */

    protected $casts = [

        'email_verified_at' => 'datetime',

    ];



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



    public function getUsersNames($ids){

        $user_name = 'N/A';

		$userIDs = explode(',',$ids);

        $users = $this::whereIn('id',$userIDs)->get();

        if(count($users) > 0){

            $usersArr = [];

            foreach($users as $user){

                $usersArr[] = $user->name;

            }

            if(count($usersArr) > 0){

                $user_name = implode(', ',$usersArr);

            }

            if(count($usersArr) > 1){

                $user_name = substr_replace($user_name, ' and', strrpos($user_name, ','), 1);

            }

        }

        return $user_name;

    }



}