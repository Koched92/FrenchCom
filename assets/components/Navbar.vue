<template>
  <div class="common-layout">
    <el-container>
      <el-aside width="200px">
        <div class="logo-container">
          <img src="../img/poisson-rouge.png">
        </div>
        <el-menu active-text-color="#ffd04b" background-color="#545c64" class="el-menu-vertical-demo" default-active="2"
          text-color="#fff" @open="handleOpen" @close="handleClose">
          <el-sub-menu index="1">
            <template #title>
              <el-icon>
                <location />
              </el-icon>
              <span>Navigator One</span>
            </template>
            <el-menu-item-group title="Group One">
              <el-menu-item index="1-1">item one</el-menu-item>
              <el-menu-item index="1-2">item two</el-menu-item>
            </el-menu-item-group>
            <el-menu-item-group title="Group Two">
              <el-menu-item index="1-3">item three</el-menu-item>
            </el-menu-item-group>
            <el-sub-menu index="1-4">
              <template #title>item four</template>
              <el-menu-item index="1-4-1">item one</el-menu-item>
            </el-sub-menu>
          </el-sub-menu>
          <el-menu-item index="2">
            <el-icon><icon-menu /></el-icon>
            <span>Navigator Two</span>
          </el-menu-item>
          <el-menu-item index="3" disabled>
            <el-icon>
              <document />
            </el-icon>
            <span>Navigator Three</span>
          </el-menu-item>
          <el-menu-item index="4">
            <el-icon>
              <setting />
            </el-icon>
            <span>Navigator Four</span>
          </el-menu-item>
        </el-menu>
      </el-aside>
      <el-container>
        <el-header class="dark:bg-slate-900">
          <el-menu :default-active="activeIndex" class="el-menu-demo dark:bg-slate-900" mode="horizontal" :ellipsis="false"
            @select="handleSelect">
            <div class="flex-grow" />
            <el-menu-item index="1">Processing Center</el-menu-item>
            <el-sub-menu index="2">
              <template #title>Workspace</template>
              <el-menu-item index="2-1">item one</el-menu-item>
              <el-menu-item index="2-2">item two</el-menu-item>
              <el-menu-item index="2-3">item three</el-menu-item>
              <el-sub-menu index="2-4">
                <template #title>item four</template>
                <el-menu-item index="2-4-1">item one</el-menu-item>
                <el-menu-item index="2-4-2">item two</el-menu-item>
                <el-menu-item index="2-4-3">item three</el-menu-item>
              </el-sub-menu>
            </el-sub-menu>    
            <lightDarkMode-component></lightDarkMode-component>
            <div class="avatar">
              <el-avatar src="https://cube.elemecdn.com/0/88/03b0d39583f48206768a7534e55bcpng.png" />
            </div>
          </el-menu>
        </el-header>
        <el-main class="dark:bg-slate-800">
          <el-breadcrumb :separator-icon="ArrowRight">
            <el-breadcrumb-item :to="{ path: '/' }" class="dark:!text-slate-200">homepage</el-breadcrumb-item>
            <el-breadcrumb-item>promotion management</el-breadcrumb-item>
            <el-breadcrumb-item>promotion list</el-breadcrumb-item>
            <el-breadcrumb-item>promotion detail</el-breadcrumb-item>
          </el-breadcrumb>
        </el-main>

          <footer-component></footer-component>
      
      </el-container>
    </el-container>
  </div>
</template>

<script>
import { ArrowRight } from '@element-plus/icons-vue'

export default {

  setup() {
    return {
      ArrowRight
    }
  },
};
</script>

<style scoped>
.el-aside {
  color: white;
  background-color: #545C64;
  min-height: 100vh;
  width: 200px;
}

.logo-container {
  padding: 10px;
  background-color: #373d44;
}

.el-menu {
  border-right: 0 !important
}

.flex-grow {
  flex-grow: 1;
}

/* .el-main {
  background-color: #EEF1F4;
} */

.avatar {
  justify-content: center;
  align-items: center;
  display: inline-flex;
  padding: 0 12px;
  margin: 0%
}
</style>