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
            ['🧘', 'Embrace Solo Dating', '₹0 — Free', 'Discover yourself, build self-love and learn to date yourself.', ['Self-guided itineraries', 'Mindful activities', 'Available online']],
            ['🌅', 'Life Rediscovery Sessions', '₹1,000/session', 'Reconnect with your passions and map out a fresh future.', ['1-on-1 private coaching', 'Personalized vision board', '60-min session']],
            ['💜', 'Therapy Dating', '₹1,500/session', 'Empathetic guidance integrated with your dating journey.', ['Certified relationship therapist', 'Safe environment', 'Confidential sessions']],
            ['🎭', 'One Night Stand Experience', '₹2,000/experience', 'Safe, structured experiences to explore intimacy and boundaries.', ['Strict safety protocols', 'Pre-experience briefing', 'Explore intimacy boundaries']],
            ['⏳', 'Single beyond 35/40/45', '₹500/session', 'Support and guidance for navigating mature singlehood.', ['Group discussion', 'Shared experiences', 'Weekly moderation']],
            ['👻', 'The Ghost of Lust', '₹1,200/session', 'Understanding your sexual desires and emotional connections.', ['Deep emotional exploration', 'Desire mapping', '1-on-1 guidance']],
            ['🔓', 'Free Sex in India', '₹0 — Free', 'Educational talks and workshops on sexual health and taboos.', ['Awareness workshops', 'Expert panel discussions', 'Open to all']],
            ['👩', 'Solo Women’s Needs', '₹1,000/session', 'Dedicated safe space and coaching for women’s fulfillment.', ['Women-only coaching', 'Safe sharing space', 'Emotional empowerment']],
            ['🤱', 'Love is Motherly', '₹0 — Free', 'Unconditional nurturing care and emotional support.', ['Empathetic listening', 'Warm emotional sanctuary', 'Nurturing conversation']],
            ['🎉', 'Akela Mann Party', '₹500/entry', 'Social gatherings for solo dating seekers to connect.', ['Curated social mixer', 'In-person events', 'Meet like-minded seekers']],
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
