import Vue from "vue"
import Vuex from "vuex"
import system from "./system"
import activity from "./activity"
import * as types from "./types"

Vue.use(Vuex)

const store = new Vuex.Store({
  state: {
    accessToken: ""
  },
  mutations: {
    [types.ACCESS_TOKEN] (state, payload) {
      state.accessToken = payload
      localStorage.setItem("accessToken", payload)
    }
  },
  getters: {
    accessToken (state) {
      return localStorage.getItem("accessToken")
    }
  },
  modules: {
    system,
    activity
  }
})

export default store
