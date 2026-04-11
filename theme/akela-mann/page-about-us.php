<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">Who We Are</div>
        <h1 class="section-title">About <span>Akela Mann</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → About Us</div>
    </div>
</section>

<!-- Mission -->
<section class="section-pad">
    <div class="container">
        <div class="grid-2">
            <div data-aos="fade-right">
                <div class="section-tag">Our Story</div>
                <h2 class="section-title">Akela Mann means a <span>Lonely Mind</span></h2>
                <p>We are your friends-in-need. We are pioneers in working to eradicate loneliness in India and the World.</p>
                <p><strong>Our Mission:</strong> At AKELA MANN, our mission is to support people feeling lonely and socially isolated by bringing joy, happiness, and a sense of community into their lives.</p>
                <p>Founded by <strong>Nishant Hemrajani</strong>, we believe that no one should have to carry the weight of loneliness alone. We are here to listen, to talk, and to heal.</p>
            </div>
            <div data-aos="fade-left" data-aos-delay="200">
                <img src="<?php echo get_template_directory_uri(); ?>/images/about.png" alt="Community" style="border-radius:16px;border:1px solid rgba(164,123,224,0.25);box-shadow:0 16px 64px rgba(124,77,187,0.2);">
            </div>
        </div>
    </div>
</section>

<!-- Values -->
<section class="section-pad" style="background:#ffffff;">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-tag">What Drives Us</div>
            <h2 class="section-title">Our Core <span>Values</span></h2>
        </div>
        <div class="grid-4">
            <?php
            $values = [
                ['💜', 'Compassion', 'Every conversation starts with empathy and ends with care.'],
                ['🌍', 'Community', 'No one heals alone. Together, we build bridges across isolation.'],
                ['🔒', 'Confidentiality', 'Your stories are safe with us — always.'],
                ['🌱', 'Growth', 'We believe in every person\'s capacity to heal and thrive.'],
            ];
            foreach ($values as [$icon, $title, $desc]):
            ?>
            <div class="glass-card text-center floating-el" data-aos="zoom-in" style="animation-delay: <?php echo rand(0, 3); ?>s;">
                <div style="font-size:2.5rem;margin-bottom:16px;"><?php echo $icon; ?></div>
                <h3><?php echo $title; ?></h3>
                <p><?php echo $desc; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Team -->
<section class="section-pad">
    <div class="container">
        <div class="text-center" data-aos="fade-up">
            <div class="section-tag">The People Behind the Mission</div>
            <h2 class="section-title">Meet Our <span>Team</span></h2>
        </div>
        <div class="grid-3">
            <?php
            $team = [
                ['N', 'Nishant Hemrajani', 'Founder & Visionary', 'Started Akela Mann after realising loneliness was India\'s silent epidemic. Passionate speaker and community builder.'],
                ['S', 'Sunita Rao', 'Lead Counsellor', '12+ years of experience in emotional wellness and cognitive behavioural therapy.'],
                ['K', 'Kabir Mehta', 'Community Director', 'Believes in the power of in-person connection. Organises events across 15 Indian cities.'],
            ];
            foreach ($team as [$initial, $name, $role, $bio]):
            ?>
            <div class="glass-card text-center floating-el" data-aos="fade-up" style="animation-delay: <?php echo rand(0, 3); ?>s;">
                <div style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#7c4dbb,#2d1b60);margin:0 auto 16px;display:flex;align-items:center;justify-content:center;font-size:2rem;font-weight:700;color:#fff;font-family:'Playfair Display',serif;">
                    <?php echo $initial; ?>
                </div>
                <h3><?php echo $name; ?></h3>
                <p style="color:#7c4dbb;font-size:0.85rem;font-weight:600;"><?php echo $role; ?></p>
                <p style="font-size:0.88rem;"><?php echo $bio; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Join CTA -->
<section class="section-pad-sm" style="background:linear-gradient(135deg,#f0edf8,#ffffff);">
    <div class="container text-center">
        <h2 class="section-title">Ready to Take the <span>First Step?</span></h2>
        <p class="section-subtitle">Book a free session and let our team walk this path with you.</p>
        <a href="<?php echo home_url('/booking'); ?>" class="btn btn-primary">Book a Free Session ✨</a>
    </div>
</section>

<?php get_footer(); ?>
