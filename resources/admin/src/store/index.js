import Vue from "vue"
import Vuex from "vuex"

import system from "./system"
import cms from "./cms"
import privilege from "./privilege";

import * as types from "./types"

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    accessToken: ""
  },
  mutations: {
    accessToken(state, payload){
      state.accessToken = payload
      localStorage.setItem("accessToken", payload)
      if(!payload){
      localStorage.removeItem('accessToken')
      }
    }
  },
  getters: {
    accessToken(state){
      return localStorage.getItem("accessToken")
    }
  },
  modules: {
    system,
    cms,
    privilege
  }
})

export default store
