import {fetch} from "./fetch"

export default {
    getUserInfo: () => { return fetch("/admin/activity/applicables"); }
}