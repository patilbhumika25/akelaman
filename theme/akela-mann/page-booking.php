<?php
/**
 * Template Name: Booking
 */
get_header(); ?>

<main class="booking-page-premium">
    <div class="container">
        <div class="premium-booking-grid">
            
            <!-- Left Side: Calendar Card -->
            <div data-aos="fade-up">
                <div class="calendar-card">
                    <div class="calendar-card-header">
                        <h3>Date & Time Selection</h3>
                    </div>
                    <div class="calendar-wrapper-inner">
                        <div id="booking-calendar" class="booking-calendar"></div>
                    </div>
                    
                    <div id="time-slots-container" class="time-slots-grid-premium" style="display:none;">
                        <h4 class="time-slots-title">Select Time Slot</h4>
                        <div id="time-slots" class="time-slots-list"></div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Descriptive Content -->
            <div class="booking-copy" data-aos="fade-left">
                <span class="booking-category">Book An Appointment</span>
                <h1 class="font-heading">Healing conversations with Akela Mann</h1>
                
                <p>Break the silence of loneliness with a safe space to talk. Our specialists at Akela Mann are here to listen and guide you through your journey of connection and healing.</p>
                
                <p>You are not alone. Start your journey today.</p>

                <!-- Hidden Form for processing -->
                <form id="booking-form-premium" class="confirm-booking-inline" style="display:none;">
                    <input type="hidden" name="action" value="akela_booking">
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('akela_nonce'); ?>">
                    <input type="hidden" id="bk_date" name="session_date">
                    <input type="hidden" id="bk_time" name="session_time">
                    
                    <div class="form-row" style="margin-bottom:16px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                        <div class="form-group"><input type="text" name="name" required placeholder="Your Full Name" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                        <div class="form-group"><input type="email" name="email" required placeholder="Email Address" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                    </div>
                    <div class="form-group" style="margin-bottom:16px;"><input type="tel" name="phone" required placeholder="Phone / WhatsApp Number" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                    
                    <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px; border:none; padding:16px; color:#fff; cursor:pointer; font-weight:600; border-radius:4px;">Confirm Appointment ✨</button>
                </form>

                <div id="selection-prompt" style="padding:20px; background:#fff9e6; border-radius:4px; margin-top:24px;">
                    <p style="margin:0; font-size:0.9rem; color:#856404;">Please select a date and time slot from the calendar to proceed with your booking.</p>
                </div>
            </div>

        </div>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Show form when time is selected
    const dateInput = document.getElementById('bk_date');
    const timeInput = document.getElementById('bk_time');
    const form = document.getElementById('booking-form-premium');
    const prompt = document.getElementById('selection-prompt');

    const checkSelections = () => {
        if (dateInput && dateInput.value && timeInput && timeInput.value) {
            form.style.display = 'block';
            if (prompt) prompt.style.display = 'none';
        }
    };

    // Listen for changes (using a simple interval since the inputs are updated via JS)
    setInterval(checkSelections, 500);

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button');
        const fd = new FormData(this);
        btn.textContent = 'Processing...'; btn.disabled = true;

        fetch('<?php echo admin_url("admin-ajax.php"); ?>', {method:'POST', body:fd})
            .then(r=>r.json()).then(d=>{
                if(d.success){
                    const name = encodeURIComponent(fd.get('name'));
                    const date = encodeURIComponent(fd.get('session_date'));
                    const time = encodeURIComponent(fd.get('session_time'));
                    const meetLink = encodeURIComponent(d.data.meet_link);
                    window.location.href = `<?php echo home_url("/booking-success"); ?>?name=${name}&date=${date}&time=${time}&meet_link=${meetLink}`;
                } else { 
                    btn.textContent = 'Confirm Appointment ✨'; btn.disabled = false; 
                    alert(d.data || 'Error. Please try again.'); 
                }
            }).catch(()=>{ btn.textContent = 'Confirm Appointment ✨'; btn.disabled = false; });
    });
});
</script>

<?php get_footer(); ?>
