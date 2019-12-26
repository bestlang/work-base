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
    }
  }
}

export default systemConfig
