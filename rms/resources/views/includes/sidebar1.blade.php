
<head>
	<link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<style>
	
	
	.borderlines{
	            border-radius: .267rem;
				border-top-left-radius: 0.267rem;
				border-top-right-radius: 0.267rem;
				border-bottom-right-radius: 0.267rem;
				border-bottom-left-radius: 0.267rem; border: 1px solid #585c63;
				border-top-color: #585c63;
				border-top-style: solid;
				border-top-width: 1px;
				border-right-color: #585c63;
				border-right-style: solid;
				border-right-width: 1px;
				border-bottom-color: #585c63;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				border-left-color: #585c63;
				border-left-style: solid;
				border-left-width: 1px;
				border-image-source: initial;
				border-image-slice: initial;
				border-image-width: initial;
				border-image-outset: initial;
				border-image-repeat: initial;
				margin-right:10px;
				margin-left: 7px;
}
	.menutitles{
            	color: #ffffff;
				font-size: 12px;
				text-transform: uppercase;
				font-weight: 500;
				letter-spacing: .5px;
				margin-bottom: 5px;
				height: 15px;
				padding-left: 20px;
}

	.main-menu.menu-dark {
    color: #8A99B5;
    background: #1A233A;
    border: #464D5C
}

.main-menu.menu-dark .navigation {
    background: #1A233A
}

.main-menu.menu-dark .navigation .navigation-header {
    color: #BAC0C7;
    margin: calc(2.2rem - .5rem) 0 .5rem 1.8rem;
    padding: 0;
    letter-spacing: 1px
}

.main-menu.menu-dark .navigation li.has-sub ul {
    padding: 7px 0 0;
    margin: -7px 0 0
}

.main-menu.menu-dark .navigation li.has-sub ul li.has-sub ul.menu-content>li a {
    padding: 10px 20px!important;
    -webkit-transition: all .35s ease!important;
    transition: all .35s ease!important
}

.main-menu.menu-dark .navigation li.has-sub ul li.has-sub ul.menu-content>li a:hover {
    padding-left: 25px!important
}

.main-menu.menu-dark .navigation li a {
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center;
    color: #8494A7;
    padding: 10px 12px;
}

.main-menu.menu-dark .navigation>li ul .has-sub:not(.open)>ul,
.main-menu.menu-dark .navigation>li:not(.open)>ul {
    display: none
}

.main-menu.menu-dark .navigation>li {
    margin: 0 1rem;
    -webkit-transition: background-color .5s ease;
    transition: background-color .5s ease
}

.main-menu.menu-dark .navigation>li.nav-item:not(.has-sub) a {
    padding: 10px 12px
}

.main-menu.menu-dark .navigation>li.open.sidebar-group-active>a {
    padding: 10px 15px
}

.main-menu.menu-dark .navigation>li.nav-item.open>a,
.main-menu.menu-dark .navigation>li.nav-item.sidebar-group-active>a {
    margin: 0 11px;
    padding: 9px 0;
    transition: transform .25s ease 0s, -webkit-transform .25s ease 0s
}

.main-menu.menu-dark .navigation>li.nav-item.open>a i,
.main-menu.menu-dark .navigation>li.nav-item.sidebar-group-active>a i {
    color: #5A8DEE!important
}
div ul li::before{
	padding: 10px 15px
    /* border-radius: .267rem; */
    /* border: 1px solid #464D5C; */
    /* background-color: #1A233A; */
  
}

div ul li:hover{
	border-radius: .267rem;
				border-top-left-radius: 0.267rem;
				border-top-right-radius: 0.267rem;
				border-bottom-right-radius: 0.267rem;
				border-bottom-left-radius: 0.267rem; border: 1px solid #585c63;
				border-top-color: #585c63;
				border-top-style: solid;
				border-top-width: 1px;
				border-right-color: #585c63;
				border-right-style: solid;
				border-right-width: 1px;
				border-bottom-color: #585c63;
				border-bottom-style: solid;
				border-bottom-width: 1px;
				border-left-color: #585c63;
				border-left-style: solid;
				border-left-width: 1px;
				border-image-source: initial;
				border-image-slice: initial;
				border-image-width: initial;
				border-image-outset: initial;
				border-image-repeat: initial;
				margin-right:10px;
				margin-left: 7px;
}

.main-menu.menu-dark .navigation>li.nav-item.open .menu-content li a,
.main-menu.menu-dark .navigation>li.nav-item.sidebar-group-active .menu-content li a {
    padding: 10px 18px
}

.main-menu.menu-dark .navigation>li.nav-item.open .menu-content li>a:hover,
.main-menu.menu-dark .navigation>li.nav-item.sidebar-group-active .menu-content li>a:hover {
    padding-left: 15px!important
}

.main-menu.menu-dark .navigation>li.active:not(.sidebar-group-active)>a {
    background: rgba(90, 141, 238, .15);
    color: #5A8DEE;
    border-radius: .267rem
}

.main-menu.menu-dark .navigation>li .active>a {
    margin-bottom: 0
}

.main-menu.menu-dark .navigation>li .active .hover {
    background: #141B2C
}

.main-menu.menu-dark .navigation>li ul li>a {
    padding: 10px 9px!important;
    margin: 0 11px
}

.main-menu.menu-dark .navigation>li ul .open>a,
.main-menu.menu-dark .navigation>li ul .sidebar-group-active>a {
    color: #8A99B5
}

.main-menu.menu-dark .navigation>li ul .open>ul,
.main-menu.menu-dark .navigation>li ul .open>ul .open>ul,
.main-menu.menu-dark .navigation>li ul .sidebar-group-active>ul,
.main-menu.menu-dark .navigation>li ul .sidebar-group-active>ul .open>ul {
    display: block
}

.main-menu.menu-dark .navigation>li ul .open.active,
.main-menu.menu-dark .navigation>li ul .sidebar-group-active.active {
    background-color: inherit
}

.main-menu.menu-dark .navigation>li ul .active {
    background: rgba(90, 141, 238, .15)
}

.main-menu.menu-dark .navigation>li ul .active>a {
    color: #5A8DEE
}

.main-menu.menu-dark .navigation>li>ul>li:first-child>a {
    border-top: 1px solid #464D5C
}

.main-menu.menu-dark .navigation>li>ul>li.active:first-child>a {
    border-top: none
}

.main-menu.menu-fixed {
    position: fixed;
    top: 0
}

.main-menu.menu-static {
    height: auto;
    top: 0;
    padding-bottom: calc(100% - 40rem)
}

.main-menu.menu-static .main-menu-content {
    height: unset!important
}

.main-menu .shadow-bottom {
    display: none;
    position: absolute;
    z-index: 2;
    height: 60px;
    width: 100%;
    pointer-events: none;
    margin-top: -1.3rem;
    -webkit-filter: blur(5px);
    filter: blur(5px);
    background: -webkit-linear-gradient(#F2F4F4 41%, rgba(255, 255, 255, .11) 95%, rgba(255, 255, 255, 0));
    background: linear-gradient(#F2F4F4 41%, rgba(255, 255, 255, .11) 95%, rgba(255, 255, 255, 0))
}

.main-menu .navbar-header {
    width: 260px;
    height: 4.6rem;
    position: relative;
    padding: .35rem 1.45rem .3rem 1.3rem;
    -webkit-transition: .3s ease all;
    transition: .3s ease all;
    cursor: pointer;
    z-index: 3
}

.main-menu .navbar-header .navbar-brand {
    margin-top: .75rem;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-align: center;
    -webkit-align-items: center;
    -ms-flex-align: center;
    align-items: center
}

.main-menu .navbar-header .navbar-brand .brand-logo {
    height: 27px;
    width: 35px;
    float: left;
    margin-top: .2rem;
    margin-left: 3px
}

.main-menu .navbar-header .navbar-brand .brand-logo .logo {
    height: 26px;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    position: relative;
    left: 6px
}

.main-menu .navbar-header .navbar-brand .brand-text {
    color: #5A8DEE;
    padding-left: .7rem;
    font-weight: 500;
    letter-spacing: .04rem;
    font-size: 1.5rem;
    float: left;
    -webkit-animation: .3s cubic-bezier(.25, .8, .25, 1) 0s normal forwards 1 fadein;
    animation: .3s cubic-bezier(.25, .8, .25, 1) 0s normal forwards 1 fadein
}

.main-menu .navbar-header .modern-nav-toggle {
    -webkit-animation: .3s cubic-bezier(.25, .8, .25, 1) 0s normal forwards 1 fadein;
    animation: .3s cubic-bezier(.25, .8, .25, 1) 0s normal forwards 1 fadein;
    margin: .75rem 0 0
}

.main-menu .main-menu-content {
    height: calc(100% - 6rem)!important;
    position: relative
}

.main-menu ul {
    list-style: none;
    margin: 0;
    padding: 0
}

.main-menu ul.navigation-main {
    overflow-x: hidden
}

.nav-item {
    font-family: Rubik, Helvetica, Arial, serif;
    overflow-y: hidden;
    
}

.navigation .navigation-header {
    padding: 12px 22px;
    font-size: .8rem;
    text-transform: uppercase
}

.navigation li {
    position: relative
}

.navigation li a {
    display: block;
    text-overflow: ellipsis;
    overflow: hidden
}

.navigation li.disabled a {
    cursor: not-allowed
}

.dropdown-notification {
    padding: 13px 0
}

.dropdown-notification .nav-link-label {
    position: relative
}

.dropdown-notification .media-heading {
    margin-bottom: .2rem;
    font-size: .8rem
}

.dropdown-notification .notification-text {
    margin-bottom: .5rem;
    font-size: smaller;
    color: #828D99
}

.avatar,
.dropdown-notification .dropdown-menu-header .dropdown-header {
    color: #FFF
}

.dropdown-notification .notification-tag {
    position: relative;
    top: -4px
}

.dropdown-notification .dropdown-menu.dropdown-menu-right {
    right: -2px;
    padding: 0
}

.dropdown-notification .dropdown-menu.dropdown-menu-right::before {
    background: #5A8DEE;
    border-color: #5A8DEE
}

.dropdown-notification .dropdown-menu.dropdown-menu-right .scrollable-container .read-notification {
    background-color: #F2F4F4
}

.dropdown-notification .dropdown-menu-header {
    border-top-left-radius: .267rem;
    border-top-right-radius: .267rem;
    background: #5A8DEE
}

body.menu-collapsed .menu-static {
    padding-bottom: calc(100% - 14rem)
}

@media (max-width:767.98px) {
    .menu-hide .nav-item,
    .menu-open .nav-item {
        -webkit-transition: top .35s, height .35s, -webkit-transform .25s;
        transition: top .35s, height .35s, -webkit-transform .25s;
        transition: transform .25s, top .35s, height .35s;
        transition: transform .25s, top .35s, height .35s, -webkit-transform .25s
    }
    .main-menu {
        -webkit-transform: translate3d(-240px, 0, 0);
        transform: translate3d(-240px, 0, 0);
        -webkit-backface-visibility: hidden;
        backface-visibility: hidden;
        -webkit-perspective: 1000;
        perspective: 1000
    }
    .menu-open .main-menu {
        -webkit-transform: translate3d(0, 0, 0);
        transform: translate3d(0, 0, 0)
    }
}

@media (min-width:768px) {
    .drag-target {
        z-index: 0
    }
}
</style>
<div class="sidebar" id="sidebar">
	<div class="sidebar-inner slimscroll">
		<div id="sidebar-menu" class="sidebar-menu">
			<ul>
				{{-- //menu listing with inner styles --}}

				<li class="menutitles">Main</li>
				<li class="nav-item" class=" {{ Route::currentRouteName() === 'home' ? 'active' : '' }}">
					<a href="{{ route('home')}}"><i class="la la-dashboard"></i> <span>Dashboard</span></a>
				</li><br>
			    @if (Auth::user()->is_admin==1 || Auth::user()->is_admin==2 )
				<li class="menutitles">Agency</li>
				
				{{-- <li class="borderlines" ><a href="#"><i class="la la-building-o"></i> <span> Agency </span> <span
							class="menu-arrow"></span></a>
		

				
					<ul> --}}
						
						{{-- <li class="submenu " ><a href="#"><i class="la la-money"></i> &nbsp;<span>Income </span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;">
						@if (Auth::user()->is_admin==1 || Auth::user()->is_admin==2 )
						<li><a href="{{ route('incomes.create') }}"
							class="{{ Route::currentRouteName() === 'incomes.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Income</a>
					</li>
				
				
				@endif 
                            
						
					</ul>
				</li> --}}
				
					{{-- <li ><a href="{{ route('deposit.list') }}"
						class="{{ Route::currentRouteName() === 'deposit.list' ? 'active' : '' }}"><i class="la la-money"></i> &nbsp; <span> Deposits </span> </a>
				</li> --}}
				
				<li class="submenu ">
					<a href="#"><i class="la la-cart-arrow-down"></i> &nbsp;<span> Bills </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
					
						<li><a href="{{ route('bill.create') }}"
							class="{{ Route::currentRouteName() === 'bill.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; Add Bill</a>
					</li>
					@if (Auth::user()->is_admin==2 )
					<li>
						<a href="{{ route('bill.pay') }}"
								class="{{ Route::currentRouteName() === 'bill.pay' ? 'active' : '' }}"><i class="la la-money"></i> &nbsp; <span>Pay Bill</span></a>
						</li>
				    @endif
					<li><a href="{{ route('payowners.list') }}"
						class="{{ Route::currentRouteName() === 'payowners.list' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp; List Bills</a>
				</li>

						{{-- <li class="submenu"><a href="#"
								><i class="la la-institution"></i> &nbsp;Agency<span class="menu-arrow"></span></a>
								<ul style="display: none;">
									
								</ul>
						</li> --}}
						{{-- <li class="submenu"><a href="#" 
							><i class="la la-building-o"></i> &nbsp;Properties <span class="menu-arrow"></span></a>
							<ul style="display: none;">
								<li><a href="{{ route('expenses.property') }}"
									class="{{ Route::currentRouteName() === 'expenses.property' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Bill</a>
							</li>
							<li><a href="{{ route('expenses.bills') }}"
								class="{{ Route::currentRouteName() === 'expenses.bills' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp;List Bills</a>
						</li>
							</ul>
				   </li> --}}
					</ul>

				</li>	
				
				<li class="submenu ">
					
					<a href="#"><i class="la la-money"></i> &nbsp;<span> Invoices </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						

						{{-- <li><a href="{{ route('servicerequests.create') }}"
								class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
						</li> --}}
						<li>
							<a href="{{ route('manualinvoice.create') }}"
									class="{{ Route::currentRouteName() === 'manualinvoice.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; <span>Add Invoice</span></a>
							</li> 
						@if (Auth::user()->authorize_payment )
						<li>
							<a href="{{ route('manualinvoice.pay') }}"
									class="{{ Route::currentRouteName() === 'manualinvoice.pay' ? 'active' : '' }}"><i class="la la-money"></i> &nbsp; <span>Pay Invoices</span></a>
							</li> @endif
						<li><a href="{{ route('manualinvoice.list') }}"
							class="{{ Route::currentRouteName() === 'manualinvoice.list' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp; <span>List Invoices</span></a>
					</li>
						@if (Auth::user()->authorize_payment )
					<li><a href="{{ route('manualinvoice.payments') }}"
						class="{{ Route::currentRouteName() === 'manualinvoice.payments' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp; <span>List Payments</span></a>
				</li>@endif
					{{-- <li><a href="#"
						class=""><i class="la la-plus-circle"></i> &nbsp;Pay Bills</a>
				</li> --}}
						{{-- <li><a href="{{ route('servicerequests.index') }}" 
							class="{{ Route::currentRouteName() === 'servicerequests.index' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp;List Requests</a>
				   </li> --}}
								
						
					</ul></li>
					
                <li class="submenu ">
					
					<a href="#"><i class="la la-rotate-left"></i> &nbsp;<span> Service Request </span> <span class="menu-arrow"></span></a>
					<ul style="display: none;">
						

						{{-- <li><a href="{{ route('servicerequests.create') }}"
								class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
						</li> --}}
						<li><a href="{{ route('servicerequests.create') }}"
							class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
					</li>
						<li><a href="{{ route('servicerequests.index') }}" 
							class="{{ Route::currentRouteName() === 'servicerequests.index' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp;List Requests</a>
				   </li> 
								
						
					</ul></li>
					<li>
					
						<a href="{{ route('sms.custom') }}" class="{{ Route::currentRouteName() === 'sms.custom' ? 'active' : '' }}"><i class="la la-envelope"></i> &nbsp;<span> Custom SMS </span> </a>
					</li>
							
	
						
					
									
							
						
						<li >
					
							<a href="{{ route('filemanager.index')}}" class=" {{ Route::currentRouteName() === 'filemanager.index' ? 'active' : '' }}"><i class="la la-file"></i> &nbsp;<span> File Manager </span> </a>
						</li>
						@if (Auth::user()->is_admin==2 )
						<li >
					
							<a href="{{ route('softdeletes.index')}}" class=" {{ Route::currentRouteName() === 'softdeletes.index' ? 'active' : '' }}"><i class="la la-trash"></i> &nbsp;<span> Deleted Items </span> </a>
						</li>
						<li >
					
							<a href="{{ route('logs.index')}}" class=" {{ Route::currentRouteName() === 'logs.index' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp;<span> Logs </span> </a>
						</li>
						@endif
						@endif 
						
								
		
							
					<!--<li>-->
					<!--<a href="{{route('filemanager.index')}}" class="{{ Route::currentRouteName() === 'filemanager.index' ? 'active' : '' }}"> <i class="la la-folder-open"></i>&nbsp; <span> File Manager </span> </a></li>-->
					
                <br>
			<li class="menutitles">Property Owners</li>
		
				<li >
					
						<li><a href="{{route('landlord.create')}}"
								class="{{ Route::currentRouteName() === 'landlord.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; Add Owner</a></li>
						<li><a href="{{ route('landlord.index')}}"
								class="{{ Route::currentRouteName() === 'landlord.index' ? 'active' : '' }}"><i class="la la-list-ul"></i> &nbsp;List
								Owners</a></li>
								
								<!-- <li><a href="{{ route('client.index')}}"
								class="{{ Route::currentRouteName() === 'landlord.index' ? 'active' : '' }}">List All Clients
							</a></li> -->

						<li class="d-none"><a href="" class="{{ (Route::currentRouteName() === 'landlord.changepassword' ||
								Route::currentRouteName() === 'landlord.show' ||								
								Route::currentRouteName() === 'landlord.edit') ? 'active' : '' }}"> </a>
						</li>
					
				</li><br>
                <li class="menutitles">Properties</li>

				<li>
					{{-- <a href="#"><i class="la la-home"></i> <span> Properties</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;"> --}}
						<li><a href="{{ route('apartment.create')}}"
								class="{{ Route::currentRouteName() === 'apartment.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i>&nbsp;Add
								Property</a></li>
						<li><a href="{{ route('apartment.add_unit')}}"
								class="{{ Route::currentRouteName() === 'apartment.add_unit' ? 'active' : '' }}"><i class="la la-link"></i>&nbsp;Add House</a></li>
						<li><a href="{{route('apartment.list')}}"
								class="{{ Route::currentRouteName() === 'apartment.list' ? 'active' : '' }}"><i class="la la-building-o"></i>&nbsp;List Properties</a></li>

						<li class="d-none"><a href="" class="{{ (
								Route::currentRouteName() === 'apartment.show' ||								
								Route::currentRouteName() === 'apartment.edit') ? 'active' : '' }}">
							</a>
						</li>
						<li><a href="{{ route('house.list')}}"
								class="{{ Route::currentRouteName() === 'house.list' ? 'active' : '' }}"><i class="la la-list-ul"></i>&nbsp;List houses</a>
						</li>
						{{-- <li><a href="{{ route('house.vacant')}}"
								class="{{ Route::currentRouteName() === 'house.vacant' ? 'active' : '' }}"><i class="la la-toggle-off"></i>&nbsp;All
								Vacant</a>
						</li>
						<li><a href="{{ route('house.occupied')}}"
								class="{{ Route::currentRouteName() === 'house.occupied' ? 'active' : '' }}"><i class="la la-toggle-on"></i>&nbsp;All
								Occupied</a>
						</li> --}}

						<li class="d-none"><a href="" class="{{ (
								Route::currentRouteName() === 'house.show' ||								
								Route::currentRouteName() === 'house.edit' ||								
								Route::currentRouteName() === 'house.occupied') ? 'active' : '' }}">
							</a>
						</li>
						<li class="d-none"><a href="" class="{{ (
								Route::currentRouteName() === 'house.show' ||								
								Route::currentRouteName() === 'house.edit' ||								
								Route::currentRouteName() === 'house.occupied') ? 'active' : '' }}">
							</a>
						</li>
					{{-- </ul> --}}
				</li><br>
                <li class="menutitles">Tenants</li>
				<li >
					{{-- <a href="#"><i class="la la-user"></i> <span> Tenants</span> <span class="menu-arrow"></span></a>
					<ul style="display: none;"> --}}
						<!-- <li><a href="#"
								class="{{ Route::currentRouteName() === 'tenant.create' ? 'active' : '' }}">
								Register New</a></li>
						<li><a href="#"
								class="{{ Route::currentRouteName() === 'tenant.assign_room' ? 'active' : '' }}">
								Assign House</a></li>
						<li><a href="#"
								class="{{ Route::currentRouteName() === 'tenant.all' ? 'active' : '' }}">List All</a>
						</li>

						<li class="d-none"><a href="" class="#"> </a>
						</li> -->
						<li><a href="{{route('tenant.create')}}"
								class="{{ Route::currentRouteName() === 'tenant.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;
								Add Tenant</a></li>
						<li><a href="{{route('tenant.assign_room')}}"
								class="{{ Route::currentRouteName() === 'tenant.assign_room' ? 'active' : '' }}"><i class="la la-link"></i>&nbsp;
								Assign House</a></li>
						<li><a href="{{ route('tenant.all')}}"
								class="{{ Route::currentRouteName() === 'tenant.all' ? 'active' : '' }}"><i class="la la-list-ul"></i>&nbsp; List Tenants</a>
						</li>

						<li class="d-none"><a href="" class="{{ (Route::currentRouteName() === 'tenant.changepassword' ||
								Route::currentRouteName() === 'tenant.show' ||
								Route::currentRouteName() === 'tenant.assign_room' ||
								Route::currentRouteName() === 'tenant.edit') ? 'active' : '' }}"> </a>
						</li>
					{{-- </ul> --}}
				</li><br>
				@if (Auth::user()->is_admin==2 )
				<li class="menutitles">Reports</li>
				<li class="">
					{{-- <a href="#"><i class="la la-institution"></i> <span> House Options</span> <span
							class="menu-arrow"></span></a>
					<ul style="display: none;"> --}}
						{{-- <li><a href="{{ route('report.tenant') }}"
								class="{{ Route::currentRouteName() === 'report.tenant' ? 'active' : '' }}"><i class="la la-users"></i>&nbsp;Tenants</a>
						</li> --}}
						<li class="submenu "><a href="#"><i class="la la-users"></i>&nbsp;Tenants<span class="menu-arrow"></span></a>
							<ul style="display: none;">
					

								{{-- <li><a href="{{ route('servicerequests.create') }}"
										class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
								</li> --}}
								<li>
									<a href="{{ route('report.tenantform') }}"
									class="{{ Route::currentRouteName() === 'report.tenantform' ? 'active' : '' }}"><i class="la la-file"></i> &nbsp; <span>Statements</span></a>
									</li> 
									<li>
										{{-- <a href="{{ route('report.tenant') }}"
										class="{{ Route::currentRouteName() === 'report.tenant' ? 'active' : '' }}"><i class="la la-users"></i> &nbsp; <span>List Tenants</span></a>
										</li>  --}}
										{{-- <li>
											<a href="{{ route('payowners.list') }}"
													><i class="la la-money"></i> &nbsp; <span>Income</span></a>
											</li>  --}}
								{{-- <li><a href=""
									class="{{ Route::currentRouteName() === 'payowners.list' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; Income</a>
							</li> --}}
							</ul>
					</li>
						{{-- <li><a href="{{ route('report.landlord') }}"
								class="{{ Route::currentRouteName() === 'report.landlord' ? 'active' : '' }}"><i class="la la-building-o"></i>&nbsp;Property Owners</a>
						</li> --}}
						<li class="submenu "><a href="#"><i class="la la-user"></i>&nbsp;Property Owners<span class="menu-arrow"></span></a>
							<ul style="display: none;">
					

								{{-- <li><a href="{{ route('servicerequests.create') }}"
										class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
								</li> --}}
								
									{{-- <li>
										<a href="{{ route('report.landlord') }}"
										class="{{ Route::currentRouteName() === 'report.landlord' ? 'active' : '' }}"><i class="la la-user"></i> &nbsp; <span>List Owners</span></a>
										</li> 
										<li>
											<a href="{{ route('payowners.list') }}"
											class="{{ Route::currentRouteName() === 'payowners.list' ? 'active' : '' }}"><i class="la la-money"></i> &nbsp; <span>Income</span></a>
											</li>  --}}
											<li>
												<a href="{{ route('report.landlordform') }}"
												class="{{ Route::currentRouteName() === 'report.landlordform' ? 'active' : '' }}"><i class="la la-file"></i> &nbsp; <span>Statements</span></a>
												</li> 
								{{-- <li><a href=""
									class="{{ Route::currentRouteName() === 'payowners.list' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; Income</a>
							</li> --}}
							</ul>
					</li>
						<li class="submenu "><a href="#"><i class="la la-institution"></i>&nbsp;Agency<span class="menu-arrow"></span></a>
								<ul style="display: none;">
						

									{{-- <li><a href="{{ route('servicerequests.create') }}"
											class="{{ Route::currentRouteName() === 'servicerequests.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add Request</a>
									</li> --}}
									{{-- {<li>
										<a href="{{ route('report.agencyunpaidreport') }}"
												><i class="la la-close"></i> &nbsp; <span>Unpaid Houses</span></a>
										</li> 
										<li>
											<a href="{{ route('report.agencypaidreport') }}"
													><i class="la la-check"></i> &nbsp; <span>Paid Houses</span></a>
											</li>  --}}
											<li>
												<a href="{{ route('report.agencyform') }}"
												class="{{ Route::currentRouteName() === 'report.agencyform' ? 'active' : '' }}"><i class="la la-file"></i> &nbsp; <span>Statement</span></a>
												</li> 
									{{-- <li><a href=""
										class="{{ Route::currentRouteName() === 'payowners.list' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp; Income</a>
								</li> --}}
								</ul>
						</li>
						@endif
						{{-- <li><a href="#"
							class="{{ Route::currentRouteName() === 'house.occupied' ? 'active' : '' }}"><i class="la la-rotate-left"></i> &nbsp;Service Requests</a>
					</li> --}}
					{{-- <li><a href="{{ route('servicerequests.index') }}" 
						class="{{ Route::currentRouteName() === 'servicerequests.index' ? 'active' : '' }}"><i class="la la-rotate-left"></i> &nbsp; Service Requests</a>
			   </li> --}}

						

					
				</li><br>
				@if (Auth::user()->is_admin==2 )
				<li class="menutitles">Users</li>
				
				<li class="submenu ">
					
					<li><a href="{{ route('admin.create') }}"
						class="{{ Route::currentRouteName() === 'admin.create' ? 'active' : '' }}"><i class="la la-plus-circle"></i> &nbsp;Add
						User</a>
				      </li>
						<li><a href="{{ route('admin.index') }}" class="{{ Route::currentRouteName() === 'admin.index' ? 'active' : '' }} 
								{{ Route::currentRouteName() === 'admin.edit' ? 'active' : '' }}
								"><i class="la la-list-ul"></i> &nbsp;List Users</a>
						</li>

						

						
						
					</ul></li>
					
				@endif
				
				</ul>
			</li>
			
				
			
            
				
		</div>
	</div>
</div>