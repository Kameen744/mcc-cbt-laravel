<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="">
      <div class="sidebar-brand-icon rotate-n-15">
        <i class="fas fa-user"></i>
      </div>
      <div class="sidebar-brand-text mx-3">page<sup></sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
      <a class="nav-link" href=""> Admin
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>user name</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      Department/Courses
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseDepartment" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Manage Department</span>
      </a>
      <div id="collapseDepartment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Department:</h6>
          <a class="collapse-item" href="#" id="addRemoveDept">Add/Remove Departments</a>
          <a class="collapse-item" href="#" id="addRemoveCourses">Add/Remove Courses</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseQuestions" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Manage Questions</span>
      </a>
      <div id="collapseQuestions" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">Questions:</h6>
          <!-- <a class="collapse-item" href="#" id="managePartSectionsTab">Exam Part/Sections</a> -->
          <a class="collapse-item" href="#" id="addSectionQuestionsTab">Add Section Questions</a>
          <a class="collapse-item" href="#" id="addQuestionsTab">Add Exam Questions</a>
        </div>
      </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
      Students / Exams
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseStudents" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-cog"></i>
        <span>Students</span>
      </a>
      <div id="collapseStudents" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <!-- <h6 class="collapse-header">Upload Students</h6> -->
          <a class="collapse-item" href="#" id="addRemoveStuTab">Add / Remove Students</a>
          <a class="collapse-item" href="#" id="printStuPasswordsTab">Print Passwords</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExamResult" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Exam / Result</span>
      </a>
      <div id="collapseExamResult" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"></h6>
          <a class="collapse-item" href="#" id="startStopExam">Start / Stop Exam</a>
          <a class="collapse-item" href="#" id="viewPrintResultTab">View / Print Results</a>
        </div>
      </div>
    </li>
    <!-- Nav Item - Utilities Collapse Menu -->
    <!-- <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseExamResult" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-wrench"></i>
        <span>Recomendation</span>
      </a>
      <div id="collapseExamResult" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header"></h6>
          <a class="collapse-item" href="#" id="recomandationTab">Recomendation</a>
        </div>
      </div>
    </li> -->
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->