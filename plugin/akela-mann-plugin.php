<?php
/**
 * Plugin Name: Akela Mann — Booking & Admin
 * Plugin URI:  https://akelamann.com
 * Description: Adds shortcodes, booking form helper, and admin enhancements for the Akela Mann theme.
 * Version:     1.0.0
 * Author:      Nishant Hemrajani
 * Text Domain: akela-mann-plugin
 */

if (!defined('ABSPATH')) exit;

// ── Shortcode: [akela_booking_form] ───────────────────────────────────
function akela_booking_shortcode() {
    ob_start();
    $nonce = wp_create_nonce('akela_nonce');
    ?>
    <div class="booking-types" style="margin-bottom:24px;">
        <div class="booking-type active" data-type="Talking Session"><div class="icon">🗣️</div><h4>Talking Session</h4><p>1-on-1</p></div>
        <div class="booking-type" data-type="Support Group"><div class="icon">👥</div><h4>Support Group</h4><p>Group</p></div>
        <div class="booking-type" data-type="Mindfulness Workshop"><div class="icon">🧘</div><h4>Workshop</h4><p>Guided</p></div>
    </div>
    <form id="booking-form-sc" class="glass-card">
        <input type="hidden" name="action" value="akela_booking">
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
        <input type="hidden" id="sc_session_type" name="session_type" value="Talking Session">
        
        <div class="form-row">
            <div class="form-group"><label>Full Name *</label><input type="text" name="name" required placeholder="Your name"></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" required placeholder="Email address"></div>
        </div>
        <div class="form-group"><label>Phone / WhatsApp *</label><input type="tel" name="phone" required placeholder="+91 XXXX XXX XXX"></div>

        <!-- Interactive Calendar Integration -->
        <div class="calendar-wrapper" style="margin-top:20px;">
            <label>Select Date & Time *</label>
            <div id="sc-booking-calendar" class="booking-calendar"></div>
            <div id="sc-time-slots-container" class="time-slots-grid" style="display:none; margin-top:16px;">
                <div class="time-slots" id="sc-time-slots"></div>
            </div>
        </div>
        <input type="hidden" id="sc_bk_date" name="session_date" required>
        <input type="hidden" id="sc_bk_time" name="session_time" required>

        <div class="form-group" style="margin-top:20px;"><label>Message (optional)</label><textarea name="message" placeholder="Ask us anything..."></textarea></div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Confirm Booking ✨</button>
    </form>
    <script>
    (function(){
        // Session Type Toggle
        document.querySelectorAll('.booking-type').forEach(b=>{
            b.addEventListener('click',function(){
                document.querySelectorAll('.booking-type').forEach(x=>x.classList.remove('active'));
                this.classList.add('active');
                document.getElementById('sc_session_type').value = this.dataset.type;
            });
        });

        // Initialize Calendar if BookingCalendar class is available from main.js
        const initCal = () => {
            if (typeof BookingCalendar !== 'undefined') {
                new BookingCalendar(
                    document.getElementById('sc-booking-calendar'),
                    'sc_bk_date', 
                    'sc_bk_time', 
                    'sc-time-slots-container', 
                    'sc-time-slots'
                );
            } else {
                setTimeout(initCal, 100);
            }
        };
        initCal();

        document.getElementById('booking-form-sc')?.addEventListener('submit',function(e){
            e.preventDefault();
            const btn=this.querySelector('button');
            btn.textContent='Confirming…'; btn.disabled=true;
            fetch('<?php echo admin_url("admin-ajax.php"); ?>',{method:'POST',body:new FormData(this)})
            .then(r=>r.json()).then(d=>{
                if(d.success){ window.location.href = '<?php echo home_url("/booking-success"); ?>'; }
                else{ btn.textContent='Confirm Booking ✨'; btn.disabled=false; alert(d.data || 'Error'); }
            });
        });
    })();
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('akela_booking_form', 'akela_booking_shortcode');

// ── Shortcode: [akela_contact_form] ───────────────────────────────────
function akela_contact_shortcode() {
    ob_start();
    $nonce = wp_create_nonce('akela_nonce');
    ?>
    <form id="contact-form-sc" class="glass-card">
        <input type="hidden" name="action" value="akela_contact">
        <input type="hidden" name="nonce" value="<?php echo $nonce; ?>">
        <div class="form-row">
            <div class="form-group"><label>Name *</label><input type="text" name="name" required></div>
            <div class="form-group"><label>Email *</label><input type="email" name="email" required></div>
        </div>
        <div class="form-group"><label>Message *</label><textarea name="message" required></textarea></div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Send Message ✉️</button>
    </form>
    <script>
    document.getElementById('contact-form-sc')?.addEventListener('submit',function(e){
        e.preventDefault();
        const btn=this.querySelector('button');
        btn.textContent='Sending…';btn.disabled=true;
        fetch('<?php echo admin_url("admin-ajax.php"); ?>',{method:'POST',body:new FormData(this)})
        .then(r=>r.json()).then(d=>{
            if(d.success){this.innerHTML='<div style="text-align:center;padding:48px"><div style="font-size:3rem">✨</div><h3>Message Sent!</h3></div>';}
            else{btn.textContent='Send Message ✉️';btn.disabled=false;}
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('akela_contact_form', 'akela_contact_shortcode');

// ── Shortcode: [akela_stats] ──────────────────────────────────────────
function akela_stats_shortcode($atts) {
    $atts = shortcode_atts(['people'=>'5000','sessions'=>'200','groups'=>'50','cities'=>'15'], $atts);
    return '<div class="stats-strip"><div class="container"><div class="stats-grid">
        <div class="stat-item"><div class="stat-number" data-count="'.$atts['people'].'">'.$atts['people'].'</div><div class="stat-label">People Helped</div></div>
        <div class="stat-item"><div class="stat-number" data-count="'.$atts['sessions'].'">'.$atts['sessions'].'</div><div class="stat-label">Sessions</div></div>
        <div class="stat-item"><div class="stat-number" data-count="'.$atts['groups'].'">'.$atts['groups'].'</div><div class="stat-label">Support Groups</div></div>
        <div class="stat-item"><div class="stat-number" data-count="'.$atts['cities'].'">'.$atts['cities'].'</div><div class="stat-label">Cities</div></div>
    </div></div></div>';
}
add_shortcode('akela_stats', 'akela_stats_shortcode');

// ── Admin: Add Booking Status Column ──────────────────────────────────
add_filter('manage_booking_posts_columns', function($cols){
    $cols['status'] = 'Status'; $cols['session_date'] = 'Session Date'; return $cols;
});
add_action('manage_booking_posts_custom_column', function($col, $id){
    if ($col === 'status') {
        $s = get_post_meta($id,'_status',true) ?: 'Pending';
        $c = $s==='Confirmed'?'green':($s==='Cancelled'?'red':'orange');
        echo '<span style="color:'.$c.';font-weight:600;">'.$s.'</span>';
    }
    if ($col === 'session_date') echo esc_html(get_post_meta($id,'_client_session_date',true));
}, 10, 2);

// ── Flush Rewrite Rules on Activation ────────────────────────────────
register_activation_hook(__FILE__, function(){ flush_rewrite_rules(); });
register_deactivation_hook(__FILE__, function(){ flush_rewrite_rules(); });
