<!--
=====================================================
	Contact Section
=====================================================
-->
<div id="contact-section">
	<div class="container">
		<div class="clear-fix contact-address-content">
			<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
				<div class="left-side">
					<h2>İletişim Bilgileri</h2>
					<?php 
						if(!empty($Get_ContactInfo["comment"])){
							echo '
							<p>'.$Get_ContactInfo["comment"].'</p>
							';
						}
					?>
					<ul>
					<?php
						// Address
						if(!empty($Get_ContactInfo["address"])){
							echo '
							<li>
								<a href="https://maps.google.com/?q=:'.$Get_ContactInfo["address"].'" target="_blank">
									<div class="icon tran3s round-border p-color-bg">
										<i class="fa fa-map-marker" aria-hidden="true"></i>
									</div>
									<h6>Adres</h6>
									<p>'.$Get_ContactInfo["address"].'</p>
								</a>
							</li>
							';
						}
						// Phone
						if(!empty($Get_ContactInfo["phone"])){
							echo '
							<li>
								<a href="tel:'.$Get_ContactInfo["phone"].'">
									<div class="icon tran3s round-border p-color-bg">
										<i class="fa fa-phone" aria-hidden="true"></i>
									</div>
									<h6>Telefon</h6>
									<p>'.$Get_ContactInfo["phone"].'</p>
								</a>
							</li>
							';
						}
						// Email
						if(!empty($Get_ContactInfo["email"])){
							echo '
							<li>
								<a href="mailto:'.$Get_ContactInfo["email"].'">
									<div class="icon tran3s round-border p-color-bg">
										<i class="fa fa-envelope-o" aria-hidden="true"></i>
									</div>
									<h6>E-posta</h6>
									<p>'.$Get_ContactInfo["email"].'</p>
								</a>
							</li>
							';
						}
					?>
					</ul>
				</div>
			</div>
			<?php
				// Map
				if(!empty($Get_ContactInfo["map"])){
					echo '
					<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
						<div class="map-area">
							<h2>Konumumuz</h2>
							'.$Get_ContactInfo["map"].'
							</div>
					</div>
					';
				}
			?>
		</div>

		<!-- Contact Form -->
		<section class="get-in-touch">
		   <h1 class="title">İletişim Formu</h1>
		   <form class="contact-form row" action="javascript:void(0);" id="contactForm">
		      <div class="form-field col x-50">
		         <input id="name" class="input-text js-input" type="text" required>
		         <label class="label" for="name">İsim</label>
		      </div>
		      <div class="form-field col x-50">
		         <input id="email" class="input-text js-input" type="email" required>
		         <label class="label" for="email">E-Posta</label>
		      </div>
			  <div class="form-field col x-50">
		         <input id="subject" class="input-text js-input" type="text" required>
		         <label class="label" for="subject">Konu</label>
		      </div>
		      <div class="form-field col x-100">
		         <input id="message" class="input-text js-input" type="text" required>
		         <label class="label" for="message">Mesaj</label>
		      </div>
		      <div class="form-field col x-100 align-center">
		         <input class="submit-btn" type="submit" value="Submit" onClick="SendMail();">
		      </div>
		   </form>
		</section>
	</div>
</div>