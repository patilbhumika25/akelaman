<?php get_header(); ?>

<!-- ── HERO SECTION ──────────────────────────────────────── -->
<section class="hero">
    <video class="hero-bg" autoplay muted loop playsinline id="heroVideo"
        style="object-fit: cover; width: 100%; height: 100%; background-image: none;">
        <source src="<?php echo get_template_directory_uri(); ?>/images/ocean-waves.mp4" type="video/mp4">
    </video>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var video = document.getElementById('heroVideo');
            if (video) {
                video.playbackRate = 0.7; // A little bit slow as requested

                // Force video to keep playing if it stops for any reason
                video.addEventListener('pause', function () {
                    video.play().catch(function () { });
                });
                video.addEventListener('ended', function () {
                    video.play().catch(function () { });
                });
            }
        });
    </script>
    <div class="hero-overlay"></div>
    <div class="particles" id="particles"></div>

    <div class="hero-content">
        <div class="hero-tag slide-up-anim" style="animation-delay: 0.1s;">🌙 Pioneer in Eradicating Loneliness</div>
        <h1 class="slide-up-anim" style="animation-delay: 0.3s;">
            <?php echo akela_mod('akela_hero_tagline', 'You Are Not <br><span>Alone</span>'); ?></h1>
        <p class="slide-up-anim" style="animation-delay: 0.5s;">
            <?php echo akela_mod('akela_hero_sub', 'We are your friends-in-need. Pioneers in working to eradicate loneliness in India and the World.'); ?>
        </p>
        <div class="hero-btns slide-up-anim" style="animation-delay: 0.7s;">
            <a href="<?php echo home_url('/#booking-section'); ?>" class="btn btn-primary pulsing-btn">Book a Free
                Session ✨</a>
            <a href="javascript:void(0)" class="btn btn-outline" style="cursor: default;">Our Story →</a>
        </div>
    </div>

    <div class="hero-scroll">Scroll</div>
</section>

<!-- ── STATS STRIP ───────────────────────────────────────── -->
<section class="stats-strip">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-item" data-aos="fade-up">
                <div class="stat-number" data-count="5000">0</div>
                <div class="stat-label">People Helped</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-number" data-count="200">0</div>
                <div class="stat-label">Sessions Conducted</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-number" data-count="50">0</div>
                <div class="stat-label">Support Groups</div>
            </div>
            <div class="stat-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-number" data-count="15">0</div>
                <div class="stat-label">Cities Reached</div>
            </div>
        </div>
    </div>
</section>

<!-- ── SERVICES SECTION ──────────────────────────────────── -->
<section id="services-section" class="section-pad services-slider-section">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-tag">What We Offer</div>
            <h2 class="section-title">Healing Services for a <span>Lonely Mind</span></h2>
            <p class="section-subtitle">From one-on-one sessions to community workshops — we have a path for every
                lonely soul.</p>
        </div>
    </div>

    <div class="services-slider-wrapper" data-aos="fade-up">
        <button class="slider-arrow prev" aria-label="Previous service">‹</button>
        <div class="services-slider-container">
            <div class="services-slider-track">
                <?php
                $services = [
                    ['🤝', 'JAB WE TALK', 'One-on-one empathetic listening sessions.', 'jab-we-talk'],
                    ['🌱', 'LIFE COACHING', 'Personalized guidance for your life goals.', 'life-coaching'],
                    ['👨‍🏫', 'MENTORING', 'Building connection through experienced guidance.', 'mentoring'],
                    ['🚶‍♀️', 'WALKS, WELLNESS & MORE', 'Outdoor healing and mindfulness activities.', 'walks-wellness-more'],
                    ['🎓', 'COURSES', 'Structured learning for mental well-being.', 'courses'],
                    ['💻', 'DIGITAL PRODUCTS', 'Tools and resources for your healing journey.', 'digital-products'],
                    ['🛠️', 'WORKSHOPS', 'Interactive community sessions for growth.', 'workshops'],
                ];
                foreach ($services as [$icon, $title, $desc, $slug]):
                    ?>
                    <div class="service-bubble">
                        <a href="<?php echo home_url('/' . $slug); ?>" class="bubble-link-wrapper">
                            <div class="bubble-content">
                                <div class="bubble-icon"><?php echo $icon; ?></div>
                                <h3 class="bubble-title"><?php echo $title; ?></h3>
                                <span class="bubble-link">View details</span>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button class="slider-arrow next" aria-label="Next service">›</button>
    </div>
</section>

<!-- ── MISSION SECTION ─────────────────────────────────────-->
<section class="section-pad" style="background:linear-gradient(135deg,#ffffff,#f0edf8);">
    <div class="container">
        <div class="grid-2">
            <div data-aos="fade-right">
                <div class="section-tag">Our Mission</div>
                <h2 class="section-title">A World Where <span>No One Feels Alone</span></h2>
                <p>At Akela Mann, our mission is to support people feeling lonely and socially isolated by bringing joy,
                    happiness, and a sense of community into their lives.</p>
                <p>Founded by Nishant Hemrajani, we believe that loneliness is not a weakness — it's a signal that you
                    deserve more human connection. We answer that signal every day.</p>
                <div style="display:flex;gap:16px;margin-top:32px;flex-wrap:wrap;">
                    <a href="/#testimonials-section" class="btn btn-primary">About Us</a>
                    <a href="tel:<?php echo akela_mod('akela_phone', '09892528084'); ?>" class="btn btn-outline">📞 Call
                        Us</a>
                </div>
            </div>
            <div data-aos="fade-left" data-aos-delay="100">
                <img src="<?php echo get_template_directory_uri(); ?>/images/about.png" alt="Community gathering"
                    style="border-radius:16px;border:1px solid rgba(164,123,224,0.25);box-shadow:0 16px 64px rgba(124,77,187,0.2);">
            </div>
        </div>
    </div>
</section>


<!-- ── MY BLOG SECTION (CAROUSEL & FILTER) ────────────────── -->
<section id="blog-section" class="section-pad blog-carousel-section">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <h2 class="section-title"><a href="<?php echo home_url('/blogs'); ?>">My Blog</a></h2>
        </div>

        <!-- Category Tabs -->
        <div class="blog-tabs-wrapper" data-aos="fade-up">
            <ul class="blog-tabs">
                <li class="active" data-filter="all">All Posts</li>
                <li data-filter="boredom">Boredom</li>
                <li data-filter="happiness">Happiness</li>
                <li data-filter="kiss-and-cuddles">Kiss and cuddles</li>
                <li data-filter="life-in-2025">Life in 2025</li>
                <li data-filter="spiritual-awakening">Spiritual Awakening</li>
                <li data-filter="loneliness">loneliness</li>
            </ul>
        </div>

        <!-- Carousel Container -->
        <div class="blog-carousel-wrapper" data-aos="fade-up">
            <button class="blog-nav-btn prev" aria-label="Previous posts">‹</button>
            <div class="blog-carousel-container">
                <div class="blog-carousel-track">
                    <?php
                    $all_posts = get_posts(['numberposts' => 10, 'post_status' => 'publish', 'orderby' => 'menu_order', 'order' => 'ASC']);
                    if ($all_posts):
                        foreach ($all_posts as $post):
                            setup_postdata($post);
                            $post_cats = get_the_category($post->ID);
                            $cat_slugs = array_map(function ($c) {
                                return $c->slug; }, $post_cats);
                            $cat_class = implode(' ', $cat_slugs);
                            ?>
                            <div class="blog-slide <?php echo $cat_class; ?>"
                                data-cats='<?php echo json_encode($cat_slugs); ?>'>
                                <div class="blog-card-premium" style="cursor: pointer;" onclick="window.location.href='<?php the_permalink(); ?>';">
                                    <?php
                                    $img_name = get_post_meta($post->ID, '_akela_post_image', true);
                                    if ($img_name): ?>
                                        <div class="blog-card-image">
                                            <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($img_name); ?>"
                                                alt="<?php the_title(); ?>">
                                        </div>
                                    <?php endif; ?>
                                    <div class="blog-card-date"><?php echo get_the_date('j F Y'); ?></div>
                                    <h3 class="blog-card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    <div class="blog-card-excerpt">
                                        <?php echo wp_trim_words(get_the_content(), 55, ''); ?>
                                    </div>
                                    <div class="blog-card-footer">
                                        <a href="<?php the_permalink(); ?>" class="continue-reading">Continue Reading</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;
                        wp_reset_postdata(); ?>
                    <?php else: ?>
                        <div class="text-center" style="width:100%; padding:40px; color:#999;">
                            No blog posts found. Please ensure the blueprint has run correctly.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <button class="blog-nav-btn next" aria-label="Next posts">›</button>
        </div>
    </div>
</section>

<!-- ── TESTIMONIALS ────────────────────────────────────────-->
<section id="testimonials-section" class="section-pad testimonial-premium-bg"
    style="background-image: url('<?php echo get_template_directory_uri(); ?>/images/greenery-bg.png');">
    <div class="overlay-gradient"></div>
    <div class="container relative">
        <div class="text-center" data-aos="zoom-in">
            <div class="section-tag">What People Say</div>
            <h2 class="section-title">Voices of <span style="color: var(--accent-glow);">Healing</span></h2>
        </div>
        <div style="position:relative;overflow:hidden;margin-top:48px;">
            <div class="testimonials-track" style="display:flex;transition:transform 0.5s ease;">
                <?php
                $testimonials_q = new WP_Query(['post_type' => 'testimonial', 'posts_per_page' => 5]);
                if ($testimonials_q->have_posts()):
                    while ($testimonials_q->have_posts()):
                        $testimonials_q->the_post();
                        $author = get_post_meta(get_the_ID(), '_author_name', true);
                        $role = get_post_meta(get_the_ID(), '_author_role', true);
                        ?>
                        <div class="testimonial-card" style="min-width:100%;box-sizing:border-box;">
                            <div class="testimonial-text"><?php the_content(); ?></div>
                            <div class="testimonial-author">
                                <div class="testimonial-avatar"><?php echo strtoupper(substr($author, 0, 1)); ?></div>
                                <div>
                                    <div class="testimonial-name"><?php echo esc_html($author); ?></div>
                                    <div class="testimonial-role"><?php echo esc_html($role); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata();
                else:
                    $testimonials_data = [
                        ['R', 'Reshma M.', 'Mumbai', 'I had felt invisible for 3 years. Akela Mann gave me a space where I was finally seen. The talking sessions changed my life.'],
                        ['A', 'Arjun V.', 'Bangalore', 'I never thought a stranger on the internet could become my lifeline. The support group is the best thing that happened to me.'],
                        ['P', 'Priya S.', 'Delhi', 'The workshops are beautiful. I cried, I laughed, and I left feeling like I belonged somewhere for the first time.'],
                    ];
                    foreach ($testimonials_data as [$initial, $name, $city, $text]):
                        ?>
                        <div class="testimonial-card" style="min-width:100%;box-sizing:border-box;padding:48px;">
                            <p class="testimonial-text"
                                style="font-style:italic;font-size:1.1rem;max-width:700px;margin:0 auto 24px;">
                                "<?php echo $text; ?>"</p>
                            <div class="testimonial-author" style="justify-content:center;">
                                <div class="testimonial-avatar"><?php echo $initial; ?></div>
                                <div>
                                    <div class="testimonial-name"><?php echo $name; ?></div>
                                    <div class="testimonial-role"><?php echo $city; ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; endif; ?>
            </div>
            <!-- Controls -->
            <button class="testimonial-prev" aria-label="Previous"
                style="position:absolute;left:0;top:50%;transform:translateY(-50%);background:rgba(124,77,187,0.3);border:1px solid rgba(164,123,224,0.3);color:#c9b8e8;width:44px;height:44px;border-radius:50%;cursor:pointer;font-size:1.2rem;">‹</button>
            <button class="testimonial-next" aria-label="Next"
                style="position:absolute;right:0;top:50%;transform:translateY(-50%);background:rgba(124,77,187,0.3);border:1px solid rgba(164,123,224,0.3);color:#c9b8e8;width:44px;height:44px;border-radius:50%;cursor:pointer;font-size:1.2rem;">›</button>
        </div>
        <div class="testimonial-dots" style="display:flex;justify-content:center;gap:8px;margin-top:24px;"></div>
    </div>
</section>


<!-- ── BOOKING SECTION ────────────────────────────────────── -->
<section id="booking-section" class="section-pad booking-page-premium" style="background:#ffffff;">
    <div class="container">
        <div class="premium-booking-grid">

            <!-- Left Side: Calendar Card -->
            <div data-aos="fade-up">
                <div class="calendar-card">
                    <div class="calendar-card-header">
                        <h3>Date & Time Selection</h3>
                    </div>
                    <div class="calendar-wrapper-inner">
                        <div id="front-booking-calendar" class="booking-calendar"></div>
                    </div>

                    <div id="front-time-slots-container" class="time-slots-grid-premium" style="display:none;">
                        <h4 class="time-slots-title">Select Time Slot</h4>
                        <div id="front-time-slots" class="time-slots-list"></div>
                    </div>
                </div>

                <div id="front-selection-prompt" style="padding:20px; background:#fff9e6; border-radius:4px; margin-top:24px;">
                    <p style="margin:0; font-size:0.9rem; color:#856404;">Please select a date and time slot from the calendar to proceed with your booking.</p>
                </div>
            </div>

            <!-- Right Side: Descriptive Content & Form -->
            <div class="booking-right-col">
                <div class="booking-copy" data-aos="fade-left">
                    <span class="booking-category">Book An Appointment</span>
                    <h2 class="font-heading" style="font-size: 3.5rem; line-height: 1.1; margin-bottom: 32px; color: var(--text-primary);">
                        Healing conversations with Akela Mann</h2>

                    <p>Break the silence of loneliness with a safe space to talk. Our specialists at Akela Mann are here to
                        listen and guide you through your journey of connection and healing.</p>

                    <p>You are not alone. Start your journey today.</p>
                </div>

                <!-- Form moved here to appear at right on desktop, bottom on mobile -->
                <div class="booking-form-container" data-aos="fade-up">
                    <form id="front-booking-form-premium" class="confirm-booking-inline" style="display:none; margin-top: 32px; border-top: 1px solid #eee; padding-top: 24px;">
                        <input type="hidden" name="action" value="akela_booking">
                        <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('akela_nonce'); ?>">
                        <input type="hidden" id="front_bk_date" name="session_date">
                        <input type="hidden" id="front_bk_time" name="session_time">
                        
                        <div class="form-row" style="margin-bottom:16px; display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                            <div class="form-group"><input type="text" name="name" required placeholder="Your Full Name" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                            <div class="form-group"><input type="email" name="email" required placeholder="Email Address" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                        </div>
                        <div class="form-group" style="margin-bottom:16px;"><input type="tel" name="phone" required placeholder="Phone / WhatsApp Number" style="width:100%; padding:12px; border:1px solid #eee; border-radius:4px;"></div>
                        
                        <button type="submit" class="btn btn-primary" style="width:100%; margin-top:20px; border:none; padding:16px; color:#fff; cursor:pointer; font-weight:600; border-radius:4px;">Confirm Appointment ✨</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Calendar for Front Page
        const initFrontCal = () => {
            if (typeof BookingCalendar !== 'undefined') {
                new BookingCalendar(
                    document.getElementById('front-booking-calendar'),
                    'front_bk_date',
                    'front_bk_time',
                    'front-time-slots-container',
                    'front-time-slots'
                );
            } else {
                setTimeout(initFrontCal, 100);
            }
        };
        initFrontCal();

        const dateInput = document.getElementById('front_bk_date');
        const timeInput = document.getElementById('front_bk_time');
        const form = document.getElementById('front-booking-form-premium');
        const prompt = document.getElementById('front-selection-prompt');

        let isBooked = false;
        const checkSelections = () => {
            if (isBooked) return;
            if (dateInput && dateInput.value && timeInput && timeInput.value) {
                form.style.display = 'block';
                if (prompt) prompt.style.display = 'none';
            }
        };
        setInterval(checkSelections, 500);

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            const btn = this.querySelector('button');
            const fd = new FormData(this);
            const userName = this.querySelector('input[name="name"]').value || 'there';
            const bookingDate = document.getElementById('front_bk_date').value;
            const bookingTime = document.getElementById('front_bk_time').value;
            btn.textContent = 'Processing...'; btn.disabled = true;

            fetch('<?php echo admin_url("admin-ajax.php"); ?>', { method: 'POST', body: fd })
                .then(r => r.json()).then(d => {
                    if (d.success) {
                        isBooked = true;
                        // Exactly replace the 'marked part' (form area)
                        form.style.display = 'none';
                        if (prompt) prompt.style.display = 'none';

                        const meetLink = d.data.meet_link;

                        const successDiv = document.createElement('div');
                        successDiv.id = 'booking-success-inline';
                        successDiv.style.flex = '1';
                        successDiv.style.display = 'flex';
                        successDiv.innerHTML = `
                            <div style="
                                background: #f0faf4;
                                border: 1.5px solid #b2dfcb;
                                border-radius: 4px;
                                padding: 24px;
                                text-align: center;
                                animation: fadeInUp 0.4s ease;
                                display: flex;
                                flex-direction: column;
                                justify-content: center;
                                align-items: center;
                                width: 100%;
                            ">
                                <div style="font-size:2rem;margin-bottom:8px;">✨</div>
                                <h3 style="font-family:var(--font-heading);font-size:1.4rem;color:#1a6641;margin-bottom:4px;">
                                    Booking Confirmed!
                                </h3>
                                <p style="color:#2d7a55;font-size:0.9rem;margin-bottom:12px;">
                                    Thanks <strong>${userName}</strong>, your session is scheduled for:<br>
                                    <span style="font-weight:600;">📅 ${bookingDate} | 🕐 ${bookingTime}</span>
                                </p>
                                <div style="background:#fff; border:1px dashed #b2dfcb; padding:12px; border-radius:4px; margin-bottom:16px; width:100%;">
                                    <p style="font-size:0.7rem; color:#1a6641; font-weight:700; text-transform:uppercase; margin-bottom:4px;">Google Meet Link</p>
                                    <a href="${meetLink}" target="_blank" style="font-size:0.85rem; color:#1a6641; text-decoration:none; font-family:monospace; word-break:break-all;">${meetLink}</a>
                                </div>
                                <button onclick="window.location.reload()" class="btn btn-outline" style="padding:8px 16px; font-size:0.85rem; border-color: #1a6641; color: #1a6641;">
                                    Book Another Session
                                </button>
                            </div>`;
                        form.parentNode.appendChild(successDiv);
                    } else {
                        btn.textContent = 'Confirm Appointment ✨'; btn.disabled = false;
                        alert(d.data || 'Error. Please try again.');
                    }
                }).catch(() => { btn.textContent = 'Confirm Appointment ✨'; btn.disabled = false; });
        });
    });
</script>

<!-- ── CTA BANNER ──────────────────────────────────────────-->
<section class="section-pad-sm" style="background:linear-gradient(135deg,#f0edf8,#ffffff);">
    <div class="container text-center">
        <h2 class="section-title" data-aos="fade-up">Share Your Story of <span>Loneliness</span></h2>
        <p class="section-subtitle" style="margin-bottom:32px;">We want to hear every story. You are not broken — you
            are brave.</p>
        <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
            <a href="#booking-section" class="btn btn-primary pulsing-btn">Book a Free
                Session ✨</a>
            <a href="https://wa.me/<?php echo akela_mod('akela_whatsapp', '919892528084'); ?>" target="_blank"
                class="btn btn-outline">💬 WhatsApp Us</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>