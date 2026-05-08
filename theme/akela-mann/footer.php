<!-- ── Footer ──────────────────────────────────────────────── -->
<footer id="site-footer" style="background:#ffffff;border-top:1px solid rgba(124,77,187,0.15);padding:80px 0 40px;margin-top:auto;">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand -->
            <div class="footer-brand">
                <a href="<?php echo home_url('/'); ?>" class="site-logo">
                    <div class="logo-mark">AM</div>
                    <span class="logo-text">Akela <span>Mann</span></span>
                </a>
                <p>We are your friends-in-need. Pioneers in working to eradicate loneliness in India and the World.</p>
                <div class="footer-social">
                    <?php if ($ig = akela_mod('akela_instagram')): ?>
                    <a href="<?php echo esc_url($ig); ?>" class="social-icon" target="_blank" aria-label="Instagram">📸</a>
                    <?php endif; ?>
                    <?php if ($yt = akela_mod('akela_youtube')): ?>
                    <a href="<?php echo esc_url($yt); ?>" class="social-icon" target="_blank" aria-label="YouTube">▶️</a>
                    <?php endif; ?>
                    <?php if ($fb = akela_mod('akela_facebook')): ?>
                    <a href="<?php echo esc_url($fb); ?>" class="social-icon" target="_blank" aria-label="Facebook">💙</a>
                    <?php endif; ?>
                    <?php if ($tw = akela_mod('akela_twitter')): ?>
                    <a href="<?php echo esc_url($tw); ?>" class="social-icon" target="_blank" aria-label="Twitter">🐦</a>
                    <?php endif; ?>
                    <a href="https://wa.me/<?php echo akela_mod('akela_whatsapp','919892528084'); ?>" class="social-icon" target="_blank" aria-label="WhatsApp">💬</a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="<?php echo home_url('/'); ?>">Home</a></li>
                    <li><a href="<?php echo home_url('/about-us'); ?>">About Us</a></li>
                    <li><a href="<?php echo home_url('/services'); ?>">Services</a></li>
                    <li><a href="<?php echo home_url('/blogs'); ?>">Blogs</a></li>

                    <li><a href="<?php echo home_url('/videos'); ?>">Videos</a></li>
                    <li><a href="<?php echo home_url('/contact-us'); ?>">Contact Us</a></li>
                    <li><a href="<?php echo home_url('/booking'); ?>">Book a Session</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div class="footer-col">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="<?php echo home_url('/services'); ?>">Talking Sessions</a></li>
                    <li><a href="<?php echo home_url('/services'); ?>">Support Groups</a></li>
                    <li><a href="<?php echo home_url('/services'); ?>">Online Workshops</a></li>
                    <li><a href="<?php echo home_url('/services'); ?>">Community Events</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="footer-col">
                <h4>Contact Us</h4>
                <ul>
                    <li>📞 <a href="tel:<?php echo akela_mod('akela_phone', '+919892528084'); ?>"><?php echo akela_mod('akela_phone', '+91 98925 28084'); ?></a></li>
                    <li>📧 <a href="mailto:<?php echo akela_mod('akela_email', 'hello@akelamann.com'); ?>"><?php echo akela_mod('akela_email', 'hello@akelamann.com'); ?></a></li>
                    <li>📍 <?php echo akela_mod('akela_address', 'Mumbai, India'); ?></li>
                </ul>
                <div style="margin-top:20px;">
                    <h4>Hours</h4>
                    <ul>
                        <li>Mon–Fri: 9:00 am – 5:00 pm</li>
                        <li>Sat–Sun: Closed</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div style="text-align:center;padding-top:40px;border-top:1px solid rgba(124,77,187,0.1);color:var(--text-muted);font-size:0.85rem;">
            &copy; <?php echo date('Y'); ?> Akela Mann. All rights reserved. <br>
            Designed to bridge the gap of loneliness.
        </div>
    </div>
</footer>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/<?php echo akela_mod('akela_whatsapp','919892528084'); ?>"
   class="whatsapp-float"
   target="_blank"
   aria-label="Chat on WhatsApp"
   style="position:fixed;bottom:32px;right:32px;z-index:9999;width:56px;height:56px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:1.6rem;box-shadow:0 4px 20px rgba(37,211,102,0.4);transition:all 0.3s;opacity:0;transform:scale(0.8);">
    💬
</a>

<style>
.whatsapp-float.visible { opacity:1; transform:scale(1); }
.whatsapp-float:hover { transform:scale(1.1) !important; }
body.no-scroll { overflow:hidden; }
.dot { width:10px;height:10px;border-radius:50%;background:rgba(164,123,224,0.3);border:none;cursor:pointer;transition:all 0.3s;padding:0; }
.dot.active { background:var(--accent-lavender,#c9b8e8);transform:scale(1.3); }
</style>



<?php wp_footer(); ?>
</body>
</html>
