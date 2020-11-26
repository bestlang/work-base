import types from 'sysStore/types'
import api from 'sysApi'

const cmsConfig = {
  state: {
      loading: false,
      models: [],
      channels: [],
      parentChannel: null,
      channelChildren: [],
      currentChannel: null,
      contentCurrentChannel: null,
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
      contentCurrentChannel(state){
        return state.contentCurrentChannel
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
  },
  mutations: {
      [types.loading] (state, payload) {
        state.loading = payload;
      },
      [types.cmsModels] (state, payload) {
        state.models = payload;
      },
      [types.cmsChannels] (state, payload) {
        state.channels = payload;
      },
      [types.cmsChannelChildren] (state, payload) {
        state.channelChildren = payload
      },
      [types.cmsParentChannel] (state, payload) {
        state.parentChannel = payload
      },
      [types.cmsCurrentChannel] (state, payload) {
        state.currentChannel = payload
      },
      [types.cmsContentCurrentChannel] (state, payload) {
          state.contentCurrentChannel = payload
      },
      [types.cmsCurrentModel] (state, payload) {
        state.currentModel = payload
      },
      [types.cmsCurrentChannelPosition] (state, payload) {
          state.currentChannelPosition = payload
      },
      [types.cmsCurrentPosition] (state, payload) {
          state.currentPosition = payload
      }
  },
  actions: {
      async [types.cmsModels]({commit}){
        commit(types.loading, true)
        let res = await api.getCmsModels();
        commit(types.cmsModels, res.data);
        commit(types.loading, false)
      },
      /**
       刷新栏目树并加载选定栏目栏目的子栏目
       payload = [parent, except_single_page]
       */
      async [types.cmsChannels]({commit, dispatch}, payload=[null, 0]){
        //commit(types.loading, true)
        let res = await api.getCmsChannelTree({disabled: true, has_contents: payload[1]});
        let node = res.data[Object.keys(res.data)[0]]
        commit(types.cmsChannels, [node])
        let parentId = payload[0]||node.id
        // 设置父栏目 以及 父栏目的子栏目列表
        commit(types.cmsParentChannel, parentId)
        dispatch(types.cmsChannelChildren, parentId)
        if(!payload[0]){
            commit(types.cmsCurrentChannel, node)
        }
        //commit(types.loading, false);
      },
      async [types.cmsChannelChildren]({commit}, payload){
        commit(types.loading, true)
        let res = await api.getCmsChannelChildren({parent_id: payload})
        commit(types.cmsChannelChildren, res.data)
        commit(types.loading, false)
      },
      [types.cmsParentChannel]({commit}, node){
        commit(types.cmsParentChannel, node);
      },
      [types.cmsCurrentChannel]({commit}, node){
        commit(types.cmsCurrentChannel, node);
      },
      [types.cmsContentCurrentChannel]({commit}, node){
          commit(types.cmsContentCurrentChannel, node);
      },
      [types.cmsCurrentModel]({commit}, node){
        commit(types.cmsCurrentModel, node);
      }
  }
}

export default cmsConfig
