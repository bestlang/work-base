import * as types from './types'

const systemConfig = {
  state: {
    isCollapse: false
  },
  getters:{
    isCollapse(state){
      return state.isCollapse
    }
  },
  mutations: {
    toggleState (state) {
      state.isCollapse = !state.isCollapse
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
