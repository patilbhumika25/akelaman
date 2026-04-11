/* Akela Mann – main.js */

document.addEventListener('DOMContentLoaded', () => {

    /* ── Sticky Navigation Scroll Effect ─────────────────────── */
    const header = document.querySelector('.site-header');
    if (header) {
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 50);
        });
    }

    /* ── Mobile Menu Toggle ───────────────────────────────────── */
    const hamburger = document.querySelector('.hamburger');
    const mainNav = document.querySelector('.main-nav');
    if (hamburger && mainNav) {
        hamburger.addEventListener('click', () => {
            mainNav.classList.toggle('open');
            hamburger.classList.toggle('active');
            document.body.classList.toggle('no-scroll');
        });
    }

    /* Close nav on link click */
    document.querySelectorAll('.main-nav ul li a').forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            const linkText = link.textContent.toLowerCase().trim();
            const isHomePage = window.location.pathname === '/' || window.location.pathname.endsWith('index.php');
            
            // Map link text to section IDs for a robust experience
            const anchorMap = {
                'about us': 'testimonials-section',
                'services': 'services-section',
                'blogs': 'blog-section',
                'contact': 'site-footer',
                'booking': 'booking-section'
            };

            let targetId = '';
            for (const [text, id] of Object.entries(anchorMap)) {
                if (linkText.includes(text) || (href && href.includes('#' + id))) {
                    targetId = id;
                    break;
                }
            }
            
            if (targetId) {
                const targetEl = document.getElementById(targetId);
                
                if (targetEl && isHomePage) {
                    e.preventDefault();
                    const headerOffset = header ? header.offsetHeight : 0;
                    const elementPosition = targetEl.getBoundingClientRect().top;
                    const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

                    window.scrollTo({
                        top: offsetPosition,
                        behavior: "smooth"
                    });
                } else if (!isHomePage || !targetEl) {
                    // If not on home page, or target doesn't exist yet, force redirect
                    e.preventDefault();
                    window.location.href = (typeof AkelaVars !== 'undefined' ? AkelaVars.home_url : '/') + '#' + targetId;
                }
            }
            
            mainNav.classList.remove('open');
            hamburger?.classList.remove('active');
            document.body.classList.remove('no-scroll');
        });
    });

    /* ── Initialize AOS Animations ────────────────────────────── */
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true,
            offset: 50,
        });
    }

    /* ── Stats Counter Animation ──────────────────────────────── */
    function animateCount(el, target, duration = 2000) {
        const start = performance.now();
        const isDecimal = target % 1 !== 0;
        const step = (now) => {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            const eased = progress < 0.5
                ? 4 * progress * progress * progress
                : 1 - Math.pow(-2 * progress + 2, 3) / 2;
            const current = eased * target;
            el.textContent = isDecimal ? current.toFixed(1) : Math.floor(current).toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target.toLocaleString();
        };
        requestAnimationFrame(step);
    }

    const statNumbers = document.querySelectorAll('.stat-number[data-count]');
    if (statNumbers.length && 'IntersectionObserver' in window) {
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting && !e.target.dataset.animated) {
                    e.target.dataset.animated = 'true';
                    animateCount(e.target, parseFloat(e.target.dataset.count));
                    statsObserver.unobserve(e.target);
                }
            });
        }, { threshold: 0.5 });
        statNumbers.forEach(el => statsObserver.observe(el));
    }

    /* ── Particle Generator (Hero) ────────────────────────────── */
    const particleContainer = document.querySelector('.particles');
    if (particleContainer) {
        for (let i = 0; i < 25; i++) {
            const p = document.createElement('div');
            p.className = 'particle';
            const size = Math.random() * 3 + 1;
            p.style.cssText = `
                left: ${Math.random() * 100}%;
                width: ${size}px;
                height: ${size}px;
                animation-duration: ${Math.random() * 15 + 10}s;
                animation-delay: ${Math.random() * -20}s;
                opacity: ${Math.random() * 0.5 + 0.1};
            `;
            particleContainer.appendChild(p);
        }
    }

    /* ── Testimonial Slider ───────────────────────────────────── */
    const track = document.querySelector('.testimonials-track');
    const slides = document.querySelectorAll('.testimonial-card');
    const prevBtn = document.querySelector('.testimonial-prev');
    const nextBtn = document.querySelector('.testimonial-next');
    const dotsContainer = document.querySelector('.testimonial-dots');

    if (track && slides.length) {
        let current = 0;
        const total = slides.length;

        // Build dots
        if (dotsContainer) {
            slides.forEach((_, i) => {
                const dot = document.createElement('button');
                dot.className = 'dot' + (i === 0 ? ' active' : '');
                dot.setAttribute('aria-label', `Testimonial ${i + 1}`);
                dot.addEventListener('click', () => goTo(i));
                dotsContainer.appendChild(dot);
            });
        }

        function goTo(index) {
            current = (index + total) % total;
            track.style.transform = `translateX(-${current * 100}%)`;
            dotsContainer?.querySelectorAll('.dot').forEach((d, i) => {
                d.classList.toggle('active', i === current);
            });
        }

        prevBtn?.addEventListener('click', () => goTo(current - 1));
        nextBtn?.addEventListener('click', () => goTo(current + 1));

        // Auto-advance
        setInterval(() => goTo(current + 1), 5000);
    }

    /* ── Booking Type Selector ────────────────────────────────── */
    document.querySelectorAll('.booking-type').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.booking-type').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            const type = btn.dataset.type;
            const typeInput = document.getElementById('session_type');
            if (typeInput) typeInput.value = type;
        });
    });

    /* ── Form Success Handling ────────────────────────────────── */
    function handleForm(formSelector, successMsg) {
        const form = document.querySelector(formSelector);
        if (!form) return;
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            const data = Object.fromEntries(new FormData(form));
            // Save to localStorage
            const key = formSelector.replace('#', '') + '_submissions';
            const existing = JSON.parse(localStorage.getItem(key) || '[]');
            existing.push({ ...data, date: new Date().toISOString() });
            localStorage.setItem(key, JSON.stringify(existing));
            form.innerHTML = `
                <div class="success-message" style="text-align:center;padding:48px 24px;">
                    <div style="font-size:3rem;margin-bottom:16px;">✨</div>
                    <h3 style="font-family:var(--font-heading);margin-bottom:12px;color:var(--accent-lavender)">${successMsg}</h3>
                    <p style="color:var(--text-muted)">We'll get back to you within 24 hours.</p>
                </div>`;
        });
    }

    handleForm('#contact-form', 'Your message has been sent!');
    handleForm('#booking-form', 'Your session is booked!');

    /* ── Modal (Reels) ────────────────────────────────────────── */
    const modal = document.getElementById('reel-modal');
    const modalVid = document.getElementById('modal-video-frame');
    const modalClose = document.getElementById('modal-close');

    document.querySelectorAll('.reel-item[data-src]').forEach(item => {
        item.addEventListener('click', () => {
            if (!modal || !modalVid) return;
            modalVid.src = item.dataset.src;
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        });
    });

    modalClose?.addEventListener('click', closeModal);
    modal?.addEventListener('click', (e) => { if (e.target === modal) closeModal(); });
    document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });

    function closeModal() {
        if (!modal || !modalVid) return;
        modal.style.display = 'none';
        modalVid.src = '';
        document.body.style.overflow = '';
    }

    /* ── Active Nav Highlight ─────────────────────────────────── */
    const currentPath = window.location.pathname.split('/').pop() || 'index.html';
    document.querySelectorAll('.main-nav a').forEach(a => {
        const href = a.getAttribute('href')?.split('/').pop();
        if (href === currentPath) {
            a.closest('li')?.classList.add('current-menu-item');
        }
    });

    /* ── WhatsApp Float Button ────────────────────────────────── */
    /* ── Booking Calendar Logic ──────────────────────────────── */
    class BookingCalendar {
        constructor(container, dateInputId, timeInputId, slotsContainerId, slotsListId) {
            this.container = container;
            this.dateInput = document.getElementById(dateInputId);
            this.timeInput = document.getElementById(timeInputId);
            this.slotsContainer = document.getElementById(slotsContainerId);
            this.slotsList = document.getElementById(slotsListId);
            
            this.date = new Date();
            this.selectedDate = null;
            this.render();
        }

        render() {
            if (!this.container) return;
            const year = this.date.getFullYear();
            const month = this.date.toLocaleString('default', { month: 'long' });
            const firstDay = new Date(year, this.date.getMonth(), 1).getDay();
            const lastDate = new Date(year, this.date.getMonth() + 1, 0).getDate();
            const today = new Date();
            today.setHours(0,0,0,0);

            let html = `
                <div class="calendar-header">
                    <button type="button" class="cal-btn prev">‹</button>
                    <span class="month-year">${month} <span>${year}</span></span>
                    <button type="button" class="cal-btn next">›</button>
                </div>
                <div class="calendar-grid">
                    <div class="dow">M</div><div class="dow">T</div><div class="dow">W</div>
                    <div class="dow">T</div><div class="dow">F</div><div class="dow">S</div><div class="dow">S</div>
            `;

            for (let i = 0; i < (firstDay === 0 ? 6 : firstDay - 1); i++) html += '<div class="day empty"></div>';
            
            for (let i = 1; i <= lastDate; i++) {
                const current = new Date(year, this.date.getMonth(), i);
                const isPast = current < today;
                const dayOfWeek = current.getDay(); // 0 = Sunday, 6 = Saturday
                const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
                const isDisabled = isPast || isWeekend;
                const isSelected = this.selectedDate && current.getTime() === this.selectedDate.getTime();
                const cls = `day ${isDisabled ? 'past' : 'active'} ${isWeekend && !isPast ? 'weekend-closed' : ''} ${isSelected ? 'selected' : ''}`;
                
                // Lumora-style indicator logic (mock availability)
                let indicatorClass = '';
                if (!isDisabled) {
                    const rnd = (i % 3);
                    if (rnd === 0) indicatorClass = 'high'; // High availability
                    else if (rnd === 1) indicatorClass = 'med';
                    else indicatorClass = 'low';
                }

                html += `
                    <div class="${cls}" data-date="${year}-${this.date.getMonth()+1}-${i}" ${isWeekend ? 'title="Closed on weekends"' : ''}>
                        <span class="day-num">${i}</span>
                        ${!isDisabled ? `<div class="day-indicator ${indicatorClass}"></div>` : ''}
                    </div>`;
            }

            html += '</div>';
            this.container.innerHTML = html;

            this.container.querySelector('.prev').onclick = (e) => { e.preventDefault(); this.date.setMonth(this.date.getMonth() - 1); this.render(); };
            this.container.querySelector('.next').onclick = (e) => { e.preventDefault(); this.date.setMonth(this.date.getMonth() + 1); this.render(); };
            
            this.container.querySelectorAll('.day.active').forEach(el => {
                el.onclick = (e) => { e.preventDefault(); this.selectDate(el.dataset.date); };
            });
        }

        selectDate(dateStr) {
            const [y, m, d] = dateStr.split('-').map(Number);
            this.selectedDate = new Date(y, m - 1, d);
            const dayOfWeek = this.selectedDate.getDay();
            const isWeekend = (dayOfWeek === 0 || dayOfWeek === 6);
            this.render();
            
            const formatted = this.selectedDate.toLocaleDateString('en-GB', { day:'numeric', month:'short', year:'numeric' });
            if (this.dateInput) this.dateInput.value = formatted;
            
            if (this.slotsContainer && this.slotsList) {
                this.slotsContainer.style.display = 'block';

                if (isWeekend) {
                    this.slotsList.innerHTML = `
                        <div style="padding:16px;text-align:center;color:#856404;background:#fff9e6;border-radius:8px;">
                            <strong>Closed on weekends</strong><br>
                            <span style="font-size:0.9rem;">We are available Mon–Fri, 9:00 AM – 5:00 PM</span>
                        </div>
                    `;
                } else {
                    this.slotsList.innerHTML = `
                        <button type="button" class="slot-btn" data-time="09:00 - 10:00 AM">09:00 AM</button>
                        <button type="button" class="slot-btn" data-time="10:00 - 11:00 AM">10:00 AM</button>
                        <button type="button" class="slot-btn" data-time="11:00 - 12:00 PM">11:00 AM</button>
                        <button type="button" class="slot-btn" data-time="12:00 - 01:00 PM">12:00 PM</button>
                        <button type="button" class="slot-btn" data-time="01:00 - 02:00 PM">01:00 PM</button>
                        <button type="button" class="slot-btn" data-time="02:00 - 03:00 PM">02:00 PM</button>
                        <button type="button" class="slot-btn" data-time="03:00 - 04:00 PM">03:00 PM</button>
                        <button type="button" class="slot-btn" data-time="04:00 - 05:00 PM">04:00 PM</button>
                    `;
                    this.slotsList.querySelectorAll('.slot-btn').forEach(s => {
                        s.onclick = (e) => {
                            e.preventDefault();
                            this.slotsList.querySelectorAll('.slot-btn').forEach(x => x.classList.remove('selected'));
                            s.classList.add('selected');
                            if (this.timeInput) this.timeInput.value = s.dataset.time;
                        };
                    });
                }
            }
        }
    }
    window.BookingCalendar = BookingCalendar; // Make it global for shortcodes

    // Initialize main booking page calendar if exists
    const mainCalEl = document.getElementById('booking-calendar');
    if (mainCalEl) {
        new BookingCalendar(mainCalEl, 'bk_date', 'bk_time', 'time-slots-container', 'time-slots');
    }

    /* ── Services Infinite Horizontal Slider ────────────────── */
    const servicesContainer = document.querySelector('.services-slider-container');
    const servicesTrack = document.querySelector('.services-slider-track');
    const servicesPrev = document.querySelector('.services-slider-wrapper .slider-arrow.prev');
    const servicesNext = document.querySelector('.services-slider-wrapper .slider-arrow.next');

    if (servicesContainer && servicesTrack) {
        const items = Array.from(servicesTrack.children);
        if (items.length > 0) {
            // Clone items for infinite effect (clone once at start and once at end)
            items.forEach(item => {
                const cloneBefore = item.cloneNode(true);
                const cloneAfter = item.cloneNode(true);
                servicesTrack.appendChild(cloneAfter);
                servicesTrack.insertBefore(cloneBefore, servicesTrack.firstChild);
            });

            const getBubbleWidth = () => {
                const bubble = servicesTrack.querySelector('.service-bubble');
                // Use getBoundingClientRect to get precise width including scaling if any
                return bubble ? bubble.getBoundingClientRect().width + 40 : 280;
            };

            // Calculate widths dynamically to handle resizes
            let itemWidth, totalWidth;
            const updateWidths = () => {
                itemWidth = getBubbleWidth();
                totalWidth = itemWidth * items.length;
            };

            // Calculate total width of original items
            // We need to wait for a frame to ensure widths are calculated
            requestAnimationFrame(() => {
                updateWidths();
                
                // Initial scroll to the middle set (the original items)
                servicesContainer.scrollLeft = totalWidth;

                const checkLoop = () => {
                    const currentScroll = servicesContainer.scrollLeft;
                    if (currentScroll <= 1) {
                        // Jump to identical position in the second set
                        servicesContainer.scrollLeft = totalWidth;
                    } else if (currentScroll >= totalWidth * 2 - 1) {
                        // Jump back to the first set
                        servicesContainer.scrollLeft = totalWidth;
                    }
                };

                servicesContainer.addEventListener('scroll', checkLoop);
                window.addEventListener('resize', () => {
                    const oldTotalWidth = totalWidth;
                    updateWidths();
                    // Adjust scroll position proportionally on resize to maintain relative position
                    servicesContainer.scrollLeft = (servicesContainer.scrollLeft / oldTotalWidth) * totalWidth;
                });

                // Auto-scroll logic with pause mechanism
                let isInteracting = false;
                let autoScrollPaused = false;
                let pauseTimeout;
                let scrollSpeed = 1.6;

                const pauseAutoScroll = (ms = 2000) => {
                    autoScrollPaused = true;
                    clearTimeout(pauseTimeout);
                    pauseTimeout = setTimeout(() => {
                        autoScrollPaused = false;
                    }, ms);
                };
                
                const autoScroll = () => {
                    if (!isInteracting && !autoScrollPaused) {
                        servicesContainer.scrollLeft += scrollSpeed;
                    }
                    requestAnimationFrame(autoScroll);
                };
                autoScroll();

                // Interaction listeners
                const startInteracting = () => { isInteracting = true; };
                const stopInteracting = () => { isInteracting = false; };

                servicesContainer.addEventListener('mouseenter', startInteracting);
                servicesContainer.addEventListener('mouseleave', stopInteracting);
                servicesContainer.addEventListener('touchstart', startInteracting);
                servicesContainer.addEventListener('touchend', stopInteracting);

                // Navigation buttons
                servicesNext?.addEventListener('click', () => {
                    pauseAutoScroll();
                    servicesContainer.scrollBy({ left: -itemWidth, behavior: 'smooth' });
                });
                servicesPrev?.addEventListener('click', () => {
                    pauseAutoScroll();
                    servicesContainer.scrollBy({ left: itemWidth, behavior: 'smooth' });
                });

                // Drag functionality
                let isDown = false;
                let startX;
                let scrollLeft;
                let walk = 0;
                let dragThreshold = 10;

                servicesContainer.addEventListener('mousedown', (e) => {
                    isDown = true;
                    isInteracting = true;
                    servicesContainer.classList.add('active');
                    startX = e.pageX - servicesContainer.offsetLeft;
                    scrollLeft = servicesContainer.scrollLeft;
                    walk = 0;
                });
                
                const endDrag = () => {
                    isDown = false;
                    isInteracting = false;
                    servicesContainer.classList.remove('active');
                };

                window.addEventListener('mouseup', endDrag);

                // Prevent links from firing if we were dragging
                servicesContainer.addEventListener('click', (e) => {
                    if (Math.abs(walk) > dragThreshold) {
                        e.preventDefault();
                        e.stopPropagation();
                    }
                }, true);
                
                servicesContainer.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    const x = e.pageX - servicesContainer.offsetLeft;
                    walk = (x - startX);
                    
                    if (Math.abs(walk) > dragThreshold) {
                        e.preventDefault();
                        servicesContainer.scrollLeft = scrollLeft - (walk * 1.5);
                    }
                });
            });
        }
    }

    /* ── Blog Carousel & Filter Logic ──────────────────────── */
    const blogTabs = document.querySelectorAll('.blog-tabs li');
    const blogTrack = document.querySelector('.blog-carousel-track');
    const blogSlides = document.querySelectorAll('.blog-slide');
    const blogPrev = document.querySelector('.blog-carousel-wrapper .blog-nav-btn.prev');
    const blogNext = document.querySelector('.blog-carousel-wrapper .blog-nav-btn.next');

    if (blogTrack && blogSlides.length) {
        let currentPos = 0;
        let visibleSlides = [];

        const updateVisibleSlides = (filter = 'all') => {
            visibleSlides = [];
            blogSlides.forEach(slide => {
                const cats = JSON.parse(slide.dataset.cats || '[]');
                if (filter === 'all' || cats.includes(filter)) {
                    slide.classList.remove('hidden');
                    visibleSlides.push(slide);
                } else {
                    slide.classList.add('hidden');
                }
            });
            currentPos = 0;
            updateCarousel();
        };

        const updateCarousel = () => {
            if (visibleSlides.length === 0) return;
            
            const slideWidth = visibleSlides[0].offsetWidth + 20; // width + gap
            const maxScroll = Math.max(0, (visibleSlides.length * slideWidth) - blogTrack.parentElement.offsetWidth);
            
            // Boundary checks
            if (currentPos < 0) currentPos = 0;
            if (currentPos > maxScroll) currentPos = maxScroll;

            blogTrack.style.transform = `translateX(-${currentPos}px)`;
            
            // Show/hide arrows based on scroll position
            if (blogPrev) blogPrev.style.opacity = currentPos <= 0 ? '0.3' : '1';
            if (blogNext) blogNext.style.opacity = currentPos >= maxScroll ? '0.3' : '1';
        };

        // Tab Filtering
        blogTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                blogTabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                updateVisibleSlides(tab.dataset.filter);
            });
        });

        // Navigation
        blogNext?.addEventListener('click', () => {
            const slideWidth = visibleSlides[0].offsetWidth + 20;
            currentPos += slideWidth;
            updateCarousel();
        });

        blogPrev?.addEventListener('click', () => {
            const slideWidth = visibleSlides[0].offsetWidth + 20;
            currentPos -= slideWidth;
            updateCarousel();
        });

        // Initialize
        updateVisibleSlides('all');
        
        // Handle window resize
        window.addEventListener('resize', updateCarousel);
    }
});
