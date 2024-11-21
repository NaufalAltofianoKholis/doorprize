 const dialog = document.getElementById('dialog');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
const maxConfettis = 150;
let particles = [];
let isAnimating = false;
let stopAnimationTimeout = null;
let confettiDuration = 3000; // Set duration to 3 seconds

const possibleColors = [
    "DodgerBlue", "OliveDrab", "Gold", "Pink", "SlateBlue", "LightBlue",
    "Gold", "Violet", "PaleGreen", "SteelBlue", "SandyBrown",
    "Chocolate", "Crimson"
];

function randomFromTo(from, to) {
    return Math.floor(Math.random() * (to - from + 1) + from);
}

function confettiParticle() {
    this.x = Math.random() * window.innerWidth;
    this.y = Math.random() * window.innerHeight - window.innerHeight;
    this.r = randomFromTo(11, 33);
    this.d = Math.random() * maxConfettis + 11;
    this.color = possibleColors[Math.floor(Math.random() * possibleColors.length)];
    this.tilt = Math.floor(Math.random() * 33) - 11;
    this.tiltAngleIncremental = Math.random() * 0.07 + 0.05;
    this.tiltAngle = 0;
    this.opacity = 1;

    this.draw = function() {
        context.beginPath();
        context.lineWidth = this.r / 2;
        context.strokeStyle = this.color;
        context.globalAlpha = this.opacity;
        context.moveTo(this.x + this.tilt + this.r / 3, this.y);
        context.lineTo(this.x + this.tilt, this.y + this.tilt + this.r / 5);
        context.stroke();
        context.globalAlpha = 1;
    };
}

function drawConfetti() {
    if (!isAnimating) return;
    requestAnimationFrame(drawConfetti);
    context.clearRect(0, 0, canvas.width, canvas.height);  // Clear only the canvas
    particles.forEach((particle) => particle.draw());

    particles.forEach((particle, i) => {
        particle.tiltAngle += particle.tiltAngleIncremental;
        particle.y += ((Math.cos(particle.d) + 3 + particle.r / 2) / 2);
        particle.tilt = Math.sin(particle.tiltAngle - i / 3) * 15;

        if (particle.x > canvas.width + 30 || particle.x < -30 || particle.y > canvas.height) {
            particle.x = Math.random() * canvas.width;
            particle.y = -30;
            particle.tilt = Math.floor(Math.random() * 10) - 20;
        }
    });

    // Stop animation after the set duration
    if (stopAnimationTimeout && stopAnimationTimeout <= Date.now()) {
        particles.forEach((particle) => {
            particle.opacity -= 0.01; // Reduce opacity gradually
            if (particle.opacity <= 0) {
                particle.opacity = 0;
            }
        });

        // Remove particles with opacity 0
        particles = particles.filter(particle => particle.opacity > 0);

        if (particles.length === 0) {
            isAnimating = false;
            clearCanvas();
        }
    }
}

function initializeConfetti() {
    // Reset particles array and canvas
    particles = [];
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    // Create new confetti particles
    for (let i = 0; i < maxConfettis; i++) {
        particles.push(new confettiParticle());
    }

    // Start animation
    isAnimating = true;
    drawConfetti();

    // Stop animation after the set duration
    stopAnimationTimeout = Date.now() + confettiDuration;
}

function showModalWithConfetti() {
    // Initialize the confetti animation
    initializeConfetti();
    // Show the modal
    dialog.showModal();
}

dialog.addEventListener('click', (event) => {
    const rect = dialog.getBoundingClientRect();
    if (
        event.clientX < rect.left ||
        event.clientX > rect.right ||
        event.clientY < rect.top ||
        event.clientY > rect.bottom
    ) {
        dialog.close();
        // Ensure confetti animation stops properly
        clearCanvas(); // Clear confetti when dialog is closed
    }
});

dialog.addEventListener('close', () => {
    clearCanvas(); // Ensure canvas is cleared when dialog is closed
});

function clearCanvas() {
    context.clearRect(0, 0, canvas.width, canvas.height);
    isAnimating = false;
}

window.addEventListener('load', function () {
    showModalWithConfetti(); // Memanggil fungsi untuk menampilkan modal dan confetti
});

