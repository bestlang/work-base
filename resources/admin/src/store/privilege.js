import * as types from './types'

const privilegeConfig = {
  state: {
    loading: false,
    currentRole: null
  },
  getters:{
    currentRole(state){
      return state.currentRole
    },

  },
  mutations: {
    [types.PRIVILEGE_CURRENT_ROLE] (state, payload) {
      state.currentRole = payload;
    },
  },
  actions: {
    [types.PRIVILEGE_CURRENT_ROLE] ({commit}, payload) {
      commit(types.PRIVILEGE_CURRENT_ROLE, payload)
    },
  }
}

export default privilegeConfig
