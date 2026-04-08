import { createApp } from 'vue'
import InsertEvents from './vue/insertEventComp.vue'

const mountElement = document.getElementById('app')

if (mountElement) {
    createApp(InsertEvents).mount(mountElement)
    console.log('GEMOUNTED')
}



