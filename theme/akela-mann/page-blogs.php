<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <div class="section-tag">Stories &amp; Insights</div>
        <h1 class="section-title">Our <span>Blog</span></h1>
        <div class="breadcrumb"><a href="<?php echo home_url('/'); ?>">Home</a> → Blogs</div>
    </div>
</section>

<section class="section-pad">
    <div class="container">
        <!-- Category Filter -->
        <div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:48px;justify-content:center;" data-aos="fade-up">
            <?php
            $cats = get_categories(['hide_empty' => false]);
            echo '<a href="' . home_url('/blogs') . '" class="btn btn-primary" style="padding:10px 20px;font-size:0.85rem;">All Stories</a>';
            foreach ($cats as $cat) {
                echo '<a href="' . get_category_link($cat->term_id) . '" class="btn btn-outline" style="padding:10px 20px;font-size:0.85rem;">' . esc_html($cat->name) . '</a>';
            }
            ?>
        </div>

        <div class="grid-3">
            <?php
            $paged = get_query_var('paged') ?: 1;
            $blog_query = new WP_Query(['post_status' => 'publish', 'posts_per_page' => 9, 'paged' => $paged]);
            if ($blog_query->have_posts()):
                while ($blog_query->have_posts()): $blog_query->the_post();
            ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="100">
                <?php 
                $img_name = get_post_meta(get_the_ID(), '_akela_post_image', true);
                if ($img_name): ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($img_name); ?>" class="blog-card-img" alt="<?php the_title(); ?>">
                <?php elseif (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('blog-thumb', ['class' => 'blog-card-img']); ?>
                <?php else: ?>
                    <?php
                    $imgs = ['blog1.png','blog2.png','blog3.png'];
                    $img  = $imgs[get_the_ID() % 3];
                    ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $img; ?>" class="blog-card-img" alt="">
                <?php endif; ?>
                <div class="blog-card-body">
                    <div class="blog-meta">
                        <span><?php echo get_the_date('d M Y'); ?></span> · <?php the_category(', '); ?>
                    </div>
                    <h3><?php the_title(); ?></h3>
                    <p><?php the_excerpt(); ?></p>
                    <a href="<?php the_permalink(); ?>" class="read-more">Read Story →</a>
                </div>
            </div>
            <?php endwhile; wp_reset_postdata();
            else:
            $placeholders = [
                ['blog1.png', '08 Mar 2026', 'Loneliness', 'The Quiet Room', 'What happens when the silence of your own apartment becomes deafening? One person\'s journey from isolation to community.'],
                ['blog2.png', '02 Mar 2026', 'Healing', 'Stars and Solitude', 'I lay on a hilltop and stared at the Milky Way. For the first time, my loneliness felt cosmic — not personal.'],
                ['blog3.png', '24 Feb 2026', 'Connection', 'The Coffee Shop That Saved Me', 'A stranger\'s smile across a coffee shop table was the first real human moment I\'d had in weeks.'],
                ['blog1.png', '18 Feb 2026', 'Support', 'When Silence Becomes Too Loud', 'There is a specific quality of silence in a full apartment when no one is home to fill it. This is that story.'],
                ['blog2.png', '10 Feb 2026', 'Mindfulness', 'Breathing Through the Loneliness', 'A five-minute breathing practice that helped me reconnect with myself on the hardest days.'],
                ['blog3.png', '02 Feb 2026', 'Community', 'Finding My People at 43', 'I thought making real friends was something only children could do. I was wrong — beautifully wrong.'],
            ];
            foreach ($placeholders as [$img, $date, $cat, $title, $excerpt]):
            ?>
            <div class="blog-card" data-aos="fade-up" data-aos-delay="100">
                <?php 
                $img_name = get_post_meta(get_the_ID(), '_akela_post_image', true);
                if ($img_name): ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/blog/<?php echo esc_attr($img_name); ?>" class="blog-card-img" alt="<?php the_title(); ?>">
                <?php elseif (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('blog-thumb', ['class' => 'blog-card-img']); ?>
                <?php else: ?>
                    <?php
                    $imgs = ['blog1.png','blog2.png','blog3.png'];
                    $img  = $imgs[get_the_ID() % 3];
                    ?>
                    <img src="<?php echo get_template_directory_uri(); ?>/images/<?php echo $img; ?>" class="blog-card-img" alt="">
                <?php endif; ?>
                <div class="blog-card-body">
                    <div class="blog-meta"><span><?php echo $date; ?></span> · <span><?php echo $cat; ?></span></div>
                    <h3><?php echo $title; ?></h3>
                    <p><?php echo $excerpt; ?></p>
                    <a href="#" class="read-more">Read Story →</a>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>

        <!-- Pagination -->
        <?php if (isset($blog_query)): ?>
        <div style="display:flex;justify-content:center;margin-top:48px;">
            <?php echo paginate_links(['total' => $blog_query->max_num_pages, 'current' => $paged, 'prev_text' => '← Prev', 'next_text' => 'Next →']); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
