import * as types from './types'
import fetch from "../api/fetch"

const cmsConfig = {
  state: {
      loading: false,
      models: [],
      channels: [],
      parentChannel: null,
      channelChildren: [],
      currentChannel: null,
      currentModel: null,
      currentChannelPosition: null,
      currentPosition: null,
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
      },
      parentChannel(state){
        return state.parentChannel
      },
      currentChannel(state){
        return state.currentChannel
      },
      currentModel(state){
        return state.currentModel
      },
      currentChannelPosition(state){
        return state.currentChannelPosition
      },
      currentPosition(state){
        return state.currentPosition
      },
  }
  ,
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
      },
      [types.CMS_PARENT_CHANNEL] (state, payload) {
        state.parentChannel = payload
      },
      [types.CMS_CURRENT_CHANNEL] (state, payload) {
        state.currentChannel = payload
      },
      [types.CMS_CURRENT_MODEL] (state, payload) {
        state.currentModel = payload
      },
      [types.CMS_CURRENT_CHANNEL_POSITION] (state, payload) {
          state.currentChannelPosition = payload
      },
      [types.CMS_CURRENT_POSITION] (state, payload) {
          state.currentPosition = payload
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
            // 取到了数据
            if(Object.keys(res.data).length > 0){
              let node = res.data[Object.keys(res.data)[0]]
              commit(types.CMS_CHANNELS, [node]);
              // 设置第一个元素为父栏目 && 取得第一个元素的子栏目列表
              dispatch(types.CMS_CHANNEL_CHILDREN, node);
              dispatch(types.CMS_PARENT_CHANNEL, node)
              if(!parent){
                  // 默认设置根节点为当前选中栏目
                  dispatch(types.CMS_CURRENT_CHANNEL, node)
              }
            }
            // 设置父栏目 以及 父栏目的子栏目列表
            if(parent){
              dispatch(types.CMS_PARENT_CHANNEL, parent)
              dispatch(types.CMS_CHANNEL_CHILDREN, parent);
            }

            commit(types.LOADING, false)
          });
      },
      [types.CMS_CHANNEL_CHILDREN] ({commit}, node) {
        commit(types.LOADING, true)
        fetch.post("/admin/cms/channel/children", {parent_id: node.id})
          .then(res => {
            commit(types.CMS_CHANNEL_CHILDREN, res.data)
            commit(types.LOADING, false)
          });
      },
      [types.CMS_PARENT_CHANNEL] ({commit}, node) {
        commit(types.CMS_PARENT_CHANNEL, node);
      },
      [types.CMS_CURRENT_CHANNEL] ({commit}, node) {
        commit(types.CMS_CURRENT_CHANNEL, node);
      },
      [types.CMS_CURRENT_MODEL] ({commit}, node) {
        commit(types.CMS_CURRENT_MODEL, node);
      }
  }
}

export default cmsConfig
