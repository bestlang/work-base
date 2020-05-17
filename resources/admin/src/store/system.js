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
    [types.USER](state){
      if(state.user){
          return state.user;
      }
      let user = localStorage.getItem(types.USER)
      return JSON.parse(user)
    },
    [types.CSRF](state){
        // if(state.csrf){
        //     return state.csrf;
        // }
        let csrf = localStorage.getItem(types.CSRF)
        return csrf;
    },

  },
  mutations: {
    toggleState(state) {
      state.isCollapse = !state.isCollapse
    },
    [types.USER](state, payload) {
      state.user = payload;
      localStorage.setItem(types.USER, JSON.stringify(payload));
    },
    [types.CSRF](state, payload){
      state.csrf = payload;
      localStorage.setItem(types.CSRF, payload);
    }
  },
  actions: {
    toggleState({commit}) {
      commit("toggleState")
    },
    collapse({state}){
      state.isCollapse = true;
    },
    [types.USER]({commit}, payload){
      commit(types.USER, payload)
    }
  }
}

export default systemConfig
