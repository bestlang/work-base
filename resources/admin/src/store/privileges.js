import  types from './types'
import api from '../api'
import Vue from 'vue'

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
        //防止刷新页面取不到store里面的值
        let privileges =  state.privileges && state.privileges.length ? state.privileges : localStorage.getItem(types.privileges)
        if(!privileges){
            privileges = []
        }
        return privileges
    }
  },
  mutations: {
    [types.PRIVILEGE_CURRENT_ROLE] (state, payload) {
      state.currentRole = payload;
    },
    [types.privileges](state, payload){
        state.privileges = payload;
        if(!payload || !payload.length){
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
    async [types.privileges]({commit}){
        commit(types.privileges, [])
        let perm = await api.getUserPermissions()
        if(perm && perm.data){
            commit(types.privileges, perm.data)
        }
    }
  },
}

export default privilegeConfig
