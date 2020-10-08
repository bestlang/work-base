import * as types from './types'

const systemConfig = {
  state: {
    appName: 'LARACMS',
    appShortName: 'LC',
    user: null,
    isCollapse: false,
    csrf: null
  },
  getters:{
    appName(state){
        return state.appName
    },
    appShortName(state){
      return state.appShortName
    },
    isCollapse(state){
      return state.isCollapse
    },
    user(state){
      if(state.user){
          return state.user
      }
      let user = localStorage.getItem('user')
      return JSON.parse(user)
    },
    [types.CSRF](state){
        let csrf = localStorage.getItem(types.CSRF)
        return csrf;
    },
  },
  mutations: {
    toggleState(state) {
      state.isCollapse = !state.isCollapse
    },
    user(state, payload) {
      state.user = payload
      localStorage.setItem('user', JSON.stringify(payload))
    },
    [types.CSRF](state, payload){
      state.csrf = payload
      localStorage.setItem(types.CSRF, payload)
    }
  },
  actions: {
    toggleState({commit}) {
      commit("toggleState")
    },
    collapse({state}){
      state.isCollapse = true
    },
    user({commit}, payload){
      commit('user', payload)
    }
  }
}

export default systemConfig
