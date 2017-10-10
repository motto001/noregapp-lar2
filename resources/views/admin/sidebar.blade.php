<aside>
    <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
        <ul class="sidebar-menu" id="nav-accordion">
              
            <p class="centered"><a href="profile.html"><img src="/assets/img/ui-sam.jpg" class="img-circle" width="60"></a></p>
            <h5 class="centered">{{ Auth::user()->name }} </h5>
            
            <li class="mt">
                <a class="active" href="index.html">
                    <i class="fa fa-dashboard"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="sub-menu">
                <a href="javascript:;" >
                    <i class="fa fa-desktop"></i>
                    <span>UI Elements</span>
                </a>
                <ul class="sub">
                    <li><a  href="general.html">General</a></li>
                    <li><a  href="buttons.html">Buttons</a></li>
                    <li><a  href="panels.html">Panels</a></li>
                </ul>
            </li>
                        
 <!-- si**************************************************** -->

@if (Auth::user()->hasRole('admin'))             
 
 
      
            <li class="sub-menu">
                <a href="{{ url('/admin/conf') }}">
                  <span> Config</span>
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/admin/roles') }}">
                    Jogok
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/admin/users') }}">
                   Felhasználók, Jogok
                </a>
            </li>    
    
@endif
@if (Auth::user()->hasRole('manager'))  
         
    <div class="panel-heading">
        Manager
    </div>
    
       
            <li class="mt">
                <a href="{{ url('/manager/users') }}">
                    Felhasználók
                </a>
            </li>
        
       
            <li class="mt">
                <a href="{{ url('/manager/workersfull') }}">
                   Dplgozók
                </a>
            </li>
        
       
            <li class="mt">
                <a href="{{ url('/manager/statuses') }}">
                    Dolgozói státusz
                </a>
            </li>
        
        
            <li class="mt">
                <a href="{{ url('/manager/workergroups') }}">
                    Dolgozói csoportok
                </a>
            </li>
        
        
            <li class="mt">
                <a href="{{ url('/manager/workertypes') }}">
                    Munka tipusok
                </a>
            </li>
       
            <li class="mt">
                <a href="{{ url('/manager/days') }}">
                    Napok
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/manager/daytypes') }}">
                    Naptipusok
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/manager/timeframes') }}">
                    Időkeretek
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/manager/timetypes') }}">
                    Munkaidőtipusok
                </a>
            </li>     
            <li class="mt">
                <a href="{{ url('/manager/wroles') }}">
                    Munkarendek
                </a>
            </li>  
            <li class="mt">
                <a href="{{ url('/manager/wroleunits') }}">
                    Munkarend ciklusok
                </a>
            </li>  
            <li class="mt">
                <a href="{{ url('/manager/wroletimes') }}">
                    Munkarend ciklusidők
                </a>
            </li>
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
      
    

@endif
@if (Auth::user()->hasRole('workadmin')) 
          
    <div class="panel-heading">
        Workadmin
    </div>
    
       
            <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Munkaidők
                </a>
            </li>
            <li class="mt">
                <a href="{{ url('/workadmin/') }}">
                    Szabadság, betegállomány
                </a>
            </li>
             <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
            
            <li class="mt">
                <a href="{{ url('/workadmin/') }}">
                    Dolgozok
                </a>
            </li>
        

@endif
@if (Auth::user()->hasRole('worker'))   
         
    <div class="panel-heading">
        Worker
    </div>
    
       
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                    Saját adatok
                </a>
            </li>
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Szabadság, betegállomány
                </a>
            </li>
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                   kiküldetés
                </a>
            </li>
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                   Munkaidő nyilvántartás
                </a>
            </li>
           <li class="mt">
                <a href="{{ url('/workadmin/workerdays') }}">
                  költdég térítés
                </a>
            </li>
     

@endif

 <!-- si------- -->
    </ul>
              <!-- sidebar menu end-->
</div>
</aside>
