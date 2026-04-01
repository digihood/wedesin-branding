import { MeshGradient } from 'https://cdn.jsdelivr.net/npm/@mesh-gradient/core@1.5.0/dist/index.mjs';

const canvas = document.getElementById('dh-gradient-canvas');
if (canvas) {
  const gradient = new MeshGradient();
  gradient.init('#dh-gradient-canvas', {
    colors: ['#ff817e', '#fd8d42', '#ff817e', '#fd8d42'],
    seed: 100,
    animationSpeed: 2.1,
    isStatic: false,
    activeColors: { 1: true, 2: true, 3: true, 4: true },
    frequency: {
      x: 0.00008,
      y: 0.002,
      delta: 0.00001,
    },
    pauseOnOutsideViewport: true,
  });
}
