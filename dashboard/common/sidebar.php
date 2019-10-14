 <!-- Left side column. contains the logo and sidebar //style="position: fixed;" -->
  <aside class="main-sidebar" >
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image" id="userImgFileName">
        <!--   <img src="../common/img/user.jpg" class="img-circle" alt="User Image"> -->
        </div>
        <div class="pull-left info">
          <p id="sidebarUserName"></p>
          <small id="sidebarUserDes"></small>
          <!-- <a href="../logout.php">Logout <i class="fa fa-sign-out"></i></a>  -->
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree" id="myUL">
       <!--  <li class="header">MAIN NAVIGATION</li> -->
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>Dashboard</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../overview" id="report"><i class="fa fa-line-chart"></i> Overview</a></li>
          <li><a href="../analytics" id="report"><i class="fa fa-line-chart"></i> Dashboard</a></li>
          <li><a href="../jobcard/index.php" id="menuJobCardScreen"><i class="fa fa-qrcode"></i> JobCard</a></li>
          <li><a href="../logout.php" id="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
          </ul>
        </li>


        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="../department" id="machine_jobcard"><i class="fa fa-list-alt"></i>Department</a> </li>
            <li><a href="../machine_report" id="machine_jobcard"><i class="fa fa-list-alt"></i>Machine-Jobcards</a> </li>
            <li><a href="../ageing" id="ageing"><i class="fa fa-list-alt"></i>Ageing Report</a></li>  
            <li><a href="../jobcard_status" id="jobcard_status"><i class="fa fa-list-alt"></i>Jobcard Status</a></li>
            <li><a href="../operator_report" id="operator_report"><i class="fa fa-list-alt"></i>Operator</a></li> 
            <li><a href="../operator_efficiency" id="operator_efficiency"><i class="fa fa-list-alt"></i>Operator Efficiency</a></li>    
          </ul>
         </li> 

         <li class="treeview">
          <a href="#">
            <i class="fa fa-window-close-o"></i> <span>Rejection Analysis</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../yearly_rejections" id="monthlyrejection"><i class="fa fa-list-alt"></i>Yearly Rejection</a> </li>
          <li><a href="../rejection_analysis" id="monthlyrejection"><i class="fa fa-list-alt"></i>Monthly Rejection</a> </li>
          <li><a href="../report" id="report"><i class="fa fa-list-alt"></i>Jobcard Rejection </a> </li>
          <li><a href="../jobcard_reject" id="JobCard_rej"><i class="fa fa-list-alt"></i>Reject Reasons</a> </li>
          </ul>
        </li>



         <li class="treeview">
          <a href="#">
            <i class="fa fa-dashboard"></i> <span>Production</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../production_dashboard" id="view_dashboard"><i class="fa fa-list-alt"></i>Dashboard</a> </li>
          <li><a href="../datasheet" id="data_sheet"><i class="fa fa-list-alt"></i>Data Sheet</a> </li>
          <li><a href="../production_status" id="production_status"><i class="fa fa-list-alt"></i>Production Status</a> </li>
          <li><a href="../reason_report" id="reason_report"><i class="fa fa-list-alt"></i>Reason Report</a> </li>
          </ul>
         </li> 


         <li class="treeview">
          <a href="#">
            <i class="fa fa-list"></i> <span>Checklist Approval</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../checklist" id="view_dashboard"><i class="fa fa-list-alt"></i>Checklists</a> </li>

          </ul>
         </li> 

         <li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Employee</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../employee/emp_list.php" id="view_dashboard"><i class="fa fa-list-alt"></i>Employee List</a> </li>
          <li><a href="../employee/emp_qrcode.php" id="data_sheet"><i class="fa fa-qrcode"></i>Employee QR-Code</a> </li>
          </ul>
         </li> 

         <li class="treeview">
          <a href="#">
            <i class="fa fa-qrcode"></i> <span>Label Printing</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../final_printing" id="final_printing"><i class="fa fa-qrcode"></i>Printing</a> </li>
          </ul>
         </li> 

         <li class="treeview">
          <a href="#">
            <i class="fa fa-line-chart"></i> <span>OEE</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li><a href="../oee/" id="oee-dashboard"><i class="fa fa-line-chart"></i>Dashboard</a> </li>
          <li><a href="../oee/oee_history.php" id="oee_history"><i class="fa fa-history"></i>History</a> </li>
          </ul>
         </li> 


       
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


<script>

    /** add active class and stay opened when selected */
    var url = window.location;
    // for sidebar menu entirely but not cover treeview
    $('ul.sidebar-menu a').filter(function() {
       return this.href == url;
    }).parent().addClass('active');

    // for treeview
    $('ul.treeview-menu a').filter(function() {
       return this.href == url;
    }).parentsUntil(".sidebar-menu > .treeview-menu").addClass('active');


    /* Search Menus*/
    $('#myInput').keyup( function() {
        var matches = $( 'ul#myUL' ).find( 'li:contains('+ $( this ).val() +') ' );
        $( 'li', 'ul#myUL' ).not( matches ).slideUp();
        matches.slideDown();    
    });

</script>
