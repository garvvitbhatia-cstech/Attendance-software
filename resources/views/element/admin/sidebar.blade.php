@php
$action =  Route::getCurrentRoute()->getName();
@endphp
<div id="sidebar" class="active">
   <div class="sidebar-wrapper active">
      <div class="sidebar-header">
         <div class="d-flex justify-content-between">
            <div class="logo"> <a href="{{ url('/admin/dashboard'); }}">Logo Here</a> </div>
            <div class="toggler"> <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a> </div>
         </div>
      </div>
      <div class="sidebar-menu">
         <ul class="menu">
            <li class="sidebar-item {{$action =='admin.dashboard' ?'active':''}}"> 
               <a href="{{ url('/admin/dashboard'); }}" class='sidebar-link'> <i class="bi bi-grid-fill"></i> <span>{{Session::get('admin_type')}} Dashboard</span> </a> 
            </li>
            @php
            $managerActive =
            $profile =
            $changePassword =
            $accounts =
            $settings =
            false;         
            if($action =='admin.update-profile'){
            $managerActive = $profile = true;
            }
            if($action =='admin.change-password'){
            $managerActive = $changePassword = true;
            }
            if($action =='admin.accounts'){
            $managerActive = $accounts = true;
            }   
            if($action =='admin.settings'){
            $managerActive = $settings = true;
            }          
            @endphp
            <li class="sidebar-item  has-sub {{$managerActive?'active':''}}">
               <a href="#" class='sidebar-link'> <i class="bi bi-person-fill"></i> <span>My Profile</span> </a>
               <ul class="submenu {{$managerActive?'active':''}}">
                  <li class="submenu-item {{$profile?'active':''}}"> 
                     <a href="{{ url('/admin/update-profile'); }}">Update Profile</a> 
                  </li>
                  <li class="submenu-item {{$changePassword?'active':''}} "> 
                     <a href="{{ url('/admin/change-password'); }}">Change Password</a> 
                  </li>
                  @if(Session::get('admin_type') == 'Admin' || Session::get('admin_type') == 'Account')
                  <li class="submenu-item {{$settings?'active':''}} ">
                     <a href="{{ url('/admin/settings'); }}">Settings</a>
                  </li>
                  @endif
                  @if(Session::get('admin_type') == 'Admin')
                  <li class="submenu-item {{$accounts?'active':''}}"> 
                     <a href="{{ url('/admin/accounts'); }}">Accounts</a> 
                  </li>
                  @endif
               </ul>
            </li>

            @if(Session::get('admin_type') == 'Employee' || Session::get('admin_type') == 'Admin' || Session::get('admin_type') == 'Account')
            @php                        
            $managerActive =
            $attendence_form =
            $attendence =
            $payslips =
            $advance =
            $incentives =
            false;
            if($action =='admin.attendence'){
            $managerActive = $attendence = true;
            }
            if($action =='admin.employee-attendence'){
            $managerActive = $attendence_form = true;
            }
            if($action =='admin.payslips'){
            $managerActive = $payslips = true;
            }
            if($action =='admin.advance' || $action =='admin.add-advance' || $action =='admin.edit-advance'){
            $managerActive = $advance = true;
            }
            if($action =='admin.incentives' || $action =='admin.add-incentive' || $action =='admin.edit-incentive'){
            $managerActive = $incentives = true;
            }
            @endphp
            <li class="sidebar-item  has-sub {{$managerActive?'active':''}}">
               <a href="#" class='sidebar-link'> <i class="bi bi-person-fill"></i> <span>Employee</span> </a>
               <ul class="submenu {{$managerActive?'active':''}}">
                  @if(Session::get('admin_type') == 'Employee')
                  <li class="submenu-item {{$attendence_form?'active':''}}">
                     <a href="{{ url('/admin/employee-attendence'); }}">Attendance</a>
                  </li>
                  @endif
                  @if(Session::get('admin_type') == 'Admin' || Session::get('admin_type') == 'Account')
                  <li class="submenu-item {{$attendence?'active':''}}">
                     <a href="{{ url('/admin/attendence'); }}">Attendance Sheet</a>
                  </li>
                  <li class="submenu-item {{$payslips?'active':''}}">
                     <a href="{{ url('/admin/payslips'); }}">Payslips</a>
                  </li>
                  <li class="submenu-item {{$incentives?'active':''}}">
                     <a href="{{ url('/admin/incentives'); }}">Incentives</a>
                  </li>
                  <!---<li class="submenu-item {{$advance?'active':''}}">
                     <a href="{{ url('/admin/advance'); }}">Advance</a>
                  </li>--->
                  @endif
               </ul>
            </li>
            @endif

            @if(Session::get('admin_type') == 'Admin' || Session::get('admin_type') == 'Account')
            @php                        
            $managerActive =
            $employees =
            $users =
            $admins =
            false;
            if($action =='admin.admins' ||  $action =='admin.add-admins' ||  $action =='admin.edit-admins'){
            $managerActive = $admins = true;
            }
            if($action =='admin.employees' ||  $action =='admin.add-employee' ||  $action =='admin.edit-employee'){
            $managerActive = $employees = true;
            }
            if($action =='admin.users' ||  $action =='admin.add-user' ||  $action =='admin.edit-user'){
            $managerActive = $users = true;
            }
            @endphp
            <li class="sidebar-item  has-sub {{$managerActive?'active':''}}">
               <a href="#" class='sidebar-link'> <i class="bi bi-person-fill"></i> <span>Users</span> </a>
               <ul class="submenu {{$managerActive?'active':''}}">
                  <!---<li class="submenu-item {{$users?'active':''}}"> 
                     <a href="{{ url('/admin/users'); }}">Customers </a>
                     </li>--->
                  <li class="submenu-item {{$employees?'active':''}}"> 
                     <a href="{{ url('/admin/employees'); }}">Employees </a> 
                  </li>
                  <?php /*?>@if(Session::get('admin_type') == 'Admin')
                  <li class="submenu-item {{$admins?'active':''}}"> 
                     <a href="{{ url('/admin/admins'); }}">Admin Manager</a> 
                  </li>
                  @endif<?php */?>             
               </ul>
            </li>
            @endif

            <li class="sidebar-item"> <a href="{{ url('/admin/logout'); }}" class='sidebar-link'> <i class="bi bi-box-arrow-right"></i> <span>Log Out</span> </a> </li>
         </ul>
      </div>
      <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
   </div>
</div>