import * as types from './types'

const privilegeConfig = {
  state: {
    loading: false,
    currentRole: null,
    privileges: []
  },
  getters:{
    currentRole(state){
      return state.currentRole
    },
    [types.privileges](state){
        return state.privileges
    }
  },
  mutations: {
    [types.PRIVILEGE_CURRENT_ROLE] (state, payload) {
      state.currentRole = payload;
    },
    [types.privileges](state, payload){
        state.privileges = payload;
        if(!payload){
          localStorage.removeItem(types.privileges)
        }else{
          localStorage.setItem(types.privileges, JSON.stringify(payload))
        }
    }
  },
  actions: {
    [types.PRIVILEGE_CURRENT_ROLE] ({commit}, payload) {
      commit(types.PRIVILEGE_CURRENT_ROLE, payload)
    },
  },
}

export default privilegeConfig
