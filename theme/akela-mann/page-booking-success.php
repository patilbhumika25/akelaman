<?php
/* Template Name: Booking Success */
get_header(); ?>

<section class="section-pad" style="min-height:70vh; display:flex; align-items:center;">
    <div class="container text-center" data-aos="zoom-in">
        <div style="font-size:5rem; margin-bottom:24px;">🌙</div>
        <h1 class="section-title" style="color:#e65100;">Booking <span>Confirmed</span></h1>
        <p class="section-subtitle">Thank you. Your appointment has been scheduled successfully.</p>
        
        <div style="margin-top:40px; display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Back to Home</a>
            <a href="<?php echo home_url('/blogs'); ?>" class="btn btn-outline">Read Our Stories →</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
