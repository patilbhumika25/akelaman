<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">What We Offer</div>
        <h1 class="section-title">Our <span>Services</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → Services</div>
    </div>
</section>

<!-- Hero Image -->
<section style="background:#ffffff;padding:0 0 80px;">
    <div class="container">
        <img src="<?php echo get_template_directory_uri(); ?>/images/services.png" alt="Services" style="width:100%;border-radius:16px;border:1px solid rgba(124,77,187,0.1);box-shadow:0 32px 80px rgba(124,77,187,0.15);">
    </div>
</section>

<!-- Services Grid -->
<section class="section-pad">
    <div class="container">
        <?php
        $services = [
            ['🗣️', 'Talking Sessions',   '₹0 — Free', 'One-on-one confidential conversations with a compassionate listener. No judgment, only understanding. Available online and in-person.', ['50 min session', 'Video/phone call', 'Available Mon–Fri']],
            ['👥', 'Support Groups',      '₹0 — Free', 'Weekly group sessions where lonely souls come together. Share, listen, and heal in a safe, moderated environment.', ['8–12 participants', 'Every Saturday', 'Online via Zoom']],
            ['🧘', 'Mindfulness Workshops','₹500/session', 'Monthly guided workshops combining breathwork, meditation, and journaling to deepen your relationship with yourself.', ['3-hour workshop', 'Online & in-person', 'Mumbai, Delhi, Bangalore']],
            ['✍️',  'Story Sharing',      '₹0 — Free', 'Submit your loneliness story anonymously. Your words might be the lifeline someone else needs today.', ['Anonymous option', 'Published on blog', 'Any language']],
            ['🎤', 'Community Events',    '₹200/event', 'Curated in-person meetups — coffee mornings, art sessions, nature walks — designed to spark real friendships.', ['15 cities', 'Monthly events', 'Small groups (max 20)']],
            ['🏢', 'Corporate Sessions',  'Custom Pricing', 'Workplace loneliness is real. We offer corporate workshops to help build belonging within teams.', ['2–4 hour sessions', 'For 15–200 employees', 'Certificate provided']],
        ];
        foreach ($services as $i => [$icon, $title, $price, $desc, $features]):
        ?>
        <div class="grid-2" data-aos="fade-up" style="<?php echo $i > 0 ? 'margin-top:48px;padding-top:48px;border-top:1px solid rgba(164,123,224,0.1);' : ''; ?><?php echo $i % 2 === 1 ? 'direction:rtl;' : ''; ?>">
            <div style="<?php echo $i % 2 === 1 ? 'direction:ltr;' : ''; ?>">
                <div class="service-icon" style="font-size:2rem;width:72px;height:72px;"><?php echo $icon; ?></div>
                <h2 class="section-title" style="font-size:2rem;"><?php echo $title; ?></h2>
                <div style="display:inline-block;background:rgba(124,77,187,0.2);border:1px solid rgba(124,77,187,0.4);padding:6px 18px;border-radius:50px;font-size:0.85rem;color:#c9b8e8;margin-bottom:16px;"><?php echo $price; ?></div>
                <p><?php echo $desc; ?></p>
                <ul style="list-style:none;padding:0;margin:16px 0 24px;">
                    <?php foreach ($features as $f): ?>
                    <li style="display:flex;align-items:center;gap:10px;color:#9a8fb8;font-size:0.9rem;margin-bottom:8px;">
                        <span style="color:#7c4dbb;">✓</span> <?php echo $f; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?php echo home_url('/booking'); ?>" class="btn btn-primary">Book Now →</a>
            </div>
            <div style="<?php echo $i % 2 === 1 ? 'direction:ltr;' : ''; ?>">
                <div class="glass-card" style="padding:48px;text-align:center;">
                    <div style="font-size:5rem;margin-bottom:24px;"><?php echo $icon; ?></div>
                    <h3 style="font-size:1.5rem;margin-bottom:12px;"><?php echo $title; ?></h3>
                    <p style="font-size:0.9rem;"><?php echo $desc; ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- CTA -->
<section class="section-pad-sm" style="background:linear-gradient(135deg,#f0edf8,#ffffff);">
    <div class="container text-center">
        <h2 class="section-title">Not Sure Which Service is Right for You?</h2>
        <p class="section-subtitle">Talk to us first — completely free, no commitment.</p>
        <a href="<?php echo home_url('/contact-us'); ?>" class="btn btn-primary">Talk to Us First →</a>
    </div>
</section>

<?php get_footer(); ?>
