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
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  min-height: 100vh;
}

#app {
  min-height: 100vh;
  padding: 20px 0;
}
</style>