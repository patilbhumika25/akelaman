<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">Get in Touch</div>
        <h1 class="section-title">Contact <span>Us</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → Contact Us</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <div class="grid-2">
            <!-- Contact Form -->
            <div data-aos="fade-right">
                <div class="section-tag">Drop Us a Line</div>
                <h2 class="section-title" style="font-size:2rem;">We Want to <span>Hear You</span></h2>
                <p>Share your story, ask a question, or just say hello. Every message is read by a real person — with care.</p>

                <form id="contact-form" class="glass-card" style="margin-top:32px;">
                    <?php wp_nonce_field('akela_nonce','contact_nonce'); ?>
                    <input type="hidden" name="action" value="akela_contact">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_name">Your Name *</label>
                            <input type="text" id="contact_name" name="name" placeholder="Riya Sharma" required>
                        </div>
                        <div class="form-group">
                            <label for="contact_email">Email Address *</label>
                            <input type="email" id="contact_email" name="email" placeholder="riya@email.com" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="contact_phone">Phone Number</label>
                        <input type="tel" id="contact_phone" name="phone" placeholder="+91 9XXXXXXXXX">
                    </div>
                    <div class="form-group">
                        <label for="contact_subject">Subject</label>
                        <select id="contact_subject" name="subject">
                            <option value="">Select a topic...</option>
                            <option value="general">General Inquiry</option>
                            <option value="booking">Booking Help</option>
                            <option value="share-story">Share My Story</option>
                            <option value="volunteer">Volunteer / Partner</option>
                            <option value="corporate">Corporate Session</option>
                            <option value="media">Media / Press</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="contact_message">Your Message *</label>
                        <textarea id="contact_message" name="message" placeholder="Tell us anything…" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" style="width:100%;">Send Message ✉️</button>
                </form>
            </div>

            <!-- Contact Info -->
            <div data-aos="fade-left" data-aos-delay="200">
                <div class="glass-card floating-el" style="margin-bottom:24px; animation-delay: 1s;">
                    <h3 style="font-family:var(--font-heading);margin-bottom:20px;">📞 Better Still, Call Us</h3>
                    <p>We love talking! Real conversations heal loneliness.</p>
                    <a href="tel:<?php echo akela_mod('akela_phone','+919833848425'); ?>" style="font-size:1.5rem;font-family:'Playfair Display',serif;color:var(--accent-lavender);">
                        <?php echo akela_mod('akela_phone', '+91 98338 48425'); ?>
                    </a>
                    <div style="margin-top:20px;">
                        <a href="https://wa.me/<?php echo akela_mod('akela_whatsapp','919833848425'); ?>" class="btn btn-outline" target="_blank" style="width:100%;justify-content:center;">💬 Message on WhatsApp</a>
                    </div>
                </div>

                <div class="glass-card" style="margin-bottom:24px;">
                    <h3 style="font-family:var(--font-heading);margin-bottom:16px;">🕐 Office Hours</h3>
                    <table style="width:100%;font-size:0.9rem;">
                        <?php
                        $hours = ['Monday'=>'9:00 am – 5:00 pm','Tuesday'=>'9:00 am – 5:00 pm','Wednesday'=>'9:00 am – 5:00 pm','Thursday'=>'9:00 am – 5:00 pm','Friday'=>'9:00 am – 5:00 pm','Saturday'=>'Closed','Sunday'=>'Closed'];
                        foreach ($hours as $day => $time):
                        $closed = $time === 'Closed';
                        ?>
                        <tr style="border-bottom:1px solid rgba(164,123,224,0.1);">
                            <td style="padding:8px 0;color:var(--text-muted);"><?php echo $day; ?></td>
                            <td style="padding:8px 0;text-align:right;color:<?php echo $closed ? '#6b4c8a' : 'var(--accent-lavender)'; ?>;"><?php echo $time; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>

                <div class="glass-card">
                    <h3 style="font-family:var(--font-heading);margin-bottom:16px;">📧 Email &amp; Address</h3>
                    <p>📧 <a href="mailto:<?php echo akela_mod('akela_email','hello@akelamann.com'); ?>"><?php echo akela_mod('akela_email','hello@akelamann.com'); ?></a></p>
                    <p>📍 <?php echo akela_mod('akela_address','Mumbai, India'); ?></p>
                    <div style="margin-top:16px;border-radius:8px;overflow:hidden;height:180px;background:rgba(26,26,62,0.5);display:flex;align-items:center;justify-content:center;border:1px solid rgba(164,123,224,0.2);">
                        <p style="color:var(--text-muted);">🗺️ Map Embed</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.getElementById('contact-form')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = this.querySelector('button[type="submit"]');
    btn.textContent = 'Sending…';
    btn.disabled = true;
    const fd = new FormData(this);
    fd.set('action','akela_contact');
    fd.set('nonce', '<?php echo wp_create_nonce("akela_nonce"); ?>');
    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {method:'POST',body:fd})
        .then(r=>r.json()).then(d=>{
            if (d.success) {
                this.innerHTML = '<div style="text-align:center;padding:48px 24px;"><div style="font-size:3rem;margin-bottom:16px;">✨</div><h3 style="font-family:var(--font-heading);margin-bottom:12px;color:var(--accent-lavender)">Message Sent!</h3><p style="color:var(--text-muted)">We\'ll get back to you within 24 hours.</p></div>';
            } else { btn.textContent = 'Send Message ✉️'; btn.disabled = false; }
        }).catch(()=>{ btn.textContent = 'Send Message ✉️'; btn.disabled = false; });
});
</script>

<?php get_footer(); ?>
