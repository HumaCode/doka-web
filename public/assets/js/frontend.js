/* ════════════════════════════════════
   AOS INIT
════════════════════════════════════ */
AOS.init({
  duration: 700,
  easing  : 'ease-out-cubic',
  once    : true,
  offset  : 60,
});

/* ════════════════════════════════════
   PARTICLE CANVAS BACKGROUND
════════════════════════════════════ */
(function() {
  const canvas = document.getElementById('bgCanvas');
  const ctx    = canvas.getContext('2d');
  let W, H;

  const COLORS = [
    'rgba(79,70,229,.18)',
    'rgba(6,182,212,.15)',
    'rgba(236,72,153,.12)',
    'rgba(16,185,129,.12)',
    'rgba(245,158,11,.10)',
  ];

  let particles = [];
  const N = 55;

  function resize() {
    W = canvas.width  = window.innerWidth;
    H = canvas.height = window.innerHeight;
  }
  resize();
  window.addEventListener('resize', resize);

  for (let i = 0; i < N; i++) {
    const r = Math.random() * 4 + 1.5;
    particles.push({
      x  : Math.random() * window.innerWidth,
      y  : Math.random() * window.innerHeight,
      r,
      c  : COLORS[Math.floor(Math.random() * COLORS.length)],
      vx : (Math.random() - .5) * .35,
      vy : (Math.random() - .5) * .35,
      a  : Math.random() * Math.PI * 2,
      as : (Math.random() - .5) * .015,
      pulse: Math.random() * Math.PI * 2,
    });
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => {
      p.x  += p.vx; p.y += p.vy; p.a += p.as; p.pulse += .02;
      if (p.x < -10) p.x = W + 10;
      if (p.x > W+10) p.x = -10;
      if (p.y < -10) p.y = H + 10;
      if (p.y > H+10) p.y = -10;
      const r = p.r + Math.sin(p.pulse) * .8;
      ctx.save();
      ctx.globalAlpha = .5 + .5 * Math.sin(p.a);
      ctx.beginPath();
      ctx.arc(p.x, p.y, r, 0, Math.PI * 2);
      ctx.fillStyle = p.c;
      ctx.fill();
      ctx.restore();
    });

    for (let i = 0; i < particles.length; i++) {
      for (let j = i + 1; j < particles.length; j++) {
        const dx = particles[i].x - particles[j].x;
        const dy = particles[i].y - particles[j].y;
        const dist = Math.sqrt(dx*dx + dy*dy);
        if (dist < 120) {
          ctx.save();
          ctx.globalAlpha = (.12 - dist/1200) * .6;
          ctx.strokeStyle = 'rgba(79,70,229,.4)';
          ctx.lineWidth = .5;
          ctx.beginPath();
          ctx.moveTo(particles[i].x, particles[i].y);
          ctx.lineTo(particles[j].x, particles[j].y);
          ctx.stroke();
          ctx.restore();
        }
      }
    }
    requestAnimationFrame(draw);
  }
  draw();
})();

/* ════════════════════════════════════
   SMOOTH SCROLL WITH BOUNCE EFFECT
════════════════════════════════════ */
/**
 * Easing function: easeOutBack
 * Produces a slight overshoot and bounce back
 */
function easeOutBack(t, b, c, d, s = 1.70158) {
  return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
}

function smoothScrollTo(id) {
  const targetEl = document.getElementById(id);
  if (!targetEl) return;

  const targetPosition = targetEl.getBoundingClientRect().top + window.scrollY - 68;
  const startPosition = window.scrollY;
  const distance = targetPosition - startPosition;
  const duration = 1200; // Slower duration for better effect
  let start = null;

  function step(timestamp) {
    if (!start) start = timestamp;
    const progress = timestamp - start;
    const nextScroll = easeOutBack(progress, startPosition, distance, duration);
    
    window.scrollTo(0, nextScroll);

    if (progress < duration) {
      window.requestAnimationFrame(step);
    } else {
      window.scrollTo(0, targetPosition);
    }
  }

  window.requestAnimationFrame(step);
}

// Attach to all anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const id = a.getAttribute('href').replace('#','');
    if (document.getElementById(id)) {
      e.preventDefault();
      smoothScrollTo(id);
      // Close mobile menu if open
      if(typeof closeMobileMenu === 'function') closeMobileMenu();
    }
  });
});

/* ════════════════════════════════════
   NAVBAR: scroll effect & active link
════════════════════════════════════ */
const nav = document.getElementById('siteNav');
const sections = ['hero','fitur','cara-kerja','statistik','modul','teknologi','cta'];
const navLinksEl = document.querySelectorAll('.nav-links a, .mobile-drawer-links a');

window.addEventListener('scroll', () => {
  if(nav) nav.classList.toggle('scrolled', window.scrollY > 60);
  const fab = document.getElementById('fabScroll');
  if(fab) fab.classList.toggle('show', window.scrollY > 400);

  let current = '';
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (el && el.getBoundingClientRect().top <= 100) current = id;
  });
  navLinksEl.forEach(a => {
    const href = a.getAttribute('href')?.replace('#','');
    a.classList.toggle('active', href === current);
  });
}, { passive: true });

/* ════════════════════════════════════
   MOBILE MENU
════════════════════════════════════ */
function toggleMobileMenu() {
  document.getElementById('mobileMenu').classList.toggle('open');
  document.body.style.overflow = document.getElementById('mobileMenu').classList.contains('open') ? 'hidden' : '';
}
function closeMobileMenu() {
  const menu = document.getElementById('mobileMenu');
  if(menu) {
    menu.classList.remove('open');
    document.body.style.overflow = '';
  }
}

/* ════════════════════════════════════
   COUNTER ANIMATION
════════════════════════════════════ */
let countersStarted = false;
function startCounters() {
  if (countersStarted) return;
  const el = document.getElementById('statistik');
  if (!el || el.getBoundingClientRect().top > window.innerHeight) return;
  countersStarted = true;

  document.querySelectorAll('[data-counter]').forEach(elem => {
    const target = parseInt(elem.getAttribute('data-val')) || 0;
    const suf = elem.getAttribute('data-suf') || '';
    let current = 0;
    const step = target / 60;
    const timer = setInterval(() => {
      current += step;
      if (current >= target) { current = target; clearInterval(timer); }
      elem.textContent = Math.floor(current).toLocaleString('id-ID') + suf;
    }, 20);
  });
}
window.addEventListener('scroll', startCounters, { passive: true });
startCounters();

/* ════════════════════════════════════
   PROGRESS BARS
════════════════════════════════════ */
let barsAnimated = false;
function animateBars() {
  if (barsAnimated) return;
  const el = document.getElementById('statistik');
  if (!el || el.getBoundingClientRect().top > window.innerHeight - 100) return;
  barsAnimated = true;
  setTimeout(() => {
    document.querySelectorAll('.prog-fill').forEach(b => {
      b.style.width = b.dataset.w;
    });
  }, 300);
}
window.addEventListener('scroll', animateBars, { passive: true });
animateBars();
