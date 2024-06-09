<template>
  <div id="container">
    <div id="contacts">
      <div id="contacts--contact">
        <p>{{ mail }}</p>
        <p>{{ phone }}</p>
      </div>
      <div id="contacts--social">
        <div><img src="../img/icons/icons8-linkedin.svg" alt="" srcset=""></div>
        <div><img src="../img/icons/icons8-github.svg" alt="" srcset=""></div>
        <div></div>
        <div></div>
      </div>
    </div>
    <div id="mentions">
      <p>{{ mention }}</p>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      mail: 'xavier.seignard+drangies@gmail.com',
      phone: '06.00.00.00.00',
      mention: '2018 | mentions légales'
    }
  }
}

</script>

<style scoped>
body {
  display: flex;
  background-color: #F0F8FF;
  height: 95vh;
  justify-content: center;
  align-items: flex-end;
  font-family: Open Sans;
}

#container {
  padding-top: 20px;
  margin-top: 20px;
  width: 100vw;
  color: white;
  background-color: #545C64;
  display: flex;
  flex-direction: column;
  align-items: center;
}

#contacts {
  display: flex;
  justify-content: space-around;
  align-items: center;
  width: 100%;
}

#contacts--contact {
  text-align: right;
}

#contacts--social {
  width: 20%;
  display: flex;
  justify-content: space-between;
}

#contacts--social div {
  height: 30px;
  width: 30px;
  border-radius: 50%;
}

#mentions p {
  font-size: 0.5em;
}
</style>