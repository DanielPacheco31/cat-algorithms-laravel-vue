<template>
  <div id="app">
    <CatAlgorithms />
  </div>
</template>

<script>
import CatAlgorithms from './components/CatAlgorithms.vue'

export default {
  name: 'App',
  components: {
    CatAlgorithms
  }
}
</script>

<style>
#app {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  margin: 0;
  font-family: inherit;
  line-height: 1.6;
}

input:focus {
  outline: none;
}

button {
  cursor: pointer;
  border: none;
  font-family: inherit;
}

button:disabled {
  cursor: not-allowed;
}
</style>
