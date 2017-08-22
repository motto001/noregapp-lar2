<div class="col-md-3">

 
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                   User Manager
                </div>

                <div class="panel-body">
                    <ul class="nav" role="tablist">
 @if (Auth::user()->hasRole('user'))                 
                            <li role="admin">
                                <a href="{{ url('/user/password') }}">
                                    Jelszó változtatás
                                </a>
                            </li>
                        <li role="admin">
                                <a href="{{ url('/user/email') }}">
                                    Email változtatás
                                </a>
                            </li>

                            <li role="admin">
                                <a href="{{ url('/user/personal') }}">
                                   Személyes adataok
                                </a>
                            </li>
                             <li role="admin">
                                <a href="{{ url('/user/worktime') }}">
                                   Munkaidők 
                                </a>
                            </li>



 @endif
 @if (Auth::user()->hasRole('manager'))  
                            <li role="manager">
                                <a href="{{ url('/manager/workers') }}">
                                    Dolgozok
                                </a>
                            </li>
                              <li role="manager">
                                <a href="{{ url('/manager/users') }}">
                                    Felhasználók
                                </a>
                            </li>

@elseif (Auth::user()->hasRole('workadmin'))
                        <li role="manager">
                                <a href="{{ url('/workadmin/workers') }}">
                                    Dolgozok
                                </a>
                            </li>

 @endif
 @if (Auth::user()->hasRole('workadmin'))  
                            <li role="manager">
                                <a href="{{ url('/workadmin/worktimes') }}">
                                    Munkaidő
                                </a>
                            </li>
                         
 @endif




 @if (Auth::user()->hasRole('admin'))                     
                            <li role="root">
                                <a href="{{ url('/admin/roles') }}">
                                    Jogok
                                </a>
                            </li>
                            <li role="root">
                                <a href="{{ url('/admin/permissions') }}">
                                    Szabályok
                                </a>
                            </li>
                            <li role="root">
                                <a href="{{ url('/admin/give-role-permissions') }}">
                                   Give role-permissions
                                </a>
                            </li>

 @endif
         
           <li role="user">
                                <a href="{{ url('/user/chpassword') }}">
                                   Password
                                </a>
                            </li>              

                    </ul>
                </div>
            </div>
       @if (Auth::user()->hasRole('admin'))  
            <div class="panel panel-default panel-flush">
                <div class="panel-heading">
                    Tools
                </div>

                <div class="panel-body">
                    <ul class="nav" role="tablist">
                      
                            <li role="admin">
                                <a href="{{ url('/admin/generator') }}">
                                    Generator
                                </a>
                            </li>
                        
                    </ul>
                </div>
            </div>
        @endif

</div>

