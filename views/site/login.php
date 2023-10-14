<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */

/* @var $model app\forms\LoginForm */

use yii\bootstrap4\ActiveForm;
use yii\helpers\Html;


?>



<section class="login-content">
	<div class="row m-0 align-items-center bg-white vh-100">
		<div class="col-md-6">
			<div class="row justify-content-center">
				<div class="col-md-10">
					<div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
						<div class="card-body">
							<a href="../../dashboard/index.html" class="navbar-brand d-flex align-items-center mb-3">
								<!--Logo start-->
								<svg width="30" class="" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
									<rect x="-0.757324" y="19.2427" width="28" height="4" rx="2" transform="rotate(-45 -0.757324 19.2427)" fill="currentColor"></rect>
									<rect x="7.72803" y="27.728" width="28" height="4" rx="2" transform="rotate(-45 7.72803 27.728)" fill="currentColor"></rect>
									<rect x="10.5366" y="16.3945" width="16" height="4" rx="2" transform="rotate(45 10.5366 16.3945)" fill="currentColor"></rect>
									<rect x="10.5562" y="-0.556152" width="28" height="4" rx="2" transform="rotate(45 10.5562 -0.556152)" fill="currentColor"></rect>
								</svg>
								<!--logo End-->
								<h4 class="logo-title ms-3"> Admin Login</h4>
							</a>
							<h2 class="mb-2 text-center">Sign In</h2>
							<p class="text-center">Login to stay connected.</p>
							<?php $form = ActiveForm::begin([
								'id' => 'login-form',
							]); ?>

							<div class="row">
								<div class="col-lg-12">
									<div class="form-group">
										<?= $form->field($model, 'username')->textInput(['autofocus' => true, 'class' => 'form-control']) ?>
									</div>
								</div>
								<div class="col-lg-12">
									<div class="form-group">
										<?= $form->field($model, 'password')->passwordInput(['class' => 'form-control']) ?>
									</div>
								</div>
							
							</div>
							<div class="d-flex justify-content-center">

								<div class="form-group">
									<?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
								</div>
							</div>
							<?php ActiveForm::end(); ?>


							
							
						</div>
					</div>
				</div>
			</div>
			<div class="sign-bg">
				<svg width="280" height="230" viewBox="0 0 431 398" fill="none" xmlns="http://www.w3.org/2000/svg">
					<g opacity="0.05">
						<rect x="-157.085" y="193.773" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 -157.085 193.773)" fill="#3B8AFF"></rect>
						<rect x="7.46875" y="358.327" width="543" height="77.5714" rx="38.7857" transform="rotate(-45 7.46875 358.327)" fill="#3B8AFF"></rect>
						<rect x="61.9355" y="138.545" width="310.286" height="77.5714" rx="38.7857" transform="rotate(45 61.9355 138.545)" fill="#3B8AFF"></rect>
						<rect x="62.3154" y="-190.173" width="543" height="77.5714" rx="38.7857" transform="rotate(45 62.3154 -190.173)" fill="#3B8AFF"></rect>
					</g>
				</svg>
			</div>
		</div>
		<div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
			<img src="https://ik.imagekit.io/asbgbgese/01.png?ik-sdk-version=javascript-1.4.3&updatedAt=1672751823105" class="img-fluid gradient-main animated-scaleX" alt="images">
		</div>
	</div>
</section>