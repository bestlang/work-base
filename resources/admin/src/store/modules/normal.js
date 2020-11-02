import types from 'sysStore/types'
import api from 'sysApi'
import { getPrefix } from 'sysApi/util'

const normalConfig = {
    state: {
        appName: '思纳福',
        appShortName: 'SN',
        user: {},
        isCollapse: false,
        csrf: null,
        accessToken: '',

        loading: false,
        currentRole: null,
        privileges: []
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
        },
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
        },
        [types.currentRole] (state, payload) {
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
                //commit(types.user, {})
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
            const res = await api.logout()
            commit(types.user, {})
            localStorage.removeItem(types.csrf)
            localStorage.removeItem(types.user)
            localStorage.removeItem(types.privileges)
            localStorage.removeItem('accessToken')
            if(getPrefix() == 'api'){
                commit('accessToken', null)
            }else{
                location.href='/login';
            }
        },
        [types.currentRole] ({commit}, payload) {
            commit(types.currentRole, payload)
        },
        async [types.privileges]({commit, dispatch}){
            commit(types.privileges, [])
            let perm = await api.getUserPermissions()
            if(perm && perm.data && perm.data.length){
                commit(types.privileges, perm.data)
            }else{
                //在admin下面希望无权限就登出
                dispatch(types.logout)
            }
        }
    }
}

export default normalConfig
