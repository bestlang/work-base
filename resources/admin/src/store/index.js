import Vue from "vue"
import Vuex from "vuex"

import system from "./system"
import cms from "./cms"
import privileges from "./privileges"
Vue.use(Vuex)

const store = new Vuex.Store({
  // state: {},
  // mutations: {},
  // getters: {},
  modules: {
    system,
    cms,
    privileges
  }
})

export default store
