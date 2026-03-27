/**
 * Particle Background Animation
 * Interactive particles with mouse drift, color shifting, and floating icons
 */
(function () {
    const canvas = document.getElementById('particle-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width, height;
    let particles = [];
    let floatingIcons = [];
    let mouse = { x: -9999, y: -9999 };
    let animationId;

    // Configuration
    const CONFIG = {
        particleCount: 120,
        iconCount: 18,
        minSize: 1.2,
        maxSize: 3.5,
        minSpeed: 0.15,
        maxSpeed: 0.6,
        mouseInfluenceRadius: 250,
        mouseForce: 0.06,
        connectionDistance: 130,
        connectionOpacity: 0.08,
        colorChangeSpeed: 0.003,
        colors: [
            [14, 165, 233],   // ocean blue
            [20, 184, 166],   // teal
            [99, 102, 241],   // indigo
            [139, 92, 246],   // purple
            [236, 72, 153],   // pink
            [16, 185, 129],   // emerald
            [56, 189, 248],   // sky
            [245, 158, 11],   // amber
            [168, 85, 247],   // violet
            [34, 211, 238],   // cyan
        ]
    };

    // SVG icon paths (24x24 viewBox) — drawn via canvas Path2D
    const ICON_PATHS = [
        // Padlock (lock)
        {
            paths: [
                'M 5 11 L 5 20 C 5 21.1 5.9 22 7 22 L 17 22 C 18.1 22 19 21.1 19 20 L 19 11 C 19 9.9 18.1 9 17 9 L 7 9 C 5.9 9 5 9.9 5 11 Z',
                'M 8 9 L 8 7 C 8 4.8 9.8 3 12 3 C 14.2 3 16 4.8 16 7 L 16 9'
            ],
            label: 'lock'
        },
        // Chat bubble
        {
            paths: [
                'M 21 15 C 21 15.53 20.79 16.04 20.41 16.41 C 20.04 16.79 19.53 17 19 17 L 7 17 L 3 21 L 3 5 C 3 4.47 3.21 3.96 3.59 3.59 C 3.96 3.21 4.47 3 5 3 L 19 3 C 19.53 3 20.04 3.21 20.41 3.59 C 20.79 3.96 21 4.47 21 5 Z'
            ],
            label: 'chat'
        },
        // Video camera
        {
            paths: [
                'M 15.6 11.6 L 22 7 L 22 17 L 15.6 12.4 L 15.6 11.6 Z',
                'M 2 7 C 2 5.9 2.9 5 4 5 L 13 5 C 14.1 5 15 5.9 15 7 L 15 17 C 15 18.1 14.1 19 13 19 L 4 19 C 2.9 19 2 18.1 2 17 Z'
            ],
            label: 'video'
        },
        // Microphone (voice)
        {
            paths: [
                'M 12 1 C 11.2 1 10.44 1.32 9.88 1.88 C 9.32 2.44 9 3.2 9 4 L 9 12 C 9 12.8 9.32 13.56 9.88 14.12 C 10.44 14.68 11.2 15 12 15 C 12.8 15 13.56 14.68 14.12 14.12 C 14.68 13.56 15 12.8 15 12 L 15 4 C 15 3.2 14.68 2.44 14.12 1.88 C 13.56 1.32 12.8 1 12 1 Z',
                'M 19 10 L 19 12 C 19 13.86 18.26 15.64 16.95 16.95 C 15.64 18.26 13.86 19 12 19 C 10.14 19 8.36 18.26 7.05 16.95 C 5.74 15.64 5 13.86 5 12 L 5 10',
                'M 12 19 L 12 23',
                'M 8 23 L 16 23'
            ],
            label: 'mic'
        },
        // Code brackets
        {
            paths: [
                'M 16 18 L 22 12 L 16 6',
                'M 8 6 L 2 12 L 8 18'
            ],
            label: 'code'
        },
        // Shield / security
        {
            paths: [
                'M 12 22 C 12 22 20 18 20 12 L 20 5 L 12 2 L 4 5 L 4 12 C 4 18 12 22 12 22 Z'
            ],
            label: 'shield'
        },
        // Git branch / collaboration
        {
            paths: [
                'M 6 3 L 6 15',
                'M 18 9 C 19.66 9 21 7.66 21 6 C 21 4.34 19.66 3 18 3 C 16.34 3 15 4.34 15 6 C 15 7.66 16.34 9 18 9 Z',
                'M 6 21 C 7.66 21 9 19.66 9 18 C 9 16.34 7.66 15 6 15 C 4.34 15 3 16.34 3 18 C 3 19.66 4.34 21 6 21 Z',
                'M 18 9 C 18 12 15 15 6 15'
            ],
            label: 'git'
        },
        // Globe / network
        {
            paths: [
                'M 12 2 C 6.48 2 2 6.48 2 12 C 2 17.52 6.48 22 12 22 C 17.52 22 22 17.52 22 12 C 22 6.48 17.52 2 12 2 Z',
                'M 2 12 L 22 12',
                'M 12 2 C 14.5 4.73 15.92 8.29 16 12 C 15.92 15.71 14.5 19.27 12 22',
                'M 12 2 C 9.5 4.73 8.08 8.29 8 12 C 8.08 15.71 9.5 19.27 12 22'
            ],
            label: 'globe'
        }
    ];

    function resize() {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    }

    // ============================================================
    // Dot Particle Class
    // ============================================================
    class Particle {
        constructor() {
            this.reset();
        }

        reset() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.size = CONFIG.minSize + Math.random() * (CONFIG.maxSize - CONFIG.minSize);

            const angle = Math.random() * Math.PI * 2;
            const speed = CONFIG.minSpeed + Math.random() * (CONFIG.maxSpeed - CONFIG.minSpeed);
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;

            this.colorIndex = Math.floor(Math.random() * CONFIG.colors.length);
            this.nextColorIndex = (this.colorIndex + 1 + Math.floor(Math.random() * (CONFIG.colors.length - 1))) % CONFIG.colors.length;
            this.colorProgress = Math.random();
            this.colorSpeed = CONFIG.colorChangeSpeed + Math.random() * 0.004;

            this.baseOpacity = 0.3 + Math.random() * 0.5;
            this.opacity = this.baseOpacity;

            this.twinklePhase = Math.random() * Math.PI * 2;
            this.twinkleSpeed = 0.01 + Math.random() * 0.02;
        }

        getCurrentColor() {
            const c1 = CONFIG.colors[this.colorIndex];
            const c2 = CONFIG.colors[this.nextColorIndex];
            const p = this.colorProgress;
            return {
                r: Math.round(c1[0] + (c2[0] - c1[0]) * p),
                g: Math.round(c1[1] + (c2[1] - c1[1]) * p),
                b: Math.round(c1[2] + (c2[2] - c1[2]) * p)
            };
        }

        update() {
            const dx = mouse.x - this.x;
            const dy = mouse.y - this.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < CONFIG.mouseInfluenceRadius && dist > 0) {
                const force = (1 - dist / CONFIG.mouseInfluenceRadius) * CONFIG.mouseForce;
                this.vx += (-dy / dist) * force * 0.5 + (dx / dist) * force * 0.3;
                this.vy += (dx / dist) * force * 0.5 + (dy / dist) * force * 0.3;
                this.opacity = Math.min(1, this.baseOpacity + (1 - dist / CONFIG.mouseInfluenceRadius) * 0.5);
            } else {
                this.opacity += (this.baseOpacity - this.opacity) * 0.02;
            }

            this.vx *= 0.998;
            this.vy *= 0.998;

            const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
            const maxSpeed = CONFIG.maxSpeed * 1.5;
            if (speed > maxSpeed) {
                this.vx = (this.vx / speed) * maxSpeed;
                this.vy = (this.vy / speed) * maxSpeed;
            }

            this.x += this.vx;
            this.y += this.vy;

            const margin = 20;
            if (this.x < -margin) this.x = width + margin;
            if (this.x > width + margin) this.x = -margin;
            if (this.y < -margin) this.y = height + margin;
            if (this.y > height + margin) this.y = -margin;

            this.colorProgress += this.colorSpeed;
            if (this.colorProgress >= 1) {
                this.colorProgress = 0;
                this.colorIndex = this.nextColorIndex;
                this.nextColorIndex = (this.colorIndex + 1 + Math.floor(Math.random() * (CONFIG.colors.length - 1))) % CONFIG.colors.length;
            }

            this.twinklePhase += this.twinkleSpeed;
            if (this.twinklePhase > Math.PI * 2) this.twinklePhase -= Math.PI * 2;
        }

        draw() {
            const color = this.getCurrentColor();
            const twinkle = 0.7 + 0.3 * Math.sin(this.twinklePhase);
            const alpha = this.opacity * twinkle;

            const glowSize = this.size * 3;
            const gradient = ctx.createRadialGradient(this.x, this.y, 0, this.x, this.y, glowSize);
            gradient.addColorStop(0, `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha * 0.8})`);
            gradient.addColorStop(0.4, `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha * 0.2})`);
            gradient.addColorStop(1, `rgba(${color.r}, ${color.g}, ${color.b}, 0)`);

            ctx.beginPath();
            ctx.arc(this.x, this.y, glowSize, 0, Math.PI * 2);
            ctx.fillStyle = gradient;
            ctx.fill();

            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(${color.r}, ${color.g}, ${color.b}, ${alpha})`;
            ctx.fill();
        }
    }

    // ============================================================
    // Floating Icon Class
    // ============================================================
    class FloatingIcon {
        constructor() {
            this.reset();
        }

        reset() {
            // Pick a random icon
            const iconData = ICON_PATHS[Math.floor(Math.random() * ICON_PATHS.length)];
            this.iconPaths = iconData.paths;
            this.label = iconData.label;

            // Position
            this.x = Math.random() * width;
            this.y = Math.random() * height;

            // Size (scaled from 24x24 viewBox)
            this.scale = 0.8 + Math.random() * 1.0; // 0.8x to 1.8x → ~19px to ~43px

            // Velocity — slower than dots
            const angle = Math.random() * Math.PI * 2;
            const speed = 0.08 + Math.random() * 0.2;
            this.vx = Math.cos(angle) * speed;
            this.vy = Math.sin(angle) * speed;

            // Rotation
            this.rotation = Math.random() * Math.PI * 2;
            this.rotationSpeed = (Math.random() - 0.5) * 0.003; // very slow spin

            // Color from palette
            this.colorIndex = Math.floor(Math.random() * CONFIG.colors.length);
            this.nextColorIndex = (this.colorIndex + 1 + Math.floor(Math.random() * (CONFIG.colors.length - 1))) % CONFIG.colors.length;
            this.colorProgress = Math.random();
            this.colorSpeed = 0.001 + Math.random() * 0.002;

            // Opacity — light but visible
            this.baseOpacity = 0.06 + Math.random() * 0.06; // 0.06 to 0.12
            this.opacity = this.baseOpacity;

            // Float bob
            this.bobPhase = Math.random() * Math.PI * 2;
            this.bobSpeed = 0.005 + Math.random() * 0.01;
            this.bobAmplitude = 0.3 + Math.random() * 0.5;
        }

        getCurrentColor() {
            const c1 = CONFIG.colors[this.colorIndex];
            const c2 = CONFIG.colors[this.nextColorIndex];
            const p = this.colorProgress;
            return {
                r: Math.round(c1[0] + (c2[0] - c1[0]) * p),
                g: Math.round(c1[1] + (c2[1] - c1[1]) * p),
                b: Math.round(c1[2] + (c2[2] - c1[2]) * p)
            };
        }

        update() {
            // Mouse influence — gentler than dots
            const dx = mouse.x - this.x;
            const dy = mouse.y - this.y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < CONFIG.mouseInfluenceRadius * 1.2 && dist > 0) {
                const force = (1 - dist / (CONFIG.mouseInfluenceRadius * 1.2)) * 0.03;
                this.vx += (-dy / dist) * force * 0.5 + (dx / dist) * force * 0.3;
                this.vy += (dx / dist) * force * 0.5 + (dy / dist) * force * 0.3;
                // Slightly brighter near mouse
                this.opacity = Math.min(0.2, this.baseOpacity + (1 - dist / (CONFIG.mouseInfluenceRadius * 1.2)) * 0.1);
            } else {
                this.opacity += (this.baseOpacity - this.opacity) * 0.01;
            }

            // Damping
            this.vx *= 0.997;
            this.vy *= 0.997;

            // Clamp speed
            const speed = Math.sqrt(this.vx * this.vx + this.vy * this.vy);
            if (speed > 0.5) {
                this.vx = (this.vx / speed) * 0.5;
                this.vy = (this.vy / speed) * 0.5;
            }

            // Move
            this.x += this.vx;
            this.y += this.vy + Math.sin(this.bobPhase) * this.bobAmplitude * 0.1; // gentle bob

            // Rotation
            this.rotation += this.rotationSpeed;

            // Bob phase
            this.bobPhase += this.bobSpeed;
            if (this.bobPhase > Math.PI * 2) this.bobPhase -= Math.PI * 2;

            // Wrap edges
            const margin = 40;
            if (this.x < -margin) this.x = width + margin;
            if (this.x > width + margin) this.x = -margin;
            if (this.y < -margin) this.y = height + margin;
            if (this.y > height + margin) this.y = -margin;

            // Color transition
            this.colorProgress += this.colorSpeed;
            if (this.colorProgress >= 1) {
                this.colorProgress = 0;
                this.colorIndex = this.nextColorIndex;
                this.nextColorIndex = (this.colorIndex + 1 + Math.floor(Math.random() * (CONFIG.colors.length - 1))) % CONFIG.colors.length;
            }
        }

        draw() {
            const color = this.getCurrentColor();

            ctx.save();
            ctx.translate(this.x, this.y);
            ctx.rotate(this.rotation);
            ctx.scale(this.scale, this.scale);
            // Center the 24x24 icon
            ctx.translate(-12, -12);

            ctx.strokeStyle = `rgba(${color.r}, ${color.g}, ${color.b}, ${this.opacity})`;
            ctx.lineWidth = 1.5 / this.scale;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';
            ctx.fillStyle = 'transparent';

            for (const pathStr of this.iconPaths) {
                const p = new Path2D(pathStr);
                ctx.stroke(p);
            }

            ctx.restore();
        }
    }

    // ============================================================
    // Connection lines between dot particles
    // ============================================================
    function drawConnections() {
        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const dist = Math.sqrt(dx * dx + dy * dy);

                if (dist < CONFIG.connectionDistance) {
                    const opacity = (1 - dist / CONFIG.connectionDistance) * CONFIG.connectionOpacity;
                    const c1 = particles[i].getCurrentColor();
                    const c2 = particles[j].getCurrentColor();

                    const midR = Math.round((c1.r + c2.r) / 2);
                    const midG = Math.round((c1.g + c2.g) / 2);
                    const midB = Math.round((c1.b + c2.b) / 2);

                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    ctx.strokeStyle = `rgba(${midR}, ${midG}, ${midB}, ${opacity})`;
                    ctx.lineWidth = 0.5;
                    ctx.stroke();
                }
            }
        }
    }

    // ============================================================
    // Animation Loop
    // ============================================================
    function animate() {
        ctx.clearRect(0, 0, width, height);

        // Layer 1: Floating icons (behind everything)
        for (const icon of floatingIcons) {
            icon.update();
            icon.draw();
        }

        // Layer 2: Connection lines
        drawConnections();

        // Layer 3: Dot particles (on top)
        for (const p of particles) {
            p.update();
            p.draw();
        }

        animationId = requestAnimationFrame(animate);
    }

    function init() {
        resize();

        // Create dot particles
        particles = [];
        for (let i = 0; i < CONFIG.particleCount; i++) {
            particles.push(new Particle());
        }

        // Create floating icons
        floatingIcons = [];
        for (let i = 0; i < CONFIG.iconCount; i++) {
            floatingIcons.push(new FloatingIcon());
        }

        animate();
    }

    // Mouse tracking
    document.addEventListener('mousemove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    document.addEventListener('mouseleave', () => {
        mouse.x = -9999;
        mouse.y = -9999;
    });

    // Touch support
    document.addEventListener('touchmove', (e) => {
        if (e.touches.length > 0) {
            mouse.x = e.touches[0].clientX;
            mouse.y = e.touches[0].clientY;
        }
    }, { passive: true });

    document.addEventListener('touchend', () => {
        mouse.x = -9999;
        mouse.y = -9999;
    });

    // Resize handler
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            resize();
            for (const p of particles) {
                if (p.x > width) p.x = Math.random() * width;
                if (p.y > height) p.y = Math.random() * height;
            }
            for (const icon of floatingIcons) {
                if (icon.x > width) icon.x = Math.random() * width;
                if (icon.y > height) icon.y = Math.random() * height;
            }
        }, 150);
    });

    // Start
    init();
})();
