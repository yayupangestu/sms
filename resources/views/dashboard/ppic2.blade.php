@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="aset/dist/assets/css/style.css">
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">Dashboard</h1>
      </div>
      <div class="col-sm-6">
        
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">

        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#0e07d5"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#0099ff"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#0099ff"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#0099ff"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#0099ff"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
        <div class="col-md-9 col-xl-4" style="background-color: #808080">
            <div class="card flat-card" style="background-color: #e6e6e6">
                <div class="row-table">
                  <div class="col-sm-4 card-body br">
                    <div class="row">
                        <div class="col-sm-2">
                                <i  class="icon feather icon-grid text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                {{-- <h4 id="stroke_b3">0</h4> --}}
                                <b><span style="font-size: 100%" id="stroke_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">Stroke</span></b>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body br">
                      <div class="row">
                          <div class="col-sm-2">
                            <i class="icon feather icon-map text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                                <b><span style="font-size: 100%" id="plan_b3">0</span></b>
                                <br>
                                <b><span style="font-size: 100%">PLANNNING</span></b>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row-table">
                    <div class="col-sm-4 card-body br">
                        <div class="row">
                            <div class="col-sm-2">
                                <i class="icon feather icon-package text-c-green mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="gsph_b3">0</span></b>
                              <br>
                              <b><span style="font-size: 100%">GSPH</span></b>
                          </div>
                        </div>
                    </div>
                    <div class="col-sm-4 card-body">
                        <div class="row">
                            <div class="col-sm-2">
                              <i class="icon feather icon-clock text-c-yellow mb-0 d-block"></i>
                            </div>
                            <div class="col-sm-9 text-md-center">
                              <b><span style="font-size: 100%" id="uptime_b3">00:00</span></b>
                              <br>
                              <b><span style="font-size: 100%">UPTIME</span></b>
                          </div>
                        </div>
                    </div> 
                </div>
                 <!-- widget primary card start -->
            <div class="card flat-card widget-purple-card" style="background-color: rgb(143, 223, 220)">
              <div class="row-table">
                <div class="col-sm-3 card-body; btn btn-sm-4"id="btn_add" style="background-color: rgb(209, 209, 209)">
                  <B><span style="font-size: 100%; color:rgb(0, 0, 0)">B3</span></B>
               </div>
                  <div class="col-sm-10">
                    <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="partno_b3">Part</span>
                    <br>
                      <span style="font-family: 'Times New Roman', Times, serif; color:rgb(0, 0, 0); font-size:100%" id="variant_b3" >0</span>
                  </div>
               </div>   
            </div>
            <div class="col-lg-12 col-md-10">
                <div class="card bg-lightblue">
                    <div class="card-header border-light">
                        <!--  -->
                        <div class="media">
                            <div class="media-body" class="bg-dark; text-center ">
                                <i class="fab fa-laravel fa-2x"></i>
                                <strong class="h5">LINE B3</strong>
                                <span class="bg-dark float-left"></span>
                            </div>
                          <b><span style="font-family: 'Times New Roman', Times, serif; font-size:120%">SHIFT - 1</span></b>
                        </div>
                        <!--  -->
                    </div>
                    <div class="card-body text-sm" style="margin-top:-20px;margin-bottom:-15px" >
                        <div class="container-fluid">
                            <div class="d-flex justify-content-between text-bold">
                                <span class="text-center" style="color: #ffffff">JOB NO </span>
                                <span class="text-center" style="color: #ffffff">PLAN</span>
                                <span class="text-center" style="color:#ffffff">ACTUAL</span>
                                <span class="text-center" style="color: #ffffff">STATUS</span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                                <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#1aff00"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                              <b><span style="color: #ffffff">Not-ready</span></b> 
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                              <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                          </div>
                          <div class="d-flex justify-content-between">
                            <b><span style="color: #ffffff">Not-ready</span></b> 
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                            <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#eeff00"></span>
                        </div>
                        <div class="d-flex justify-content-between">
                          <b><span style="color: #ffffff">Not-ready</span></b> 
                          <b><span class="target_a1"  style="color: #ffffff">0</span></b>
                          <b><span class="target_a1"  style="color: #ffffff">0</span> </b>
                          <span class="fa fa-square fa-2x align-self-center silver_t" style="color:#ffffff"></span>
                      </div>
                            <div class="d-flex justify-content-center">
                                <span class="text-sm text-bold ket_t"></span>
                            </div>
                        </div>
                    </div>
                  </a>
                </div>
              </div>
            </div>
        </div>
    </div>
  </div>
</section>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
           // getLinec1();
   
           setInterval(() => {
               getLineb3()
           }, 1000);
       }); 
   
   
   
     function getLineb3(){
         const d = new Date();
         let waktuSelesai = d.getHours()+":"+d.getMinutes()+":"+d.getSeconds();
         let waktuMulai = "06:30:00";
         hours = waktuSelesai.split(':')[0] - waktuMulai.split(':')[0],
         minutes = waktuSelesai.split(':')[1] - waktuMulai.split(':')[1];
         second = waktuSelesai.split(':')[2] - waktuMulai.split(':')[2];
         if (waktuMulai <= "12:00:00" && waktuSelesai >= "13:00:00"){
             a = 1;
         }else {
             a = 0;
         }
         minutes = minutes.toString().length<2?'0'+minutes:minutes;
         if(minutes<0){
             hours--;
             minutes = 60 + minutes;
         }
         hours = hours.toString().length<2?'0'+hours:hours; 
         if(second.toString().length < 2){
             second = '0'+second;
         }
         let time = hours-a+ ':' + minutes + ':' + second;
         $.ajax({
             type: 'GET',
             url: "{{route('dashboard2.lineb3')}}",
             success: function(result) {
                 let jam = hours-a;
                 var fix_jam = '';
                 if(jam == '00'){
                     fix_jam = 1;
                 }else{
                     fix_jam = jam;
                 }
                 if((result.strokeb3 / fix_jam) < 1){
                     var gsph = result.strokeb3;
                 }else{
                     var gsph = result.strokeb3 / fix_jam;
                 }
                 $("#stroke_b3").text(result.strokeb3);
                 $("#partno_b3").text(result.model);
                 $("#variant_b3").text(result.variant);
                 $("#plan_b3").text(result.planb3);
                 $("#uptime_b3").text(time);
                 $("#gsph_b3").text(Math.round(gsph));
             }
         });
     } 
   
   </script>
@endsection
