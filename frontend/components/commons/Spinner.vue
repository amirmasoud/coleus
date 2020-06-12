<template>
  <svg class="spinner" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
    <circle cx="50" cy="50" r="45" />
  </svg>
</template>

<script>
export default {
  data: () => ({
    interval: null,
    colors: [
      '#F56565',
      '#ED8936',
      '#ECC94B',
      '#48BB78',
      '#38B2AC',
      '#4299E1',
      '#667EEA',
      '#9F7AEA',
      '#ED64A6'
    ]
  }),
  created() {
    let idx = 0
    this.interval = setInterval(() => {
      if (process.client) {
        document.querySelector('.spinner circle').style.stroke = this.colors[ // eslint-disable-line nuxt/no-globals-in-created
          idx++
        ]
      }
      if (idx === this.colors.length) {
        idx = 0
      }
    }, 2000)
  },
  destroyed() {
    clearInterval(this.interval)
  }
}
</script>

<style lang="scss">
svg.spinner {
  animation: 2s linear infinite svg-animation;
}

@keyframes svg-animation {
  0% {
    transform: rotateZ(0deg);
  }
  100% {
    transform: rotateZ(360deg);
  }
}

.spinner circle {
  animation: 1.4s ease-in-out infinite both circle-animation;
  -webkit-transition: stroke 0.3s linear;
  -moz-transition: stroke 0.3s linear;
  -o-transition: stroke 0.3s linear;
  transition: stroke 0.3s linear;
  display: block;
  fill: transparent;
  stroke: #ed64a6;
  stroke-linecap: round;
  stroke-dasharray: 283;
  stroke-dashoffset: 280;
  stroke-width: 10px;
  transform-origin: 50% 50%;
}

@keyframes circle-animation {
  0%,
  25% {
    stroke-dashoffset: 280;
    transform: rotate(0);
  }

  50%,
  75% {
    stroke-dashoffset: 75;
    transform: rotate(45deg);
  }

  100% {
    stroke-dashoffset: 280;
    transform: rotate(360deg);
  }
}
</style>
