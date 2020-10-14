import Vue from "vue"
import Vuex from "vuex"
import vuexModules from './modules'
Vue.use(Vuex)

const store = new Vuex.Store({
  modules: vuexModules
})

export default store
