import * as types from './types'

const systemConfig = {
  state: {
    isCollapse: false,
    privileges: []
  },
  getters:{
    isCollapse(state){
      return state.isCollapse
    },
    privileges(state){
      return state.privileges
    }
  },
  mutations: {
    toggleState (state) {
      state.isCollapse = !state.isCollapse
    },
    [types.PRIVILEGES](state, payload){
      state.privileges = payload;
      console.log(`.............from store..............`)
      localStorage.setItem("privileges", JSON.stringify(payload))
    }
  },
  actions: {
    toggleState ({commit}) {
      commit("toggleState")
    },
    collapse({state}){
      state.isCollapse = true;
    }
  }
}

export default systemConfig
