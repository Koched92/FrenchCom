<template>
  <div class="theme-toggler-content theme-toggler">
    <el-switch
    v-model="value1"
    :active-action-icon="Moon"
    :inactive-action-icon="Sunny"
  />
</div>

</template>

<script setup >
import { useDark } from '@vueuse/core'
import { Moon, Sunny } from '@element-plus/icons-vue'

const isDark = useDark()
const value1 = isDark
</script>

<style lang="css">
  .el-switch{
    display: inline-flex;
    align-items: center;
    position: relative;
    font-size: 14px;
    line-height: 20px;
    height: 32px;
    vertical-align: middle;
  }
  .el-icon{
    color: #606266;
  }
  .theme-toggler-content {
        display: flex;
        align-items: center;
    }
</style>
