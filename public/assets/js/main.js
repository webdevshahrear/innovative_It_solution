/* Main JS */
$(document).ready(function () {
    // Initialize AOS
    AOS.init({
        duration: 1000,
        once: true
    });

    // Hero Slider removed - Now static hero section
    /*
    $('.hero-slider').slick({
        ...
    });
    */

    // Navbar scroll effect
    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.navbar').addClass('navbar-scrolled shadow-lg');
        } else {
            $('.navbar').removeClass('navbar-scrolled shadow-lg');
        }
    });

    // Magnetic Button Effect
    const magneticElements = document.querySelectorAll('.magnetic');
    magneticElements.forEach((el) => {
        el.addEventListener('mousemove', function (e) {
            const pos = el.getBoundingClientRect();
            const x = e.pageX - pos.left - window.scrollX;
            const y = e.pageY - pos.top - window.scrollY;

            const centerX = pos.width / 2;
            const centerY = pos.height / 2;

            const deltaX = x - centerX;
            const deltaY = y - centerY;

            el.style.transform = `translate(${deltaX * 0.3}px, ${deltaY * 0.5}px)`;
        });

        el.addEventListener('mouseleave', function () {
            el.style.transform = 'translate(0, 0)';
        });
    });

    // Smooth Scrolling for anchor links
    $('a[href^="#"]').on('click', function (e) {
        e.preventDefault();
        var target = this.hash;
        if (target) {
            $('html, body').animate({
                scrollTop: $(target).offset().top - 80
            }, 800);
        }
    });

    // Statistics Counter
    var counterSection = $('#statistics');
    if (counterSection.length) {
        var counterTriggered = false;
        $(window).scroll(function () {
            var oTop = counterSection.offset().top - window.innerHeight;
            if (counterTriggered == false && $(window).scrollTop() > oTop) {
                $('.stat-value').each(function () {
                    var $this = $(this),
                        countTo = $this.text().replace(/\D/g, '');

                    $({ countNum: 0 }).animate({
                        countNum: countTo
                    }, {
                        duration: 2500,
                        easing: 'swing',
                        step: function () {
                            $this.text(Math.floor(this.countNum) + '+');
                        },
                        complete: function () {
                            $this.text(this.countNum + '+');
                        }
                    });
                });
                counterTriggered = true;
            }
        });
    }

    // Ajax Contact Form for Home Page
    const homeContactForm = document.getElementById('contactForm');
    if (homeContactForm) {
        homeContactForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const form = this;
            const messageDiv = document.getElementById('formMessage');
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';

            const formData = new FormData(form);

            fetch('process-contact.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    messageDiv.style.display = 'block';
                    if (data.success) {
                        messageDiv.innerHTML = `<div class="alert alert-success bg-success border-0 text-white rounded-4 p-3"><i class="fas fa-check-circle me-2"></i> ${data.message}</div>`;
                        form.reset();
                    } else {
                        messageDiv.innerHTML = `<div class="alert alert-danger bg-danger border-0 text-white rounded-4 p-3"><i class="fas fa-exclamation-triangle me-2"></i> ${data.message}</div>`;
                    }
                })
                .catch(error => {
                    messageDiv.style.display = 'block';
                    messageDiv.innerHTML = `<div class="alert alert-danger bg-danger border-0 text-white rounded-4 p-3">An error occurred. Please try again later.</div>`;
                })
                .finally(() => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalBtnText;
                });
        });
    }
});
