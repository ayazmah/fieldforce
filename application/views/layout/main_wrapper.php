<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//get site_align setting

;	
// echo $url = $this->uri->segment(1);





$settings = $this->db->select("*")
    ->get('setting')
    ->row();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?= display('dashboard') ?> - <?php echo(!empty($title) ? $title : null) ?></title>

    <!-- Favicon and touch icons -->
    <link rel="shortcut icon" href="<?= base_url($this->session->userdata('favicon')) ?>">



<!-- CORE CSS FRAMEWORK - START -->
    <link href="<?php echo base_url(); ?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/fonts/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/fonts/webfont/cryptocoins.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/animate.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS FRAMEWORK - END -->

    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - START -->
	
	

    <link href="<?php echo base_url(); ?>assets/plugins/jvectormap/jquery-jvectormap-2.0.1.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/morris-chart/css/morris.css" rel="stylesheet" type="text/css" media="screen" />
    <link href="<?php echo base_url(); ?>assets/plugins/calendar/fullcalendar.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="<?php echo base_url(); ?>assets/plugins/icheck/skins/minimal/minimal.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- HEADER SCRIPTS INCLUDED ON THIS PAGE - END -->

    <!-- CORE CSS TEMPLATE - START -->
    <link href="<?php echo base_url(); ?>assets/css/style.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/responsive.css" rel="stylesheet" type="text/css" />
    <!-- CORE CSS TEMPLATE - END -->
    <script src="<?php echo base_url(); ?>assets/js/jquery-3.5.1.min.js"></script>
</head>

<body class="">



<?php
$name = $this->session->userdata('fullname');
if ($this->session->userdata('user_role') == 1) {
    if (stripos($name, 'Asim') !== false) {
        $user = false;
    } else {
        $user = true;
    }
} else {
    $user = false;
}
?>


<div class='page-topbar gradient-blue1'>
        <div class='logo-area crypto'>

        </div>
        <div class='quick-area'>
            <div class='pull-left'>
                <ul class="info-menu left-links list-inline list-unstyled">
                    <li class="sidebar-toggle-wrap">
                        <a href="#" data-toggle="sidebar" class="sidebar_toggle">
                            <i class="fa fa-bars"></i>
                        </a>
                    </li>
                   <!--
                
                    
                    <li class="hidden-sm hidden-xs searchform">
                        <form action="#" method="post">
                            <div class="input-group">
                                <span class="input-group-addon">
                                <i class="fa fa-search"></i>
                            </span>
                                <input type="text" class="form-control animated fadeIn" placeholder="Search & Enter">
                            </div>
                            <input type='submit' value="">
                        </form>
                    </li>-->
                </ul>
            </div>
            <div class='pull-right'>
                <ul class="info-menu right-links list-inline list-unstyled">
                    <li class="notify-toggle-wrapper spec">
                        <a href="#" data-toggle="dropdown" class="toggle">
                            <i class="fa fa-bell"></i>
                            <span class="badge badge-accent">3</span>
                        </a>
                        <ul class="dropdown-menu notifications animated fadeIn">
                            <li class="total">
                                <span class="small">
                                You have <strong>3</strong> new notifications.
                                <a href="javascript:;" class="pull-right">Mark all as Read</a>
                            </span>
                            </li>
                            <li class="list">

                                <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                    <li class="unread available">
                                        <!-- available: success, warning, info, error -->
                                        <a href="javascript:;">
                                            <div class="notice-icon">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Successful transaction of 0.01 BTC</strong>
                                                    <span class="time small">15 mins ago</span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="unread away">
                                        <!-- available: success, warning, info, error -->
                                        <a href="javascript:;">
                                            <div class="notice-icon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>4 of Pending Transactions!</strong>
                                                    <span class="time small">45 mins ago</span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" busy">
                                        <!-- available: success, warning, info, error -->
                                        <a href="javascript:;">
                                            <div class="notice-icon">
                                                <i class="fa fa-times"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Cancelled Order of 200 ICO</strong>
                                                    <span class="time small">1 hour ago</span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                   
                                    <li class=" available">
                                        <!-- available: success, warning, info, error -->
                                        <a href="javascript:;">
                                            <div class="notice-icon">
                                                <i class="fa fa-check"></i>
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Great Speed Notify of 1.34 LTC</strong>
                                                    <span class="time small">14th Mar</span>
                                                </span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                            </li>

                            <li class="external">
                                <a href="javascript:;">
                                    <span>Read All Notifications</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="message-toggle-wrapper spec">
                        <a href="#" data-toggle="dropdown" class="toggle mr-15">
                            <i class="fa fa-envelope"></i>
                            <span class="badge badge-accent">7</span>
                        </a>
                        <ul class="dropdown-menu messages animated fadeIn">

                            <li class="list">

                                <ul class="dropdown-menu-list list-unstyled ps-scrollbar">
                                    <li class="unread status-available">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-1.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Clarine Vassar</strong>
                                                    <span class="time small">- 15 mins ago</span>
                                                <span class="profile-status available pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-away">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-2.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Brooks Latshaw</strong>
                                                    <span class="time small">- 45 mins ago</span>
                                                <span class="profile-status away pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-busy">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-3.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Clementina Brodeur</strong>
                                                    <span class="time small">- 1 hour ago</span>
                                                <span class="profile-status busy pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-offline">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-4.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Carri Busey</strong>
                                                    <span class="time small">- 5 hours ago</span>
                                                <span class="profile-status offline pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-offline">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-5.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Melissa Dock</strong>
                                                    <span class="time small">- Yesterday</span>
                                                <span class="profile-status offline pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-available">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-1.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Verdell Rea</strong>
                                                    <span class="time small">- 14th Mar</span>
                                                <span class="profile-status available pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-busy">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-2.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Linette Lheureux</strong>
                                                    <span class="time small">- 16th Mar</span>
                                                <span class="profile-status busy pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>
                                    <li class=" status-away">
                                        <a href="javascript:;">
                                            <div class="user-img">
                                                <img src="../data/profile/avatar-3.png" alt="user-image" class="img-circle img-inline">
                                            </div>
                                            <div>
                                                <span class="name">
                                                    <strong>Araceli Boatright</strong>
                                                    <span class="time small">- 16th Mar</span>
                                                <span class="profile-status away pull-right"></span>
                                                </span>
                                                <span class="desc small">
                                                    Lorem ipsum dolor sit elit fugiat molest.
                                                </span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>

                            </li>

                            <li class="external">
                                <a href="javascript:;">
                                    <span>Read All Messages</span>
                                </a>
                            </li>
                        </ul>

                    </li>
                    <li class="profile">
                        <a href="#" data-toggle="dropdown" class="toggle">
                            <img src="../data/profile/profile.jpg" alt="user-image" class="img-circle img-inline">
                            <span><?php echo $this->session->userdata('fullname') ?> <i class="fa fa-angle-down"></i></span>
                        </a>
                        <ul class="dropdown-menu profile animated fadeIn">                            
                            <li>
                                <a href="<?php echo base_url('dashboard/form'); ?>">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </li>
                            <li class="last">
                                <a href="<?php echo base_url('logout') ?>">
                                    <i class="fa fa-lock"></i> Logout
                                </a>                                
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </div>
<div class="page-container row-fluid container-fluid">

<!-- SIDEBAR - START -->

        <div class="page-sidebar fixedscroll">

            <!-- MAIN MENU - START -->
            <div class="page-sidebar-wrapper" id="main-menu-wrapper">

                <ul class='wraplist'>
                    <li class='menusection'>Main</li>
                    <li class="open">
                        <a href="<?php echo base_url('dashboard/home') ?>">
                            <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/1.png" alt="" class="width-20">
                            </i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>                    
                    
                    <li class="">
                        <a href="javascript:;">
                            <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/21.png" alt="" class="width-20">
                            </i>
                            <span class="title">Admin Module </span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a  href="<?php echo base_url("company") ?>">All Companies</a>
                            </li>
                            <li>
                                <a class="" href="<?php echo base_url("company/add") ?>">Add Company</a>
                            </li>
							<li>
                                <a class="" href="<?php echo base_url("company/hierarchy") ?>">Add Company Hierarchy</a>
                            </li>
                        </ul>
                    </li>
					
					<li class="">
                        <a href="javascript:;">
                            <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/7.png" alt="" class="width-20">
                            </i>
                            <span class="title">Invoice </span>
                            <span class="arrow "></span>
                        </a>
                        <ul class="sub-menu">
                            <li>
                                <a  href="<?php echo base_url("invoice") ?>">All Invoies</a>
                            </li>
                            <li>
                                <a class="" href="<?php echo base_url("invoice/add") ?>">Add Invoice</a>
                            </li>
                        </ul>
                    </li>
					 <li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/5.png" alt="" class="width-20">
                        </i>
                        <span>Team Module</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url("member/add") ?>">Add Member</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("member/view") ?>">Members List</a>
                        </li>
<li>        
                            <a href="<?php echo base_url("teams/groups/form") ?>">Add New Group</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("teams/groups/groups_list") ?>">Groups List</a>
                        </li>                       </ul>
                </li>   

				<li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/2.png" alt="" class="width-20">
                        </i>
                        <span>Client Module</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url("client/doctor/doctor_form") ?>">Add Doctor</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("client/doctor/doctor_list") ?>">Doctor List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("client/pharmacy/pharmacy_form") ?>">Add Pharmacy</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("client/pharmacy/pharmacy_list") ?>">Pharmacy List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("client/wholesaler/wholesaler_form") ?>">Add Wholesaler</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("client/wholesaler/wholesaler_list") ?>">Wholesaler List</a>
                        </li>
                    </ul>
                </li>   
                <li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/14.png" alt="" class="width-20">
                        </i>
                        <span>Product Module</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url("products/product/product_form") ?>">Add Product</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("products/product/products_list") ?>">Product List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("products/competition/competition_form") ?>">Add Competition</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("products/competition/competition_list") ?>">Competition List</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/9.png" alt="" class="width-20">
                        </i>
                        <span>Visit Module</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">  
                    	<li>
                            <a href="<?php echo base_url("visit/add") ?>">Create Visit</a>
                        </li>                      
                        <li>
                            <a href="<?php echo base_url("visit") ?>">Visit List</a>
                        </li>
						<li>
                            <a href="<?php echo base_url("visit/target") ?>"> Add Targets</a>
                        </li>
						<li>
                            <a href="<?php echo base_url("visit/view_target") ?>"> Views Targets</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/10.png" alt="" class="width-20">
                        </i>
                        <span>Entities Management</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">                        
                        <li>
                            <a href="<?php echo base_url("entities/dosageform/dosageform_list") ?>">Dosage Form List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("entities/dosage/dosage_list") ?>">Dosage List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("entities/speciality/speciality_list") ?>">Speciality List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("entities/classes/class_list") ?>">Class List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("entities/segment/segment_list") ?>">Segment List</a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("entities/workinghour/workinghour_list") ?>">Working Hour List</a>
                        </li>
                    </ul>
                </li>
                <li class="">
                    <a href="javascript:;">
                        <i class="img">
                                <img src="<?php echo base_url(); ?>data/hos-dash/icons/13.png" alt="" class="width-20">
                        </i>
                        <span>Noticeboard</span>
                        <span class="arrow "></span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="<?php echo base_url("noticeboard/notice/form") ?>"><?php echo display('add_notice') ?></a>
                        </li>
                        <li>
                            <a href="<?php echo base_url("noticeboard/notice") ?>"><?php echo display('notice_list') ?></a>
                        </li>
                    </ul>
                </li>

                   
                </ul>

            </div>
            <!-- MAIN MENU - END -->

        </div>
<!--  SIDEBAR - END -->

<!-- START CONTENT -->
        <section id="main-content" class=" ">
            <div class="wrapper main-wrapper row" >

                
                
              
                    <section class="box nobox marginBottom0">
                        <div class="content-body">
                             <!-- alert message -->
								<?php if ($this->session->flashdata('message') != null) { ?>
                                    <div class="alert alert-info alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $this->session->flashdata('message'); ?>
                                    </div>
                                <?php } ?>
                               <div class="alert alert-info alert-dismissable" style="display: none;" id="ajaxDelSucess">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo 'Successfully Deleted'; ?>
                                    </div>    
							
							
                                <?php if ($this->session->flashdata('exception') != null) { ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo $this->session->flashdata('exception'); ?>
                                    </div>
                                <?php } ?>
                    
                                <?php if (validation_errors()) { ?>
                                    <div class="alert alert-danger alert-dismissable">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <?php echo validation_errors(); ?>
                                    </div>
                                <?php } ?>
                    
                    
                                <!-- content -->
                                <?php echo(!empty($content) ? $content : null) ?>
                            <!-- End .row -->
                        </div>
                    </section>
                
                
                <!-- MAIN CONTENT AREA ENDS -->
            </div>
        </section>
        <!-- END CONTENT -->

	<div class="chatapi-windows "></div>
</div>
    
<?php
$furl = base_url(uri_string());
$urlarray=explode("/",$furl);
$lastSegment=$urlarray[count($urlarray)-1];
$SecondlastSegment=$urlarray[count($urlarray)-2];
$ThirdlastSegment=$urlarray[count($urlarray)-3];							

?>
<!-- LOAD FILES AT PAGE END FOR FASTER LOADING -->
    
    <!-- CORE JS FRAMEWORK - START -->
	<?php  if($lastSegment != 'hierarchy' and $SecondlastSegment!= 'hierarchy') { 
	if($lastSegment != 'member' and $SecondlastSegment!= 'member' and $ThirdlastSegment!= 'member') { 
	?>
    <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	
	<?php } 
}?>
    <!--<script src="<?php echo base_url(); ?>assets/js/jquery.easing.min.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--<script src="<?php echo base_url(); ?>assets/plugins/pace/pace.min.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/viewport/viewportchecker.js"></script>
    <!--<script>
        window.jQuery || document.write('<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"><\/script>');
    </script>-->
    <!-- CORE JS FRAMEWORK - END -->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - START -->

<!--    <script src="<?php echo base_url(); ?>assets/plugins/echarts/echarts-custom-for-dashboard.js"></script>

    <script src="<?php echo base_url(); ?>assets/plugins/flot-chart/jquery.flot.js"></script>
    <script src="<?php echo base_url(); ?>assets/plugins/flot-chart/jquery.flot.time.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/chart-flot.js"></script>

    <script src="<?php echo base_url(); ?>assets/js/dashboard-hos.js"></script>-->

    <!-- OTHER SCRIPTS INCLUDED ON THIS PAGE - END -->
	 <?php
	 $current = $this->uri->segment(2);
	if($current == 'home'){
	?>

	 <script src="<?php echo base_url()?>/assets/plugins/echarts/echarts-custom-for-dashboard.js"></script>

    <!--<script src="<?php echo base_url()?>/assets/plugins/flot-chart/jquery.flot.js"></script>
    <script src="<?php echo base_url()?>/assets/plugins/flot-chart/jquery.flot.time.js"></script>
    <script src="<?php echo base_url()?>/assets/js/chart-flot.js"></script>-->

    <!--<script src="<?php echo base_url()?>/assets/js/dashboard-hos.js"></script>-->

    <?  } ?>
    <!-- CORE TEMPLATE JS - START -->
	<?php //if($lastSegment != 'hierarchy') { ?>
    <script src="<?php echo base_url(); ?>assets/js/scripts.js"></script>
	<?php // } ?>
    <!-- END CORE TEMPLATE JS - END -->
</body>
</html>