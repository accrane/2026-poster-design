<?php
/**
 * The front page: hero + homepage sections.
 * Copy is static for now; ACF fields get wired in as directed.
 *
 * @package bellaworks
 */

get_header();
$dir = get_template_directory_uri();
?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<!-- HERO -->
		<section id="hero" class="section section--tan hero">
			<?php bellaworks_watermark( 'halftone', 'brown', 0.12, 'left: -120px; bottom: -140px; width: 460px; height: 460px;' ); ?>
			<div class="wrapper hero__grid">
				<div class="hero__copy">
					<div class="hero__eyebrow">
						<?php bellaworks_star( 18, 'red' ); ?>
						<span class="label">Charlotte, North Carolina</span>
					</div>
					<div>
						<h1 class="display hero__title"><span class="hero-l1">We make</span><span class="hero-l2">websites.</span></h1>
						<div class="script hero__script hero-simple">Simple.</div>
					</div>
					<div class="hero__actions">
						<?php bellaworks_button( 'Book A Call', home_url( '/contact-us/' ), 'brown' ); ?>
					</div>
				</div>
				<div class="hero__art-col">
					<div class="hero__art retro-object retro-object--rolodex">
						<?php bellaworks_retro_info( 'This is what used to be known as a Rolodex.', 'rolodex' ); ?>
						<video id="heroVideo" class="hero__video" muted playsinline preload="auto" width="560" height="560">
							<source src="<?php echo esc_url( $dir . '/assets/video/hero-rolodex-alpha.webm' ); ?>" type="video/webm; codecs=vp9">
							<source src="<?php echo esc_url( $dir . '/assets/video/hero-rolodex-tan.mp4' ); ?>" type="video/mp4">
						</video>
					</div>
				</div>
			</div>
			<div class="label hero__vertical">Simple • Beautiful • Secure</div>
		</section>

		<!-- TAGLINE BAND -->
		<section class="section section--red band">
			<?php bellaworks_watermark( 'star', 'tan', 0.16, 'left: -150px; top: -150px; width: 560px; height: 560px; transform: rotate(-14deg);' ); ?>
			<?php bellaworks_watermark( 'star', 'tan', 0.12, 'right: -90px; bottom: -110px; width: 300px; height: 300px; transform: rotate(18deg);' ); ?>
			<div class="wrapper band__inner">
				<?php bellaworks_star_rule( 'tan' ); ?>
				<h2 class="display band__title">Creating stunning websites that also drive results.</h2>
				<div class="script band__sub">Bellaworks sites are more than just a pretty face.</div>
				<?php bellaworks_star_rule( 'tan' ); ?>
			</div>
		</section>

		<!-- TECHIES -->
		<section class="section section--tan techies">
			<?php bellaworks_watermark( 'rings', 'brown', 0.10, 'right: -160px; top: -120px; width: 620px; height: 620px;' ); ?>
			<div class="wrapper techies__grid">
				<div class="techies__stamp">
					<?php bellaworks_stamp(); ?>
				</div>
				<div class="techies__copy">
					<h2 class="display">Leave the tech<br>to the <span class="text-red">techies</span></h2>
					<p>Our process is smooth from the get-go. We often work with clients whose main role isn’t managing the website but are all about making it a success. Our pros unite strategy, copywriting, design, and development to level up your web presence. That way, you can spend more time on what you’re most passionate about in your workday.</p>
					<?php bellaworks_button( 'Book A Call', home_url( '/contact-us/' ), 'red' ); ?>
				</div>
			</div>
		</section>

		<!-- SOLUTIONS -->
		<section id="services" class="section section--brown solutions">
			<?php bellaworks_watermark( 'halftone', 'tan', 0.20, 'right: -160px; top: -160px; width: 640px; height: 640px;' ); ?>
			<div class="wrapper">
				<div class="solutions__head">
					<h2 class="display">Our website<br>solutions</h2>
					<div class="script solutions__script">(We Got You Covered)</div>
				</div>
				<div class="icon-strip">
					<div><?php bellaworks_icon( 'copy' ); ?><span class="label">Copy<br>Writing</span></div>
					<div><?php bellaworks_icon( 'design' ); ?><span class="label">Design<br>+ Dev</span></div>
					<div><?php bellaworks_icon( 'hosting' ); ?><span class="label">Website<br>Hosting</span></div>
					<div><?php bellaworks_icon( 'marketing' ); ?><span class="label">Digital<br>Marketing</span></div>
				</div>
				<div class="solutions__cta">
					<?php bellaworks_button( 'Explore Our Services', home_url( '/services/' ), 'tan' ); ?>
				</div>
			</div>
		</section>

		<!-- WORK -->
		<section id="work" class="section section--tan work">
			<?php bellaworks_watermark( 'monogram', 'brown', 0.06, 'right: -140px; top: 40px; width: 760px; height: 465px; transform: rotate(-8deg);' ); ?>
			<div class="wrapper">
				<div class="work__head">
					<h2 class="display display--xl">Our work</h2>
					<?php bellaworks_star( 44, 'red' ); ?>
				</div>
				<div class="work-grid">
					<?php
					$work = array(
						'work-nourish-up.jpg'      => 'Nourish Up website',
						'work-usnwc.jpg'           => 'U.S. National Whitewater Center website',
						'work-colony.jpg'          => 'Colony Family Offices website',
						'work-steelfab.jpg'        => 'SteelFab website',
						'work-clearview.jpg'       => 'Clearview website',
						'work-neatbooks.jpg'       => 'NeatBooks website',
						'work-modern-lighting.jpg' => 'Modern Lighting website',
						'work-fletcher.jpg'        => 'Fletcher website',
						'work-friends.jpg'         => 'Friends website',
					);
					foreach ( $work as $file => $alt ) {
						echo '<div class="thumb-card"><img src="' . esc_url( $dir . '/images/' . $file ) . '" alt="' . esc_attr( $alt ) . '" loading="lazy"></div>';
					}
					?>
				</div>
			</div>
		</section>

		<!-- ABOUT -->
		<section id="about" class="section section--red about">
			<?php bellaworks_watermark( 'burst', 'tan', 0.16, 'right: -120px; bottom: -160px; width: 520px; height: 520px; transform: rotate(-10deg);' ); ?>
			<div class="wrapper about__grid">
				<div class="about__lead">
					<h2 class="display display--xl">About<br>us</h2>
					<?php bellaworks_starburst( '15+', 'YEARS', 'brown', 'tan', 20, 180, -10 ); ?>
				</div>
				<div class="about__copy">
					<p>Bellaworks opened its doors over 15 years ago to build user-friendly, beautiful “Bella” websites that drive business success. As a Charlotte, NC based web design and website development company, we carefully craft sites in-house and offer hosting and support to keep them running smoothly. With strategy at the forefront, we’ve proudly helped hundreds of businesses untangle a tricky web where aesthetics meets function and win online.</p>
					<?php bellaworks_button( 'Get To Know Us', home_url( '/about-us/' ), 'tan' ); ?>
				</div>
			</div>
		</section>

		<!-- STEPS -->
		<section class="section section--brown steps">
			<?php bellaworks_watermark( 'rings', 'tan', 0.08, 'left: 50%; top: -40px; width: 900px; height: 900px; margin-left: -450px;' ); ?>
			<?php bellaworks_watermark( 'halftone', 'tan', 0.14, 'left: -180px; bottom: -180px; width: 520px; height: 520px;' ); ?>
			<div class="wrapper steps__inner">
				<div class="steps__head">
					<div class="script steps__script">Get Started in</div>
					<h2 class="display">Three easy steps</h2>
				</div>
				<div class="steps__grid">
					<div class="steps__item">
						<?php bellaworks_starburst( '01', '', 'red', 'tan', 16, 140 ); ?>
						<p><strong>Connect with us</strong> and dive into your website needs.</p>
					</div>
					<div class="steps__item">
						<?php bellaworks_starburst( '02', '', 'red', 'tan', 16, 140 ); ?>
						<p><strong>Receive a proposal</strong> for your business goals</p>
					</div>
					<div class="steps__item">
						<?php bellaworks_starburst( '03', '', 'red', 'tan', 16, 140 ); ?>
						<p><strong>Proudly share</strong> your website with the world and focus on what you enjoy</p>
					</div>
				</div>
				<?php bellaworks_button( 'Book A Call', home_url( '/contact-us/' ), 'red', 'lg' ); ?>
			</div>
		</section>

	</main><!-- #main -->
</div><!-- #primary -->

<?php get_footer(); ?>
