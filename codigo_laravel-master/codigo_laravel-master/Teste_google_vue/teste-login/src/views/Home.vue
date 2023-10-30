<template>
  <div>
    <p>Home</p>
    <p @click="irHome">ir home</p>
  </div>
</template>

<script>
export default {
  name: 'Home',
  methods: {
    irHome() {
      this.$router.push({path: "/login"})
    }
  }
}
</script>
