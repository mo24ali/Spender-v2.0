document.addEventListener('DOMContentLoaded', function () {
    gsap.to('#navbar', {
        opacity: 1,
        y: 0,
        duration: 0.8,
        ease: "power2.out"
    });

    gsap.fromTo('#hero', {
        opacity: 0,
        y: 20
    }, {
        opacity: 1,
        y: 0,
        duration: 1,
        delay: 0.3
    });

    gsap.set('.carousel', { position: 'relative' });

    gsap.set('.desktop, .mobile, .cards', {
        position: 'absolute',
        top: '50%',
        left: '50%',
        xPercent: -50,
        yPercent: -50
    });

    gsap.set('.desktop', { zIndex: 1, scale: 0.7, y: 100, rotation: -5, opacity: 0 });
    gsap.set('.mobile', { zIndex: 2, scale: 0.8, x: -150, rotation: -5, opacity: 0 });
    gsap.set('.cards', { zIndex: 3, scale: 0.8, x: 150, rotation: 5, opacity: 0 });

    const tl = gsap.timeline({ defaults: { ease: "power3.out" }, delay: 0.8 });

    tl.to('.desktop', { opacity: 1, scale: 1, y: 0, rotation: 0, duration: 1.5, ease: "back.out(1.4)" });

    tl.to('.mobile', { opacity: 1, scale: 0.95, x: -60, y: 10, rotation: -2, duration: 1.2 }, "-=1");

    tl.to('.cards', { opacity: 1, scale: 0.9, x: 80, y: -15, rotation: 2, duration: 1.2 }, "-=1");

    tl.to('.desktop', { scale: 0.9, x: -20, filter: 'brightness(0.95)', duration: 0.8 }, "+=0.2");
    tl.to('.mobile', { scale: 0.88, x: -80, y: 5, filter: 'brightness(0.98)', duration: 0.8 }, "-=0.8");
    tl.to('.cards', { scale: 0.85, x: 120, y: -10, duration: 0.8 }, "-=0.8");

    tl.to('.carousel', { boxShadow: '0 20px 60px rgba(0,0,0,0.15)', duration: 0.8 }, "-=0.5");
    tl.to('.desktop', { boxShadow: '0 5px 20px rgba(0,0,0,0.1)', duration: 0.5 }, "-=0.5");
    tl.to('.mobile', { boxShadow: '0 8px 25px rgba(0,0,0,0.12)', duration: 0.5 }, "-=0.5");
    tl.to('.cards', { boxShadow: '0 12px 35px rgba(0,0,0,0.15)', duration: 0.5 }, "-=0.5");

    tl.add(() => {
        const floatTl = gsap.timeline({ repeat: -1, yoyo: true });
        floatTl.to('.desktop', { y: 3, duration: 3, ease: "sine.inOut" })
            .to('.mobile', { y: 4, duration: 3, ease: "sine.inOut" }, 0)
            .to('.cards', { y: 5, duration: 3, ease: "sine.inOut" }, 0);
    });

    document.querySelectorAll('.carousel img').forEach(img => {
        img.addEventListener('mouseenter', () => {
            const scale = img.classList.contains('cards') ? 0.9 : img.classList.contains('mobile') ? 0.92 : 0.94;
            gsap.to(img, { scale, y: -5, duration: 0.3, ease: "power2.out", zIndex: 10 });
        });
        img.addEventListener('mouseleave', () => {
            const scale = img.classList.contains('cards') ? 0.85 : img.classList.contains('mobile') ? 0.88 : 0.9;
            const x = img.classList.contains('cards') ? 120 : img.classList.contains('mobile') ? -80 : -20;
            const y = img.classList.contains('cards') ? -10 : img.classList.contains('mobile') ? 5 : 0;
            const z = img.classList.contains('cards') ? 3 : img.classList.contains('mobile') ? 2 : 1;
            gsap.to(img, { scale, x, y, zIndex: z, duration: 0.4, ease: "power2.out" });
        });
    });

});
