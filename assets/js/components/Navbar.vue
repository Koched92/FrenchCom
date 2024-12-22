<template>
<!-- Dropdown Structure -->
<ul id="dropdown1" class="dropdown-content">
  <li><a href="#!">one</a></li>
  <li><a href="#!">two</a></li>
  <li class="divider"></li>
  <li><a href="#!">three</a></li>
</ul>
<nav class='light-blue lighten-1'>
  <div class="nav-wrapper container">
    <a href="/" class="brand-logo">French'Com</a>
    <ul class="right hide-on-med-and-down">
      <li><a href="sass.html">Sass</a></li>
      <li><a href="badges.html">Components</a></li>
      <!-- Dropdown Trigger -->
      <li><a class="dropdown-trigger" href="#!" data-target="dropdown1">Dropdown<i class="material-icons right">arrow_drop_down</i></a></li>
    </ul>
  </div>
</nav>
</template>

<script>
export default {
  mounted() {
    // Initialize the sidenav
    var elems = document.querySelectorAll('.sidenav');
    M.Sidenav.init(elems);
    // Initialize the dropdown
    var dropdowns = document.querySelectorAll('.dropdown-trigger');
    M.Dropdown.init(dropdowns);
  }
}
</script>

<style scoped>
/* Add any custom styles here */
</style>