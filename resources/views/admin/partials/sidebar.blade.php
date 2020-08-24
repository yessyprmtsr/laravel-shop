<aside class="left-sidebar bg-sidebar">
    <div id="sidebar" class="sidebar sidebar-with-footer">
      <!-- Aplication Brand -->
      <div class="app-brand">
        <a href="/index.html" title="Sleek Dashboard">
          <svg
            class="brand-icon"
            xmlns="http://www.w3.org/2000/svg"
            preserveAspectRatio="xMidYMid"
            width="30"
            height="33"
            viewBox="0 0 30 33"
          >
            <g fill="none" fill-rule="evenodd">
              <path
                class="logo-fill-blue"
                fill="#7DBCFF"
                d="M0 4v25l8 4V0zM22 4v25l8 4V0z"
              />
              <path class="logo-fill-white" fill="#FFF" d="M11 4v25l8 4V0z" />
            </g>
          </svg>
          <span class="brand-name text-truncate">Sleek Dashboard</span>
        </a>
      </div>
      <!-- begin sidebar scrollbar -->
      <div class="sidebar-scrollbar">

        <!-- sidebar menu -->
        <ul class="nav sidebar-inner" id="sidebar-menu">



            <li  class="has-sub active expand" >
                <a class="sidenav-item-link" href="{{ route('admin.dashboard')}}">
                <i class="mdi mdi-view-dashboard-outline"></i>
                <span class="nav-text">Dashboard</span> <b class="caret"></b>
              </a>
            </li>


            <li  class="has-sub" >
            <a class="sidenav-item-link" href="{{ route('categories.index')}}">
                <i class="mdi mdi-folder-multiple-outline"></i>
                <span class="nav-text">Categories</span> <b class="caret"></b>
              </a>
            </li>

            <li  class="has-sub" >
                <a class="sidenav-item-link" href="{{ route('products.index')}}">
                <i class="mdi mdi-diamond-stone"></i>
                <span class="nav-text">Products</span> <b class="caret"></b>
              </a>
            </li>

            <li  class="has-sub" >
                <a class="sidenav-item-link" href="{{ route('attributes.index')}}">
                <i class="mdi mdi-email-mark-as-unread"></i>
                <span class="nav-text">Attributes</span> <b class="caret"></b>
              </a>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#tables"
                aria-expanded="false" aria-controls="tables">
                <i class="mdi mdi-table"></i>
                <span class="nav-text">User and Roles</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="tables"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li >
                        <a class="sidenav-item-link" href="basic-tables.html">
                          <span class="nav-text">User</span>

                        </a>
                      </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#data-tables"
                      aria-ex panded="false" aria-controls="data-tables">
                      <span class="nav-text">Roles</span> <b class="caret"></b>
                    </a>

                  </li>



                </div>
              </ul>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#maps"
                aria-expanded="false" aria-controls="maps">
                <i class="mdi mdi-google-maps"></i>
                <span class="nav-text">Maps</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="maps"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li >
                        <a class="sidenav-item-link" href="google-map.html">
                          <span class="nav-text">Google Map</span>

                        </a>
                      </li>






                      <li >
                        <a class="sidenav-item-link" href="vector-map.html">
                          <span class="nav-text">Vector Map</span>

                        </a>
                      </li>




                </div>
              </ul>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#widgets"
                aria-expanded="false" aria-controls="widgets">
                <i class="mdi mdi-widgets"></i>
                <span class="nav-text">Widgets</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="widgets"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li >
                        <a class="sidenav-item-link" href="general-widget.html">
                          <span class="nav-text">General Widget</span>

                        </a>
                      </li>






                      <li >
                        <a class="sidenav-item-link" href="chart-widget.html">
                          <span class="nav-text">Chart Widget</span>

                        </a>
                      </li>




                </div>
              </ul>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#charts"
                aria-expanded="false" aria-controls="charts">
                <i class="mdi mdi-chart-pie"></i>
                <span class="nav-text">Charts</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="charts"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li >
                        <a class="sidenav-item-link" href="chartjs.html">
                          <span class="nav-text">ChartJS</span>

                        </a>
                      </li>




                </div>
              </ul>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#pages"
                aria-expanded="false" aria-controls="pages">
                <i class="mdi mdi-image-filter-none"></i>
                <span class="nav-text">Pages</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="pages"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li >
                        <a class="sidenav-item-link" href="user-profile.html">
                          <span class="nav-text">User Profile</span>

                        </a>
                      </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#authentication"
                      aria-expanded="false" aria-controls="authentication">
                      <span class="nav-text">Authentication</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="authentication">
                      <div class="sub-menu">

                        <li >
                          <a href="sign-in.html">Sign In</a>
                        </li>

                        <li >
                          <a href="sign-up.html">Sign Up</a>
                        </li>

                      </div>
                    </ul>
                  </li>




                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#others"
                      aria-expanded="false" aria-controls="others">
                      <span class="nav-text">Others</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="others">
                      <div class="sub-menu">

                        <li >
                          <a href="invoice.html">Invoice</a>
                        </li>

                        <li >
                          <a href="404.html">404 Page</a>
                        </li>

                      </div>
                    </ul>
                  </li>



                </div>
              </ul>
            </li>





            <li  class="has-sub" >
              <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#documentation"
                aria-expanded="false" aria-controls="documentation">
                <i class="mdi mdi-book-open-page-variant"></i>
                <span class="nav-text">Documentation</span> <b class="caret"></b>
              </a>
              <ul  class="collapse"  id="documentation"
                data-parent="#sidebar-menu">
                <div class="sub-menu">



                      <li class="section-title">
                        Getting Started
                      </li>






                      <li >
                        <a class="sidenav-item-link" href="introduction.html">
                          <span class="nav-text">Introduction</span>

                        </a>
                      </li>






                      <li >
                        <a class="sidenav-item-link" href="quick-start.html">
                          <span class="nav-text">Quick Start</span>

                        </a>
                      </li>






                      <li >
                        <a class="sidenav-item-link" href="customization.html">
                          <span class="nav-text">Customization</span>

                        </a>
                      </li>






                      <li class="section-title">
                        Layouts
                      </li>





                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#headers"
                      aria-expanded="false" aria-controls="headers">
                      <span class="nav-text">Header Variations</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="headers">
                      <div class="sub-menu">

                        <li >
                          <a href="header-fixed.html">Header Fixed</a>
                        </li>

                        <li >
                          <a href="header-static.html">Header Static</a>
                        </li>

                        <li >
                          <a href="header-light.html">Header Light</a>
                        </li>

                        <li >
                          <a href="header-dark.html">Header Dark</a>
                        </li>

                      </div>
                    </ul>
                  </li>




                  <li  class="has-sub" >
                    <a class="sidenav-item-link" href="javascript:void(0)" data-toggle="collapse" data-target="#sidebar-navs"
                      aria-expanded="false" aria-controls="sidebar-navs">
                      <span class="nav-text">Sidebar Variations</span> <b class="caret"></b>
                    </a>
                    <ul  class="collapse"  id="sidebar-navs">
                      <div class="sub-menu">

                        <li >
                          <a href="sidebar-fixed-default.html">Sidebar Fixed Default</a>
                        </li>

                        <li >
                          <a href="sidebar-fixed-minified.html">Sidebar Fixed Minified</a>
                        </li>

                        <li >
                          <a href="sidebar-fixed-offcanvas.html">Sidebar Fixed Offcanvas</a>
                        </li>

                        <li >
                          <a href="sidebar-static-default.html">Sidebar Static Default</a>
                        </li>

                        <li >
                          <a href="sidebar-static-minified.html">Sidebar Static Minified</a>
                        </li>

                        <li >
                          <a href="sidebar-static-offcanvas.html">Sidebar Static Offcanvas</a>
                        </li>

                        <li >
                          <a href="sidebar-with-footer.html">Sidebar With Footer</a>
                        </li>

                        <li >
                          <a href="sidebar-without-footer.html">Sidebar Without Footer</a>
                        </li>

                        <li >
                          <a href="right-sidebar.html">Right Sidebar</a>
                        </li>

                      </div>
                    </ul>
                  </li>





                      <li >
                        <a class="sidenav-item-link" href="rtl.html">
                          <span class="nav-text">RTL Direction</span>

                        </a>
                      </li>




                </div>
              </ul>
            </li>



        </ul>

      </div>

      <div class="sidebar-footer">
        <hr class="separator mb-0" />
        <div class="sidebar-footer-content">
          <h6 class="text-uppercase">
            Cpu Uses <span class="float-right">40%</span>
          </h6>
          <div class="progress progress-xs">
            <div
              class="progress-bar active"
              style="width: 40%;"
              role="progressbar"
            ></div>
          </div>
          <h6 class="text-uppercase">
            Memory Uses <span class="float-right">65%</span>
          </h6>
          <div class="progress progress-xs">
            <div
              class="progress-bar progress-bar-warning"
              style="width: 65%;"
              role="progressbar"
            ></div>
          </div>
        </div>
      </div>
    </div>
  </aside>
