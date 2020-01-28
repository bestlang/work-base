import * as types from './types'
import fetch from "../api/fetch"

const cmsConfig = {
  state: {
    loading: false,
    models: [],
    channels: [],
    channelChildren: []
  },
  getters:{
    loading(state){
      return state.loading
    },
    models(state){
      return state.models
    },
    channels(state){
      return state.channels
    },
    channelChildren(state){
      return state.channelChildren
    }
  },
  mutations: {
    [types.LOADING] (state, payload) {
      state.loading = payload;
    },
    [types.CMS_MODELS] (state, payload) {
      state.models = payload;
    },
    [types.CMS_CHANNELS] (state, payload) {
      state.channels = payload;
    },
    [types.CMS_CHANNEL_CHILDREN] (state, payload) {
      state.channelChildren = payload
    }
  },
  actions: {
    [types.CMS_MODELS] ({commit}) {
      commit(types.LOADING, true)
      fetch.get("/admin/cms/model")
        .then(res => {
          commit(types.CMS_MODELS, res.data);
          commit(types.LOADING, false)
        });
    },
    [types.CMS_CHANNELS] ({commit, dispatch} , parent) {
      commit(types.LOADING, true)
      fetch.get("/admin/cms/channel/tree", {params:{disabled: true}})
        .then(res => {
          let node = [res.data[Object.keys(res.data)[0]]]
          commit(types.CMS_CHANNELS, node);
          commit(types.LOADING, false)
          if(parent){
            dispatch(types.CMS_CHANNEL_CHILDREN, parent);
          }else{
            dispatch(types.CMS_CHANNEL_CHILDREN, node[0]);
          }

        });
    },
    [types.CMS_CHANNEL_CHILDREN] ({commit}, node) {
      commit(types.LOADING, true)
      fetch.post("/admin/cms/channel/children", {parent_id: node.id})
        .then(res => {
          commit(types.CMS_CHANNEL_CHILDREN, res.data)
          commit(types.LOADING, false)
        });
    }
  }
}

export default cmsConfig
