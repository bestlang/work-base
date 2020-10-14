import types from 'sysType'
import api from 'sysApi'
import { getPrefix } from 'sysApi/util'
import Cookies from 'js-cookie'


const systemConfig = {
  state: {
    appName: '思纳福',
    appShortName: 'SN',
    user: {},
    isCollapse: false,
    csrf: null,
    accessToken: ''
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
    [types.user](state){
        let user = Object.keys(state.user).length ? state.user : JSON.parse(localStorage.getItem(types.user))
        if(!user){
            user = {}
        }
        return user
    },
    [types.csrf](state){
        let csrf = localStorage.getItem(types.csrf)
        return csrf
    },
    accessToken(state){
        return state.accessToken || localStorage.getItem('accessToken')
    }
  },
  mutations: {
    toggleState(state) {
      state.isCollapse = !state.isCollapse
    },
    [types.user](state, payload) {
      state.user = payload
      localStorage.setItem('user', JSON.stringify(payload))
    },
    [types.csrf](state, payload){
      state.csrf = payload
      localStorage.setItem(types.csrf, payload)
    },
    accessToken(state, payload){
        state.accessToken = payload
        if(!payload){
            localStorage.removeItem('accessToken')
        }else{
            localStorage.setItem("accessToken", payload)
        }
    }
  },
  actions: {
    toggleState({commit}) {
      commit("toggleState")
    },
    collapse({state}){
      state.isCollapse = true
    },
    async [types.user]({commit}, payload){
      if(payload) {
          commit(types.user, payload)
      }else{
          commit(types.user, {})
          let user = await api.getUserInfo()
          if(user && user.data){
              commit(types.user, user.data)
          }
      }
    },
    async [types.csrf]({commit}){
        let csrf = await api.csrf()
        if(csrf && csrf.data){
            commit(types.csrf, csrf.data)
        }
    },
    async [types.logout]({commit}){
        commit(types.user, {})
        localStorage.removeItem(types.csrf)
        localStorage.removeItem(types.user)
        localStorage.removeItem(types.privileges)
        Cookies.remove(types.logined)
        const res = await api.logout()
        if(getPrefix() == 'api'){
            commit('accessToken', null)
        }else{
            location.href='/login';
        }
    }
  }
}

export default systemConfig
