import * as types from './types'

const systemConfig = {
  state: {
    user: null,
    isCollapse: false
  },
  getters:{
    isCollapse(state){
      return state.isCollapse
    },
    [types.USER](state){
      if(state.user){
          return state.user;
      }
      let user = localStorage.getItem(types.USER)
      return JSON.parse(user)
    }

  },
  mutations: {
    toggleState (state) {
      state.isCollapse = !state.isCollapse
    },
    [types.USER](state, payload) {
      state.user = payload;
      localStorage.setItem(types.USER, JSON.stringify(payload));
    }
  },
  actions: {
    toggleState ({commit}) {
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
