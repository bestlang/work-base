import * as types from "./types"
import {fetch} from "../api/fetch"

const activityConfig = {
    state: {
        activityTypes: [],
        activityApplicables: []
    },
    getters: {
        activityTypes (state) {
            return state.activityTypes
        },
        activityApplicables (state) {
            return state.activityApplicables
        },
    },
    mutations: {
        [types.ACTIVITY_TYPES] (state, payload) {
            state.activityTypes = payload
        },
        [types.ACTIVITY_APPLICABLES] (state, payload) {
            state.activityApplicables = payload
        }
    },
    actions: {
        async [types.ACTIVITY_TYPES] ({commit}) {
            let res = await fetch("/admin/activity/types")
            commit(types.ACTIVITY_TYPES, res.data.types)
        },
        async [types.ACTIVITY_APPLICABLES] ({commit}) {
            let res = await fetch("/admin/activity/applicables")
            commit(types.ACTIVITY_APPLICABLES, res.data.applicables)
        }
    }
}

export default activityConfig
