import * as types from "./types"
import fetch from "../api/fetch"

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
        [types.ACTIVITY_TYPES] ({commit}) {
            fetch
                .get("/admin/activity/types")
                .then(res => {
                    console.log(`types:`, res)
                    commit(types.ACTIVITY_TYPES, res.data.types)
                })
                .catch(error => {console.log(error)});
        },
        [types.ACTIVITY_APPLICABLES] ({commit}) {
            fetch
                .get("/admin/activity/applicables")
                .then(res => {
                    console.log(`types:`, res)
                    commit(types.ACTIVITY_APPLICABLES, res.data.applicables)
                })
                .catch(error => {console.log(error)});
        }
    }
}

export default activityConfig
