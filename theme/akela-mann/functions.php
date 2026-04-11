<?php
/**
 * Akela Mann Theme Functions
 */

// ── Theme Setup ──────────────────────────────────────────────
function akela_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form','comment-form','comment-list','gallery','caption']);
    add_theme_support('woocommerce');
    add_image_size('blog-thumb', 800, 500, true);
    add_image_size('reel-thumb', 400, 711, true);

    register_nav_menus([
        'primary' => __('Primary Menu', 'akela-mann'),
        'footer'  => __('Footer Menu', 'akela-mann'),
    ]);

    // Nuclear 2.0: Disable all redirect logic
    remove_action('template_redirect', 'redirect_canonical');
    remove_action('template_redirect', 'wp_redirect_admin_locations', 10000);
    add_filter('wp_redirect', '__return_false', 9999);
    add_filter('canonical_redirect_rules', '__return_empty_array', 9999);
    add_filter('pre_option_permalink_structure', '__return_empty_string', 9999);

    // Final Bypass: Directly serve front-page if requested via query param
    if (isset($_GET['static_export'])) {
        include get_template_directory() . '/front-page.php';
        exit;
    }
}
add_action('after_setup_theme', 'akela_setup');

// ── Auto-create Pages ─────────────────────────────────────────
function akela_create_pages() {
    $pages = [
            'template'=> 'page-reels.php'
        ], */
        'booking' => [
            'title'   => 'Booking',
            'content' => '',
            'template'=> 'page-booking.php'
        ],
        'jab-we-talk' => [
            'title'   => 'Jab We Talk',
            'content' => '<p>Jab We Talk is our flagship one-on-one empathetic listening session. In a world full of noise, we provide a safe, non-judgmental space for you to pour your heart out. Whether you are dealing with stress, feeling lonely, or simply need someone to listen without offering unsolicited advice, we are here for you.</p>',
            'template'=> 'page-service.php'
        ],
        'life-coaching' => [
            'title'   => 'Life Coaching',
            'content' => '<p>Our personalized life coaching sessions are designed to help you navigate through life\'s challenges, set meaningful goals, and rediscover your purpose. We work closely with you to overcome obstacles, build confidence, and create an actionable path towards a happier and more fulfilling life.</p>',
            'template'=> 'page-service.php'
        ],
        'mentoring' => [
            'title'   => 'Mentoring',
            'content' => '<p>Through our mentoring program, experienced individuals connect with you to offer guidance, share their wisdom, and provide support in your personal or professional journey. This structured relationship aims to foster personal growth, mutual respect, and a strong sense of community.</p>',
            'template'=> 'page-service.php'
        ],
        'walks-wellness-more' => [
            'title'   => 'Walks, Wellness & More',
            'content' => '<p>Step outside and reconnect with yourself through nature. Our outdoor healing and mindfulness activities combine light physical exercise with mental relaxation techniques. Join us for mindful nature walks that promote physical health, clear your mind, and build organic connections with like-minded individuals.</p>',
            'template'=> 'page-service.php'
        ],
        'courses' => [
            'title'   => 'Courses',
            'content' => '<p>We offer carefully curated courses that provide structured learning for your mental well-being journey. Our courses cover topics ranging from emotional intelligence and boundary setting to practical strategies for managing anxiety and building resilience in your everyday life.</p>',
            'template'=> 'page-service.php'
        ],
        'digital-products' => [
            'title'   => 'Digital Products',
            'content' => '<p>Empower your healing journey at your own pace with our range of digital tools and resources. We offer guided meditation audios, journaling templates, interactive workbooks, and self-reflection prompts designed to support your mental health whenever and wherever you need them.</p>',
            'template'=> 'page-service.php'
        ],
        'workshops' => [
            'title'   => 'Workshops',
            'content' => '<p>Our interactive workshops bring people together to learn, share, and grow in a supportive group environment. These sessions focus on various aspects of personal development, mental well-being, and community building, ensuring you leave with practical skills and a sense of belonging.</p>',
            'template'=> 'page-service.php'
        ]
    ];

    $created = false;
    foreach ($pages as $slug => $page) {
        $existing = get_page_by_path($slug);
        if (!$existing) {
            $post_id = wp_insert_post([
                'post_type'    => 'page',
                'post_title'   => $page['title'],
                'post_name'    => $slug,
                'post_status'  => 'publish',
                'post_content' => $page['content'],
                'post_author'  => 1
            ]);
            if ($post_id && !empty($page['template'])) {
                update_post_meta($post_id, '_wp_page_template', $page['template']);
                $created = true;
            }
        }
    }
    
    if ($created) {
        flush_rewrite_rules();
    }
}
add_action('after_setup_theme', 'akela_create_pages');

// ── Enqueue Scripts & Styles ──────────────────────────────────
function akela_enqueue() {
    wp_enqueue_style('aos-css', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css', [], '2.3.4');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&family=Inter:wght@300;400;500;600&display=swap', [], null);
    wp_enqueue_style('akela-style', get_stylesheet_uri(), ['google-fonts', 'aos-css'], '1.0.0');

    wp_enqueue_script('aos-js', 'https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js', [], '2.3.4', true);
    wp_enqueue_script('akela-main', get_template_directory_uri() . '/js/main.js', ['aos-js'], '1.0.0', true);

    // Pass AJAX URL to JS
    wp_localize_script('akela-main', 'AkelaAjax', [
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce'   => wp_create_nonce('akela_nonce'),
    ]);

    wp_localize_script('akela-main', 'AkelaVars', [
        'home_url' => home_url('/'),
    ]);
}
add_action('wp_enqueue_scripts', 'akela_enqueue');

// ── Custom Post Types ──────────────────────────────────────────

// Reels CPT
function akela_register_cpts() {
/*    register_post_type('reel', [
        'labels'       => ['name' => 'Reels', 'singular_name' => 'Reel', 'menu_name' => 'Reels'],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'reels'],
        'supports'     => ['title', 'thumbnail', 'custom-fields'],
        'menu_icon'    => 'dashicons-video-alt3',
        'show_in_rest' => true,
    ]); */

    // Videos CPT
    register_post_type('video', [
        'labels'       => ['name' => 'Videos', 'singular_name' => 'Video', 'menu_name' => 'Videos'],
        'public'       => true,
        'has_archive'  => true,
        'rewrite'      => ['slug' => 'videos'],
        'supports'     => ['title', 'editor', 'thumbnail', 'custom-fields'],
        'menu_icon'    => 'dashicons-video-alt2',
        'show_in_rest' => true,
    ]);

    // Bookings CPT
    register_post_type('booking', [
        'labels'      => ['name' => 'Bookings', 'singular_name' => 'Booking', 'menu_name' => 'Bookings'],
        'public'      => false,
        'show_ui'     => true,
        'supports'    => ['title', 'custom-fields'],
        'menu_icon'   => 'dashicons-calendar-alt',
        'capability_type' => 'post',
    ]);

    // Testimonials CPT
    register_post_type('testimonial', [
        'labels'      => ['name' => 'Testimonials', 'singular_name' => 'Testimonial'],
        'public'      => false,
        'show_ui'     => true,
        'supports'    => ['title', 'editor', 'custom-fields'],
        'menu_icon'   => 'dashicons-format-quote',
        'show_in_rest'=> true,
    ]);
}
add_action('init', 'akela_register_cpts');

// ── Custom Meta Boxes ──────────────────────────────────────────
function akela_add_meta_boxes() {
    add_meta_box('reel_url', 'Reel / Video URL', 'akela_reel_url_cb', ['reel', 'video'], 'normal', 'high');
    add_meta_box('akela_post_image', 'Blog Post Image', 'akela_render_post_image_box', 'post', 'side');
    add_meta_box('akela_booking_meta', 'Booking Details', 'akela_render_booking_box', 'booking', 'normal');
    add_meta_box('akela_reel_meta', 'Reel Video URL', 'akela_render_reel_box', 'reel', 'normal');
    add_meta_box('akela_testimonial_meta', 'Testimonial Details', 'akela_render_testimonial_box', 'testimonial', 'normal');
}
add_action('add_meta_boxes', 'akela_add_meta_boxes');

function akela_render_reel_box($post) {
    $url = get_post_meta($post->ID, '_embed_url', true);
    $dur = get_post_meta($post->ID, '_duration', true);
    echo '<p><label><strong>Embed URL (YouTube/Instagram):</strong></label><br>';
    echo '<input type="url" name="embed_url" value="' . esc_attr($url) . '" style="width:100%;padding:8px;" /></p>';
    echo '<p><label><strong>Duration (e.g. 1:23):</strong></label><br>';
    echo '<input type="text" name="duration" value="' . esc_attr($dur) . '" style="width:200px;padding:8px;" /></p>';
    wp_nonce_field('akela_save_meta', 'akela_meta_nonce');
}

function akela_render_booking_box($post) {
    $fields = ['_client_name','_client_email','_client_phone','_session_type','_session_date','_session_time','_status'];
    $labels = ['Client Name','Email','Phone','Session Type','Date','Time','Status'];
    echo '<table style="width:100%;border-collapse:collapse;">';
    foreach ($fields as $i => $field) {
        $val = get_post_meta($post->ID, $field, true);
        echo '<tr><td style="padding:6px;font-weight:600;width:140px;">' . $labels[$i] . '</td>';
        echo '<td style="padding:6px;"><input type="text" name="' . esc_attr(ltrim($field,'_')) . '" value="' . esc_attr($val) . '" style="width:100%;padding:6px;" /></td></tr>';
    }
    echo '</table>';
    wp_nonce_field('akela_save_meta', 'akela_meta_nonce');
}

// ── Blog Post Image Render Box ────────────────────────────────
function akela_render_post_image_box($post) {
    $img = get_post_meta($post->ID, '_akela_post_image', true);
    wp_nonce_field('akela_save_post_image', 'akela_post_image_nonce');
    ?>
    <p>Enter the filename of the image in <code>/images/blog/</code></p>
    <input type="text" name="akela_post_image" value="<?php echo esc_attr($img); ?>" style="width:100%;">
    <?php if ($img): ?>
        <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($img); ?>" style="width:100%;margin-top:10px;border-radius:4px;">
    <?php endif;
}

// ── Save Meta Boxes ────────────────────────────────────────────
function akela_save_custom_meta($post_id) {
    if (!isset($_POST['akela_post_image_nonce']) || !wp_verify_nonce($_POST['akela_post_image_nonce'], 'akela_save_post_image')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    if (isset($_POST['akela_post_image'])) {
        update_post_meta($post_id, '_akela_post_image', sanitize_text_field($_POST['akela_post_image']));
    }

    // Save other meta (booking, etc) if needed
    if (isset($_POST['akela_booking_meta_field'])) {
        update_post_meta($post_id, '_akela_booking_data', sanitize_text_field($_POST['akela_booking_meta_field']));
    }
}
add_action('save_post', 'akela_save_custom_meta');

function akela_render_testimonial_box($post) {
    $author = get_post_meta($post->ID, '_author_name', true);
    $role   = get_post_meta($post->ID, '_author_role', true);
    $rating = get_post_meta($post->ID, '_rating', true);
    echo '<p><label><strong>Author Name:</strong></label><br><input type="text" name="author_name" value="' . esc_attr($author) . '" style="width:100%;padding:8px;" /></p>';
    echo '<p><label><strong>Author Role/City:</strong></label><br><input type="text" name="author_role" value="' . esc_attr($role) . '" style="width:100%;padding:8px;" /></p>';
    echo '<p><label><strong>Rating (1-5):</strong></label><br><input type="number" name="rating" min="1" max="5" value="' . esc_attr($rating) . '" style="width:100px;padding:8px;" /></p>';
    wp_nonce_field('akela_save_meta', 'akela_meta_nonce');
}

function akela_save_meta($post_id) {
    if (!isset($_POST['akela_meta_nonce']) || !wp_verify_nonce($_POST['akela_meta_nonce'], 'akela_save_meta')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!current_user_can('edit_post', $post_id)) return;

    $fields_map = [
        'embed_url'    => '_embed_url',
        'duration'     => '_duration',
        'client_name'  => '_client_name',
        'client_email' => '_client_email',
        'client_phone' => '_client_phone',
        'session_type' => '_session_type',
        'session_date' => '_session_date',
        'session_time' => '_session_time',
        'status'       => '_status',
        'author_name'  => '_author_name',
        'author_role'  => '_author_role',
        'rating'       => '_rating',
    ];
    foreach ($fields_map as $post_key => $meta_key) {
        if (isset($_POST[$post_key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$post_key]));
        }
    }
}
add_action('save_post', 'akela_save_meta');

// ── AJAX: Booking Form Submission ──────────────────────────────
function akela_handle_booking() {
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'akela_nonce')) {
        wp_send_json_error('Security check failed');
    }
    $post_id = wp_insert_post([
        'post_type'   => 'booking',
        'post_status' => 'publish',
        'post_title'  => sanitize_text_field($_POST['name'] ?? '') . ' – ' . sanitize_text_field($_POST['session_date'] ?? ''),
    ]);
    if ($post_id) {
        $fields = ['name','email','phone','session_type','session_date','session_time','message'];
        foreach ($fields as $f) {
            update_post_meta($post_id, "_client_$f", sanitize_text_field($_POST[$f] ?? ''));
        }
        update_post_meta($post_id, '_status', 'Pending');
        wp_send_json_success(['message' => 'Booking confirmed!', 'id' => $post_id]);
    }
    wp_send_json_error('Could not save booking');
}
add_action('wp_ajax_akela_booking', 'akela_handle_booking');
add_action('wp_ajax_nopriv_akela_booking', 'akela_handle_booking');

// ── AJAX: Contact Form Submission ──────────────────────────────
function akela_handle_contact() {
    if (!wp_verify_nonce($_POST['nonce'] ?? '', 'akela_nonce')) {
        wp_send_json_error('Security check failed');
    }
    $name    = sanitize_text_field($_POST['name'] ?? '');
    $email   = sanitize_email($_POST['email'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');

    // Save as WordPress comment / custom option
    $submissions = get_option('akela_contact_submissions', []);
    $submissions[] = compact('name','email','message') + ['date' => current_time('mysql')];
    update_option('akela_contact_submissions', $submissions);

    // Optionally send email
    wp_mail(get_option('admin_email'), "New Contact: $name", "From: $name <$email>\n\n$message");

    wp_send_json_success(['message' => 'Message sent!']);
}
add_action('wp_ajax_akela_contact', 'akela_handle_contact');
add_action('wp_ajax_nopriv_akela_contact', 'akela_handle_contact');

// ── Widget Areas ───────────────────────────────────────────────
function akela_widgets_init() {
    register_sidebar(['name' => 'Blog Sidebar', 'id' => 'blog-sidebar', 'before_widget' => '<div class="sidebar-widget glass-card">','after_widget' => '</div>','before_title' => '<h4 class="widget-title">','after_title' => '</h4>']);
    register_sidebar(['name' => 'Footer Widget 1', 'id' => 'footer-1']);
    register_sidebar(['name' => 'Footer Widget 2', 'id' => 'footer-2']);
}
add_action('widgets_init', 'akela_widgets_init');

// ── Theme Options (Customizer) ─────────────────────────────────
function akela_customizer($wp_customize) {
    $wp_customize->add_section('akela_options', ['title' => 'Akela Mann Options', 'priority' => 30]);

    $settings = [
        ['akela_phone',       'Phone Number',         '+91 98338 48425'],
        ['akela_whatsapp',    'WhatsApp Number',      '919833848425'],
        ['akela_email',       'Email Address',        'hello@akelamann.com'],
        ['akela_address',     'Address',              'Mumbai, India'],
        ['akela_hero_tagline','Hero Tagline',          'You Are Not Alone'],
        ['akela_hero_sub',    'Hero Sub-text',         'We are pioneers in working to eradicate loneliness in India and the World'],
        ['akela_instagram',   'Instagram URL',         ''],
        ['akela_youtube',     'YouTube URL',           ''],
        ['akela_facebook',    'Facebook URL',          ''],
        ['akela_twitter',     'Twitter/X URL',         ''],
    ];

    foreach ($settings as [$id, $label, $default]) {
        $wp_customize->add_setting($id, ['default' => $default, 'sanitize_callback' => 'sanitize_text_field']);
        $wp_customize->add_control($id, ['label' => $label, 'section' => 'akela_options', 'type' => 'text']);
    }
}
add_action('customize_register', 'akela_customizer');

// ── Helper: get theme mod with fallback ───────────────────────
function akela_mod($key, $default = '') {
    return get_theme_mod($key, $default);
}

// ── Custom Login Logo ──────────────────────────────────────────
function akela_login_logo() { ?>
    <style>
        body.login { background: #f8f9fc; }
        .login h1 a { background-image: none; width: auto; text-align: center; color: #7c4dbb; font-size: 2rem; height: auto; line-height: 1; font-family: 'Playfair Display', serif; }
        .login form { background: #ffffff !important; border: 1px solid rgba(124,77,187,0.15) !important; border-radius: 12px; box-shadow: 0 12px 40px rgba(124, 77, 187, 0.1) !important; padding: 32px !important; }
        .login label { color: #4a5568 !important; }
        .login input[type="text"],.login input[type="password"] { background: #ffffff !important; border-color: rgba(124,77,187,0.2) !important; color: #1a1a2e !important; }
        .wp-core-ui .button-primary { background: #7c4dbb !important; border-color: #7c4dbb !important; }
        .login #backtoblog a, .login #nav a { color: #9a8fb8 !important; }
        .login #backtoblog a:hover, .login #nav a:hover { color: #7c4dbb !important; }
        .login #login_error, .login .message { background: rgba(124,77,187,0.1) !important; border-left: 4px solid #7c4dbb; color: #1a1a2e; }
    </style>
<?php }
add_action('login_enqueue_scripts', 'akela_login_logo');
add_filter('login_headertext', function() { return 'Akela Mann'; });

// ── Custom Admin Menu Pages ────────────────────────────────────
function akela_admin_menus() {
    add_menu_page('Akela Mann Dashboard', 'Akela Mann', 'manage_options', 'akela-dashboard', 'akela_dashboard_page', 'dashicons-heart', 3);
    add_submenu_page('akela-dashboard', 'Bookings', 'Bookings', 'manage_options', 'akela-bookings', 'akela_bookings_page');
    add_submenu_page('akela-dashboard', 'Contact Messages', 'Messages', 'manage_options', 'akela-messages', 'akela_messages_page');
}
add_action('admin_menu', 'akela_admin_menus');

function akela_dashboard_page() {
    $bookings = wp_count_posts('booking')->publish ?? 0;
    $posts    = wp_count_posts('post')->publish ?? 0;
    $videos   = wp_count_posts('video')->publish ?? 0;
    $reels    = wp_count_posts('reel')->publish ?? 0;
    $messages = count(get_option('akela_contact_submissions', []));
    ?>
    <div class="wrap">
        <h1 style="font-family:Georgia,serif;color:#7c4dbb;">🌙 Akela Mann Dashboard</h1>
        <div style="display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-top:24px;">
            <?php
            $stats = [
                ['📅 Bookings', $bookings, 'akela-bookings'],
                ['📝 Blog Posts', $posts, 'edit.php'],
                ['🎬 Videos', $videos, 'edit.php?post_type=video'],
                ['📲 Reels', $reels, 'edit.php?post_type=reel'],
                ['💬 Messages', $messages, 'akela-messages'],
            ];
            foreach ($stats as [$label, $count, $link]):
            ?>
            <div style="background:#fff;border-radius:12px;padding:24px;text-align:center;box-shadow:0 2px 8px rgba(0,0,0,0.1);border-left:4px solid #7c4dbb;">
                <div style="font-size:2rem;font-weight:700;color:#7c4dbb;"><?= $count ?></div>
                <div style="margin-top:8px;color:#444;"><?= $label ?></div>
                <a href="<?= admin_url($link) ?>" style="font-size:0.8rem;margin-top:8px;display:block;color:#7c4dbb;">View →</a>
            </div>
            <?php endforeach; ?>
        </div>
        <div style="margin-top:32px;">
            <h2>Quick Links</h2>
            <p>
                <a href="<?= admin_url('post-new.php') ?>" class="button button-primary">+ New Blog Post</a>&nbsp;
                <a href="<?= admin_url('post-new.php?post_type=video') ?>" class="button">+ Add Video</a>&nbsp;
                <a href="<?= admin_url('post-new.php?post_type=reel') ?>" class="button">+ Add Reel</a>&nbsp;
                <a href="<?= admin_url('post-new.php?post_type=testimonial') ?>" class="button">+ Add Testimonial</a>
            </p>
        </div>
    </div>
    <?php
}

function akela_bookings_page() {
    $bookings = get_posts(['post_type' => 'booking', 'numberposts' => -1, 'orderby' => 'date', 'order' => 'DESC']);
    echo '<div class="wrap"><h1>📅 Bookings</h1>';
    echo '<table class="wp-list-table widefat fixed striped" style="margin-top:16px;">';
    echo '<thead><tr><th>Name</th><th>Email</th><th>Phone</th><th>Session Type</th><th>Date</th><th>Time</th><th>Status</th><th>Submitted</th></tr></thead><tbody>';
    foreach ($bookings as $b) {
        $name  = get_post_meta($b->ID, '_client_name', true);
        $email = get_post_meta($b->ID, '_client_email', true);
        $phone = get_post_meta($b->ID, '_client_phone', true);
        $type  = get_post_meta($b->ID, '_client_session_type', true);
        $date  = get_post_meta($b->ID, '_client_session_date', true);
        $time  = get_post_meta($b->ID, '_client_session_time', true);
        $status= get_post_meta($b->ID, '_status', true) ?: 'Pending';
        $color = $status === 'Confirmed' ? 'green' : ($status === 'Cancelled' ? 'red' : 'orange');
        echo "<tr><td>$name</td><td>$email</td><td>$phone</td><td>$type</td><td>$date</td><td>$time</td><td><span style='color:$color;font-weight:600;'>$status</span></td><td>" . get_the_date('d M Y', $b) . '</td></tr>';
    }
    echo '</tbody></table></div>';
}

function akela_messages_page() {
    $messages = get_option('akela_contact_submissions', []);
    echo '<div class="wrap"><h1>💬 Contact Messages</h1>';
    echo '<table class="wp-list-table widefat fixed striped" style="margin-top:16px;">';
    echo '<thead><tr><th>Name</th><th>Email</th><th>Message</th><th>Date</th></tr></thead><tbody>';
    foreach (array_reverse($messages) as $m) {
        echo '<tr><td>' . esc_html($m['name']) . '</td><td>' . esc_html($m['email']) . '</td><td>' . esc_html(substr($m['message'],0,100)) . (strlen($m['message'])>100?'…':'') . '</td><td>' . esc_html($m['date']) . '</td></tr>';
    }
    echo '</tbody></table></div>';
}

// ── Excerpt Length ─────────────────────────────────────────────
add_filter('excerpt_length', fn() => 22);
add_filter('excerpt_more',   fn() => '…');

// ── Body Classes ───────────────────────────────────────────────
add_filter('body_class', function($classes) {
    $classes[] = 'akela-theme';
    return $classes;
});
// ── Disable Admin Bar ──────────────────────────────────────────
add_filter('show_admin_bar', '__return_false');

// ── Auto-create Blog Posts ──────────────────────────────────
function akela_create_blog_posts() {
    // Delete default "Hello world!" post if it exists
    $hello_world = get_page_by_path('hello-world', OBJECT, 'post');
    if ($hello_world) {
        wp_delete_post($hello_world->ID, true);
    }

    $approved_titles = [
        'Loneliness in 2025',
        'KHUSHI (HAPPINESS)',
        'I am bored of Life',
        'The antidote to loneliness',
        'The Fundamental Reality of Life'
    ];

    // Delete any posts that are NOT in the approved list
    $all_current_posts = get_posts(['post_type' => 'post', 'numberposts' => -1, 'post_status' => 'any']);
    if (!empty($all_current_posts)) {
        foreach ($all_current_posts as $cp) {
            if (!in_array($cp->post_title, $approved_titles)) {
                wp_delete_post($cp->ID, true);
            }
        }
    }

    $posts = [
        [
            'title' => 'Loneliness in 2025',
            'content' => '<p>We are nearing the end of 2025. It is September and the next year is not far away. 2025 has been my loneliest year on record. I didn\'t make any new friends. I lost touch with most of the old ones. I couldn\'t find much avenues for socialising or meeting new people.</p>

<p>First six months passed away quite fast and I barely felt anything special. But in a way I have a deep thought, that I want to share today. After the end of pandemic, which was around mid 2022 or early 2023, I feel that there has been a dynamic change in the way people communicate or relate with each other. People moved apart from one another emotionally and inter-relations got distanced.</p>

<p>Loneliness was anyways a growing issue before 2020 but got amplified even further since then. In 2025, loneliness is a public health crisis. In my limited experience or in my worldview, I see that even neighbours hardly talk to each other unlike before. But in my understanding, to solve loneliness by talking about friendships or community would be a great foolishness. Let me explain this.</p>

<p>We think that a lonely person can just solve his problems by socialising or actively putting himself or herself out there or making friends. Surely this a wrong concept. I tried to attend or even host few meetups and yes online dating or anything else that would make me come close to different people. But it didn\'t help my loneliness or belonging to a community.</p>

<p>Loneliness is here to stay for a long time. It\'s not like malaria or dengue that can be solved via a medication. And I don\'t think many people in the public or private sector bother about loneliness in this capitalistic or consumeristic era.</p>

<p>We are happy expanding technologies that drive the loneliness economy and make people move away from each other. But I am in no mood to talk about artificial intelligence or robotic devices today.</p>

<p>Coming back to September 2025, I want my readers to ask themselves a few questions like "Are you actually looking to make new friends?" "Do you feel that loneliness is a pressing issue today?" and "Why even bother about loneliness?"</p>

<p>Finally, I will say that if you are lonely and after reading this, you feel like reaching out to me, I will be happy to talk and discuss about anything that we can. There are many ways to reach out via my number on the website or my mail address. I am a happy-go-lucky man. I love to challenge convention. I love to live on the edge, and I absolutely love to talk to new people. So take that step and reach out to me. Tata, bye, take care and loads of love to you all.</p>',
            'date' => '2025-09-17 12:00:00',
            'categories' => ['Life in 2025', 'loneliness'],
            'image' => 'loneliness.png'
        ],
        [
            'title' => 'KHUSHI (HAPPINESS)',
            'content' => '<p>Namaste Mitron, Kaise ho aap sab log?</p>
<p>Mera naam Nishant hai. Mai Mumbai se hu.</p>
<p>Mujhe likhna pasand hai aur alag alag topics pe likhne ki icha hoti hai.</p>
<p>Aaj hum baat karenge "KHUSHI" matlab "HAPPINESS" ke baare mai.</p>
<p>Happiness jo mushkil se hi milti hai aur fir milne ke baad chali jaati hai. Happiness shayad is duniya ke sabhi log chahte hai. Aur usi ke liye hum roz sube jaagte hai. Usi happiness ke liye hum kaam pe jaate hai aur itni mehnat karte hai. Par ye happiness hume uske peeche bhagaati hi rehti hai zindagi bhar.</p>
<p>To savaal hai -- "Kya aap log aaj khush ho?"</p>
<p>Mujhe lagta hai ke paise se hi khushi khareed sakte hai. Aur kuch to Bhagwan ne banaya nahi. Lekin paise se khushi khareed sakte hai jo is duniya mai hai. Hum woh khushi nahi khareed sakte jo dusri duniya mai hai.</p>
<p>Jaise ki hum paise se kapde, mobiles, ghar, aur ye sab khareed sakte hai aur kuch logo ko isme khushi milti hogi. Par kaafi saari khushiya to kahi aur hi chupi hai. Jise Insaan shayad bhul jaata hai.</p>
<p>Pyaar, Dosti, Apnapan, Ek acha parivaar, pet bhar khaana, Maa ka pyaar, bina chinta vala Jeevan, ye sab hoti hai asli khushi. Aur ye saari khushiyan sab ke naseeb mai nahi hoti hai.</p>
<p>Happiness to milna fir muskhil hi hai is Zindagi mai sab ke liye. To kya kare? Hai kisi ke paas sahi javaab?</p>
<p>Everything has been said about happiness in various places and in different formats. What more is there to say? </p>
<p>Once again, I repeat that happiness is sometimes found in temporary material objects, in victories, in achieving goals, in almost every other thing that the world has to offer to us.</p>
<p>But there is another world, and beyond this temporary happiness lies a permanent happiness.</p>
<p>So, how will we reach that place? Who will guide us towards that? We want something that is far superior than what we see with our eyes.</p>
<p>Namaste Mitron, Aapka din acha rahe.</p>',
            'date' => '2025-07-26 12:00:00',
            'categories' => ['Happiness', 'loneliness'],
            'image' => 'happiness.png'
        ],
        [
            'title' => 'I am bored of Life',
            'content' => '<p>It\'s July 2025 and I am bored of my life. This is a popular sentiment and I am just conveying the feelings of million others. What are we supposed to do in 2025 ?</p>
<p>We are men. We can only fight wars. We can only carry swords and weapons and capture lands.</p>
<p>But in 2025, we are building businesses to sell products to people who themselves have no clue what they want. Time to wake up my men and ladies.</p>
<p>In India, the people follow a routine of getting a good job in order to find a good girl for marriage. My main concern is that this routine should be stopped. Marriages should be delayed. Purpose in life and larger goals should be pursued by men and women. Figure it out. This could be anything from serving the society through art, literature, writing books, creating blogs, making movies that are purposeful or radical, creative pursuits, joining local political groups, even social entrepreneurship, running volunteering groups, building an NGO, etc</p>
<p>Men and women need a force or mentor that can steer them through this crisis.</p>
<p>Are we supposed to be spending time on Instagram the whole day doomscrolling or chatting with apps like ChatGPT or Perplexity ?</p>
<p>What we need is a real human touch, kiss and cuddles !</p>
<p>We are getting alienated from each other. We need to open our hearts and start talking verbally with each other like we did before the advent of mobiles.</p>
<p>Masculinity is dying. In my view, I see that the only way to revive the real authentic version of masculinity is firstly through a deep inquiry or questioning the status quo. Answers will take some time to emerge.</p>
<p>We need something or the other to make the world come alive. Frankly, I do not have all the solutions in hand right away.</p>
<p>We need to integrate a culture of risk and dynamism amongst the youth. The young men and women must be willing to sacrifice short term gains for a life of purpose, adventure and thrill.</p>
<p>Finally, I will conclude by saying that I am open to suggestions by you all. Do let me know what you feel about this ! Also in case, I have missed some vital points, then comment below. I would be pleased to accept all viewpoints. Better still, call me and let\'s discuss.</p>
<p>Time to rise and fight for our dignity and throne.</p>',
            'date' => '2025-07-23 12:00:00',
            'categories' => ['Boredom', 'Life in 2025'],
            'image' => 'boredom.png'
        ],
        [
            'title' => 'The antidote to loneliness',
            'content' => '<p>The antidote to loneliness is talking. Ironic isn\'t it? Loneliness is a result of not being around people or not feeling heard or not being communicated.</p>
<p>But after years of studying this field and also having been lonely for an extensive amount of time in my youth, I realise that talking is the most effective way to counter loneliness.</p>
<p>The important part then is to talk to whom. If you are lonely and don\'t have any friends, then it becomes difficult. Parents don\'t necessarily fill that void after a certain age. Having siblings or close relatives is not for all. But my suggestion is to start talking to your near and dear ones first.</p>
<p>We all have collectively stopped talking. In 2025, we are either texting or chatting to an AI app, or whiling away time engaging with games or social media or say music apps. </p>
<p>When was the last time you spoke with someone close and didn\'t recollect how an hour passed by ? Never. Not in the recent past. So my advice is to bring this lost art of talking again to the forefront. I absolutely love talking so much that I end up talking and shouting to myself all the time, if I don\'t find anyone. </p>
<p>Better still go out of the house or your self-created cocoon, and start talking to security guards, nearby people or say even irrelevant people for time-being to start the habit.</p>
<p>And the fun part is you can call me. I will be your friend. Because I love talking a lot. And that is the best way out of loneliness.</p>',
            'date' => '2025-07-19 12:00:00',
            'categories' => ['loneliness', 'Kiss and cuddles'],
            'image' => 'antidote.png'
        ],
        [
            'title' => 'The Fundamental Reality of Life',
            'content' => '<p>The fundamental reality of life is that we have to exist somewhere on the Earth at a particular reference point.</p>
<p>This means that when we are eating food or walking or driving our cars, or engrossed in our work or creating that business, we are in reality existing.</p>
<p>We do work as a means not to derive something out of it but as a way to exist for the sake of existence, for someone did send us here. And we can say for time being that our dharma, our karma, our past, our future, our destiny are stories created by us to justify this existence.</p>
<p>If at all you are feeling lost in life and stuck or confused beyond measure, I highly recommend you to start writing in a notebook, your own thoughts and reflections. Why is this related to this ? Because I see everyday, thousands of people wasting their lives and roaming the world clueless. But if you realise once that what we do is simply to exist primarily on this planet, a certain amount of fear vanishes and freedom begins.</p>',
            'date' => '2025-07-18 12:00:00',
            'categories' => ['Spiritual Awakening', 'Life in 2025'],
            'image' => 'reality.png'
        ]
    ];

    foreach ($posts as $idx => $p) {
        $slug = sanitize_title($p['title']);
        $existing = get_posts(['name' => $slug, 'post_type' => 'post', 'numberposts' => 1, 'post_status' => 'any']);
        
        $post_data = [
            'post_title'   => $p['title'],
            'post_content' => $p['content'],
            'post_status'  => 'publish',
            'post_type'    => 'post',
            'post_date'    => $p['date'],
            'menu_order'   => $idx
        ];

        if (!empty($existing)) {
            $post_data['ID'] = $existing[0]->ID;
            wp_update_post($post_data);
            $post_id = $existing[0]->ID;
        } else {
            $post_id = wp_insert_post($post_data);
        }

        if ($post_id) {
            update_post_meta($post_id, '_akela_post_image', $p['image']);

            $cat_ids = [];
            foreach ($p['categories'] as $cat_name) {
                $term = term_exists($cat_name, 'category');
                if (!$term) {
                    $term = wp_insert_term($cat_name, 'category');
                }
                if (!is_wp_error($term) && !empty($term)) {
                    $cat_ids[] = (int) (isset($term['term_id']) ? $term['term_id'] : (isset($term->term_id) ? $term->term_id : $term));
                }
            }
            wp_set_post_categories($post_id, $cat_ids);
        }
    }
}
add_action('init', 'akela_create_blog_posts');
