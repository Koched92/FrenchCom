<template>
  <nav class="navbar">
    <div class="container">
      <div class="navbar-brand">
        <a class="navbar-item" href="/">
          MyBrand
        </a>
        <a role="button" class="navbar-burger" @click="toggleMenu" :class="{ 'is-active': isActive }" aria-label="menu"
          aria-expanded="false">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
      </div>

      <div class="navbar-menu" :class="{ 'is-active': isActive }">
        <div class="navbar-start">
          <a class="navbar-item" href="/">
            Home
          </a>
          <el-button type="danger" link>Home</el-button>
          <a class="navbar-item" href="/about">
            About
          </a>
          <a class="navbar-item" href="/contact">
            Contact
          </a>
          <el-button type="primary" plain> 
            <el-icon :size="size" :color="color">
              <Search />
            </el-icon>
            <el-icon><ChatSquare /></el-icon>
            Primary
          </el-button>
          <el-button type="primary" circle />
        </div>

        <div class="navbar-end">
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-primary" href="/sign-up">
                <strong>Sign up</strong>
              </a>
              <a class="button is-light" href="/login">
                Log in
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  data() {
    return {
      isActive: false
    };
  },
  methods: {
    toggleMenu() {
      this.isActive = !this.isActive;
    }
  }
};
</script>

<style scoped>
.navbar {
  background-color: #00d1b2;
}

.navbar-item {
  color: white;
}

.navbar-burger span {
  background-color: white;
}
</style>