@extends('adminlte::master')

@section('adminlte_css')

    <link rel="stylesheet" href="{{ asset('dashboard/plugins/morris/morris.css') }}">

    <style>
      .skin-blue .main-header .logo {
        background-color: #fff;
      }

      .content-page{
        overflow:unset;
      }
    </style>

    @stack('css')
    @yield('css')
@stop


@section('body')
    <div id="wrapper">

        <div class="topbar">

          <!-- LOGO -->
          <div class="topbar-left">
              <a href="{{ route('home') }}" class="logo">
                <!--
                  <span>
                      <img src="{{ asset('dashboard/images/navalha-colorido.png') }}" alt="">
                  </span>
                  <i>
                      <img src="{{ asset('dashboard/images/n-colorido.png') }}" alt="">
                  </i>
                -->
              </a>
          </div>

          <nav class="navbar-custom">

              <ul class="list-unstyled topbar-right-menu float-right mb-0">

                <!--

                  <li class="dropdown notification-list hide-phone">
                      <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                         aria-haspopup="false" aria-expanded="false">
                          <i class="mdi mdi-earth"></i> English  <i class="mdi mdi-chevron-down"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">

                          <a href="javascript:void(0);" class="dropdown-item">
                              Spanish
                          </a>

                          <a href="javascript:void(0);" class="dropdown-item">
                              Italian
                          </a>

                          <a href="javascript:void(0);" class="dropdown-item">
                              French
                          </a>

                          <a href="javascript:void(0);" class="dropdown-item">
                              Russian
                          </a>

                      </div>
                  </li>

                  <li class="dropdown notification-list">
                      <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                         aria-haspopup="false" aria-expanded="false">
                          <i class="mdi mdi-bell noti-icon"></i>
                          <span class="badge badge-danger badge-pill noti-icon-badge">4</span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                          <div class="dropdown-item noti-title">
                              <h6 class="m-0"><span class="float-right"><a href="" class="text-dark"><small>Clear All</small></a> </span>Notification</h6>
                          </div>

                          <div class="slimscroll" style="max-height: 190px;">

                              <a href="javascript:void(0);" class="dropdown-item notify-item">
                                  <div class="notify-icon bg-success"><i class="mdi mdi-comment-account-outline"></i></div>
                                  <p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">1 min ago</small></p>
                              </a>

                              <a href="javascript:void(0);" class="dropdown-item notify-item">
                                  <div class="notify-icon bg-info"><i class="mdi mdi-account-plus"></i></div>
                                  <p class="notify-details">New user registered.<small class="text-muted">5 hours ago</small></p>
                              </a>

                              <a href="javascript:void(0);" class="dropdown-item notify-item">
                                  <div class="notify-icon bg-danger"><i class="mdi mdi-heart"></i></div>
                                  <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">3 days ago</small></p>
                              </a>

                              <a href="javascript:void(0);" class="dropdown-item notify-item">
                                  <div class="notify-icon bg-warning"><i class="mdi mdi-comment-account-outline"></i></div>
                                  <p class="notify-details">Caleb Flakelar commented on Admin<small class="text-muted">4 days ago</small></p>
                              </a>

                              <a href="javascript:void(0);" class="dropdown-item notify-item">
                                  <div class="notify-icon bg-custom"><i class="mdi mdi-heart"></i></div>
                                  <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">13 days ago</small></p>
                              </a>
                          </div>

                          <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                              View all <i class="fi-arrow-right"></i>
                          </a>

                      </div>
                  </li>

                  -->

                  @php

                        $user = \Auth::user();

                  @endphp

                  <li class="dropdown notification-list">
                      <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                         aria-haspopup="false" aria-expanded="false">
                          <img src="{{ route('avatar') }}" alt="user" class="rounded-circle"> <span class="ml-1">{{ $user->name }} <i class="mdi mdi-chevron-down"></i> </span>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="ti-user"></i> <span>Perfil</span>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item">
                              <i class="ti-settings"></i> <span>Configurações</span>
                          </a>

                          <!-- item-->
                          <a href="{{ route('lockscreen') }}" class="dropdown-item notify-item">
                              <i class="ti-lock"></i> <span>Bloquear Tela</span>
                          </a>

                          <!-- item-->
                          <a href="javascript:void(0);" class="dropdown-item notify-item btnLogout">
                              <i class="ti-power-off"></i> <span>{{ trans('adminlte::adminlte.log_out') }}</span>
                          </a>

                          <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                              @if(config('adminlte.logout_method'))
                                  {{ method_field(config('adminlte.logout_method')) }}
                              @endif
                              {{ csrf_field() }}
                          </form>

                      </div>
                  </li>

              </ul>

              <ul class="list-inline menu-left mb-0">
                  <li class="float-left">
                      <button class="button-menu-mobile open-left waves-light waves-effect">
                          <i class="mdi mdi-menu"></i>
                      </button>
                  </li>
                  <li class="hide-phone app-search">
                      <form role="search" class="">
                          <input type="text" placeholder="Pesquisar..." class="form-control">
                          <a href=""><i class="fa fa-search"></i></a>
                      </form>
                  </li>
              </ul>

          </nav>

      </div>

        <div class="left side-menu">
          <div class="user-details">
              <div class="pull-left">
                  <img src="{{ route('avatar') }}" alt="" class="thumb-md rounded-circle">
              </div>
              <div class="user-info">
                  <a href="#">{{ $user->name }}</a>
                  <p class="text-muted m-0">Administrator</p>
              </div>
          </div>

          <!--- Sidemenu -->
          <div id="sidebar-menu">
              <!-- Left Menu Start -->
              <ul class="metismenu" id="side-menu">
                  <li class="menu-title">Navigation</li>
                  <li>
                      <a href="{{ route('home') }}">
                          <i class="ti-home"></i><span> Painel Principal </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('condominio.index') }}">
                          <i class="mdi mdi-home-modern"></i><span> Meu Condominio </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('blocos.index') }}">
                          <i class="mdi mdi-home-modern"></i><span> Blocos </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('financeiro.index') }}">
                          <i class="mdi mdi-bank"></i><span> Gestão Financeira </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('contas.index') }}">
                          <i class="mdi mdi-square-inc-cash"></i><span> Gestão de Contas </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('contatos.index') }}">
                          <i class="mdi mdi-account-multiple"></i><span> Contatos </span>
                      </a>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="mdi mdi-apps"></i> <span> Categorias </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="{{ route('grupos.index') }}">Grupos</a></li>
                          <li><a href="{{ route('categorias.index') }}">Categorias</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="{{ route('orcamentos.index') }}">
                          <i class="mdi mdi-currency-usd"></i><span> Orçamentos </span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('relatorios.index') }}">
                          <i class="mdi mdi-file-excel"></i><span> Relatórios </span>
                      </a>
                  </li>




                  <!--

                  <li>
                      <a href="javascript: void(0);"><i class="ti-light-bulb"></i> <span> Components </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="components-range-slider.html">Range Slider</a></li>
                          <li><a href="components-alerts.html">Alerts</a></li>
                          <li><a href="components-icons.html">Icons</a></li>
                          <li><a href="components-widgets.html">Widgets</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="typography.html">
                          <i class="ti-spray"></i> <span> Typography </span>
                      </a>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="ti-pencil-alt"></i><span> Forms </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="forms-general.html">General Elements</a></li>
                          <li><a href="forms-advanced.html">Advanced Form</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="ti-menu-alt"></i><span> Tables </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="tables-basic.html">Basic tables</a></li>
                          <li><a href="tables-advanced.html">Advanced tables</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="charts.html">
                          <i class="ti-pie-chart"></i><span class="badge badge-custom pull-right">5</span> <span> Charts </span>
                      </a>
                  </li>

                  <li>
                      <a href="maps.html">
                          <i class="ti-location-pin"></i> <span> Maps </span>
                      </a>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="ti-files"></i><span> Pages </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="pages-login.html">Login</a></li>
                          <li><a href="pages-register.html">Register</a></li>
                          <li><a href="pages-forget-password.html">Forget Password</a></li>
                          <li><a href="pages-lock-screen.html">Lock-screen</a></li>
                          <li><a href="pages-blank.html">Blank page</a></li>
                          <li><a href="pages-404.html">Error 404</a></li>
                          <li><a href="pages-confirm-mail.html">Confirm Mail</a></li>
                          <li><a href="pages-session-expired.html">Session Expired</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="ti-widget"></i><span> Extra Pages </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level" aria-expanded="false">
                          <li><a href="extras-timeline.html">Timeline</a></li>
                          <li><a href="extras-invoice.html">Invoice</a></li>
                          <li><a href="extras-profile.html">Profile</a></li>
                          <li><a href="extras-calendar.html">Calendar</a></li>
                          <li><a href="extras-faqs.html">FAQs</a></li>
                          <li><a href="extras-pricing.html">Pricing</a></li>
                          <li><a href="extras-contacts.html">Contacts</a></li>
                      </ul>
                  </li>

                  <li>
                      <a href="javascript: void(0);"><i class="ti-share"></i> <span> Multi Level </span> <span class="menu-arrow"></span></a>
                      <ul class="nav-second-level nav" aria-expanded="false">
                          <li><a href="javascript: void(0);">Level 1.1</a></li>
                          <li><a href="javascript: void(0);" aria-expanded="false">Level 1.2 <span class="menu-arrow"></span></a>
                              <ul class="nav-third-level nav" aria-expanded="false">
                                  <li><a href="javascript: void(0);">Level 2.1</a></li>
                                  <li><a href="javascript: void(0);">Level 2.2</a></li>
                              </ul>
                          </li>
                      </ul>
                  </li>

                -->

              </ul>

          </div>
          <div class="clearfix"></div>

      </div>

        <div class="content-page">

            <div class="content">

              @yield('content_header')

              <div class="container-fluid">

                @include('flash::message')

                @yield('content')

              </div>

              <div class="footer">
                  <div class="pull-right hide-phone">
                      Logado como <strong class="text-custom">{{ \Auth::user()->name }}</strong>.
                  </div>
                  <div>
                      <strong>{{ config('app.name') }}</strong> - Copyright © {{ now()->format('Y') }}
                  </div>
              </div>

            </div>

        </div>

    </div>
@stop

@section('adminlte_js')
    @stack('js')
    @yield('js')

    <script>

    $('.btnLogout').click(function() {

        swal({
          title: 'Finalizar Sessão?',
          text: "Esta sessão será finalizada!",
          type: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim',
          cancelButtonText: 'Cancelar'
          }).then((result) => {
          if (result.value) {

            document.getElementById('logout-form').submit();

            swal({
              title: 'Até logo!',
              text: 'Sua sessão será finalizada.',
              type: 'success',
              showConfirmButton: false,
            })
          }
        });

      });

    </script>
@stop
