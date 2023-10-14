<?php

use yii\helpers\Html;
use yii\bootstrap4\Nav;
use app\modules\admin\widgets\Menu;
use yii\helpers\Url;

?>
<script src="https://templates.iqonic.design/hope-ui/html/dist/assets/js/core/libs.min.js"></script>
<style>

</style>

<aside class="sidebar sidebar-default navs-rounded-all ">
	<div class="sidebar-header d-flex align-items-center justify-content-start">
		<a href="../dashboard/index.html" class="navbar-brand" style="    display: block;
    margin: auto;">
			<!--Logo start-->
			<img src="https://ik.imagekit.io/tcz2d20pj/_E-Go-logo-3-white-final-2_1_.png?ik-sdk-version=javascript-1.4.3&updatedAt=1673071903649" alt="" class="img-fluid" style="width: 79px;">
			<!--logo End-->
		</a>
		<div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
			<i class="icon">
				<svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M4.25 12.2744L19.25 12.2744" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
					<path d="M10.2998 18.2988L4.2498 12.2748L10.2998 6.24976" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
				</svg>
			</i>
		</div>
	</div>

	<div class="sidebar-body pt-0 data-scrollbar">
		<div class="sidebar-list">
			<!-- Sidebar Menu Start -->
			<ul class="navbar-nav iq-main-menu" id="sidebar-menu">
				<li class="nav-item static-item">
					<a class="nav-link static-item disabled" href="#" tabindex="-1">
						<span class="default-icon">Home</span>
						<span class="mini-icon">-</span>
					</a>
				</li>
				<li class="nav-item">



					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/dashboard') ?>">
						<i class="icon">
							<svg width="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path opacity="0.4" d="M16.0756 2H19.4616C20.8639 2 22.0001 3.14585 22.0001 4.55996V7.97452C22.0001 9.38864 20.8639 10.5345 19.4616 10.5345H16.0756C14.6734 10.5345 13.5371 9.38864 13.5371 7.97452V4.55996C13.5371 3.14585 14.6734 2 16.0756 2Z" fill="currentColor"></path>
								<path fill-rule="evenodd" clip-rule="evenodd" d="M4.53852 2H7.92449C9.32676 2 10.463 3.14585 10.463 4.55996V7.97452C10.463 9.38864 9.32676 10.5345 7.92449 10.5345H4.53852C3.13626 10.5345 2 9.38864 2 7.97452V4.55996C2 3.14585 3.13626 2 4.53852 2ZM4.53852 13.4655H7.92449C9.32676 13.4655 10.463 14.6114 10.463 16.0255V19.44C10.463 20.8532 9.32676 22 7.92449 22H4.53852C3.13626 22 2 20.8532 2 19.44V16.0255C2 14.6114 3.13626 13.4655 4.53852 13.4655ZM19.4615 13.4655H16.0755C14.6732 13.4655 13.537 14.6114 13.537 16.0255V19.44C13.537 20.8532 14.6732 22 16.0755 22H19.4615C20.8637 22 22 20.8532 22 19.44V16.0255C22 14.6114 20.8637 13.4655 19.4615 13.4655Z" fill="currentColor"></path>
							</svg>
						</i>
						<span class="item-name">Dashboard</span>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#websettings-menu" role="button" aria-expanded="false" aria-controls="websettings-menu">
						<i class="icon">

							<i class="fa fa-cog"></i>
						</i>
						<span class="item-name">Web Settings</span>
						<i class="right-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</i>
					</a>
					<ul class="sub-nav collapse" id="websettings-menu" data-bs-parent="#websettings-menu">
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/web-setting/cms') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-motorcycle"></i> </i>
								<span class="item-name">Web Settings</span>
							</a>
						</li>
						<!-- <li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/web-setting/dispatch') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fa fa-user"></i> </i>
								<span class="item-name">Skipper Assign Panel </span>
							</a>
						</li> -->





					</ul>


				</li>

				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#horizontal-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
						<i class="icon">

							<i class="fa fa-users"></i>
						</i>
						<span class="item-name">Users Management</span>
						<i class="right-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</i>
					</a>
					<ul class="sub-nav collapse" id="horizontal-menu" data-bs-parent="#sidebar-menu">
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/users/create') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-motorcycle"></i> </i>
								<span class="item-name">Create Admin</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/users') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fa fa-user"></i> </i>
								<span class="item-name"> Users </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/users/referer-list') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fa fa-user"></i> </i>
								<span class="item-name"> Referral Lists </span>
							</a>
						</li>
					</ul>


				</li>

				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#zones-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
						<i class="icon">

							<i class="fas fa-map-pin"></i>
						</i>
						<span class="item-name">Zones,Vehicles & Fares</span>
						<i class="right-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</i>
					</a>
					<ul class="sub-nav collapse" id="zones-menu" data-bs-parent="#sidebar-menu">
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/vehicals') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> Vehicles </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/city') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> City </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/pincode') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Pincode</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-commision') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Update Ride Commision</span>
							</a>
						</li>


					</ul>
				</li>

				<li class="nav-item">



					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/driver-details') ?>">
						<i class="icon">
							<i class="fas fa-motorcycle"></i>
						</i>
						<span class="item-name">Skipper Details</span>
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#rides" role="button" aria-expanded="false" aria-controls="horizontal-menu">
						<i class="icon">

							<i class="fas fa-biking"></i>
						</i>
						<span class="item-name">Rides</span>
						<i class="right-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</i>
					</a>
					<ul class="sub-nav collapse" id="rides" data-bs-parent="#sidebar-menu">
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-request') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> All Rides </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-request/new-rides') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> New Rides </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-request/on-going-rides') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">On Going Rides</span>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-request/completed-rides') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Completed Rides</span>
							</a>
						</li>

					</ul>
				</li>

				<li class="nav-item">
					<a class="nav-link" data-bs-toggle="collapse" href="#earnings-menu" role="button" aria-expanded="false" aria-controls="horizontal-menu">
						<i class="icon">

							<i class="fas fa-money-bill"></i>
						</i>
						<span class="item-name">Earning Management</span>
						<i class="right-icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="18" fill="none" viewBox="0 0 24 24" stroke="currentColor">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
							</svg>
						</i>
					</a>
					<ul class="sub-nav collapse" id="earnings-menu" data-bs-parent="#sidebar-menu">
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-earnings') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> Ride Earnings </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/skipper-payout/pending-withdraw-request') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name"> Pending Withdraw <br> Request </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/skipper-payout/approved-withdraw-request') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Approved Withdraw <br> Requests</span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/users/skipper-amount') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Skipper <br> Amounts</span>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/skipper-payout') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Skipper <br> Payouts</span>
							</a>
						</li>

						<li class="nav-item">
							<a class="nav-link " href="<?= Url::toRoute('/admin/ride-earnings/manual-payout') ?>">
								<i class="icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="10" viewBox="0 0 24 24" fill="currentColor">
										<g>
											<circle cx="12" cy="12" r="8" fill="currentColor"></circle>
										</g>
									</svg>
								</i>
								<i class="sidenav-mini-icon"> <i class="fas fa-city"></i> </i>
								<span class="item-name">Manual <br> Payout</span>
							</a>
						</li>
					</ul>
				</li>



				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/coupon') ?>">
						<i class="icon">
							<i class="fas fa-biking"></i>
						</i>
						<span class="item-name">Coupons</span>
					</a>
				</li>



				<li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/wallet') ?>">
						<i class="icon">
							<i class="fas fa-wallet"></i>
						</i>
						<span class="item-name">Wallet</span>
					</a>
				</li>





				<!-- <li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/ride-earnings') ?>">
						<i class="icon">
							<i class="fas fa-rupee-sign"></i>
						</i>
						<span class="item-name">Ride Earning</span>
					</a>
				</li> -->

				<!-- <li class="nav-item">
					<a class="nav-link" aria-current="page" href="<?= Url::toRoute('/admin/users/live-tracking') ?>">
						<i class="icon">
							<i class="fas fa-motorcycle"></i>
						</i>
						<span class="item-name">Live Tracking</span>
					</a>
				</li> -->




				</li>

			</ul>
			<!-- Sidebar Menu End -->
		</div>
	</div>
	<div class="sidebar-footer"></div>
</aside>
<!-- Main Sidebar Container -->