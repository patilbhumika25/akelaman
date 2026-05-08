<?php
/* Template Name: Booking Success */
get_header(); 

$name = isset($_GET['name']) ? esc_html($_GET['name']) : 'Friend';
$date = isset($_GET['date']) ? esc_html($_GET['date']) : '';
$time = isset($_GET['time']) ? esc_html($_GET['time']) : '';
$meet_link = isset($_GET['meet_link']) ? esc_url($_GET['meet_link']) : akela_mod('akela_meet_link', 'https://meet.google.com/new');
?>

<section class="section-pad" style="min-height:70vh; display:flex; align-items:center; background: #faf8ff;">
    <div class="container text-center" data-aos="zoom-in">
        <div style="font-size:5rem; margin-bottom:24px;">✨</div>
        <h1 class="section-title" style="color:#7c4dbb;">Booking <span>Confirmed</span></h1>
        <p class="section-subtitle">Thank you, <strong><?php echo $name; ?></strong>. Your healing session is scheduled.</p>
        
        <?php if ($date && $time): ?>
        <div style="max-width:500px; margin: 40px auto; background:#fff; border-radius:12px; padding:32px; box-shadow:0 12px 40px rgba(124,77,187,0.1); border:1px solid rgba(124,77,187,0.1);">
            <div style="text-align:left; margin-bottom:24px;">
                <h3 style="font-family:var(--font-heading); color:#7c4dbb; margin-bottom:16px; font-size:1.4rem;">Meeting Details</h3>
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:12px;">
                    <span style="font-size:1.2rem;">📅</span>
                    <span style="font-weight:600; color:#444;"><?php echo $date; ?></span>
                </div>
                <div style="display:flex; gap:12px; align-items:center; margin-bottom:12px;">
                    <span style="font-size:1.2rem;">🕐</span>
                    <span style="font-weight:600; color:#444;"><?php echo $time; ?></span>
                </div>
            </div>
            
            <div style="background:#f8f5ff; padding:20px; border-radius:8px; border:1.5px dashed #a47be0;">
                <p style="font-size:0.9rem; color:#7c4dbb; font-weight:600; margin-bottom:8px; text-transform:uppercase; letter-spacing:1px;">Google Meet Link</p>
                <a href="<?php echo $meet_link; ?>" target="_blank" style="font-size:1.1rem; color:#1a1a2e; text-decoration:none; font-family:monospace; word-break:break-all;"><?php echo $meet_link; ?></a>
                <p style="font-size:0.8rem; color:#666; margin-top:12px;">Please join 5 minutes before the scheduled time.</p>
            </div>
        </div>
        <?php endif; ?>

        <div style="margin-top:40px; display:flex; gap:16px; justify-content:center; flex-wrap:wrap;">
            <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">Back to Home</a>
            <a href="<?php echo home_url('/blogs'); ?>" class="btn btn-outline">Read Our Stories →</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
