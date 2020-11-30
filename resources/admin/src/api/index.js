import {fetch} from './fetch'

export default {
    login(data){ return fetch('auth/login', data, 'post') },
    logout(data){ return fetch('auth/logout', data, 'post') },
    passwordModify(data){ return fetch('auth/password/modify', data, 'post') },
    getCmsModels(data){ return fetch('/admin/cms/model', data) },
    getCmsChannelTree(data){ return fetch('/admin/cms/channel/tree', data) },
    getCmsChannelChildren(data){ return fetch('/admin/cms/channel/children', data) },
    createUser(data){ return fetch('/admin/user/create', data) },
    updateUser(data){ return fetch('/admin/user/update', data) },
    getUserInfo(data){ return fetch('/admin/user/info', data) },
    csrf(data){ return fetch('/csrf') },
    getUserPermissions(data){ return fetch('/admin/privileges/user/permissions', data) },
    saveModelFieldType(data){ return fetch('/admin/cms/model/field/type/save', data, 'post') },
    getModelFieldTypes(data){ return fetch('/admin/cms/model/field/types', data) },
    deleteCmsChannel(data){ return fetch('/admin/cms/channel/delete', data, 'post') },
    saveCmsChannel(data){ return fetch('/admin/cms/channel/save', data, 'post') },
    getCmsChannelWhole(data){ return fetch('/admin/cms/channel/whole', data) },
    getCmsPositions(data){ return fetch('/admin/cms/positions', data) },
    createRoleUser(data){ return fetch('/admin/user/create/role/user', data, 'post') },
    removeRoleModel(data){ return fetch('/admin/privileges/remove/role/model', data, 'post') },
    saveRole(data){ return fetch('/admin/privileges/save/role', data, 'post') },
    getRole(data){ return fetch('/admin/privileges/role', data) },
    getRoles(data){ return fetch('/admin/privileges/roles', data) },
    getUsers(data){ return fetch('/admin/privileges/users', data) },
    getPosition(data){ return fetch('/admin/cms/get/position', data) },
    getSubPositions(data){ return fetch('/admin/cms/position/subs', data, 'post') },
    savePosition(data){ return fetch('/admin/cms/position/save', data, 'post') },
    givePermissionsTo(data){ return fetch('/admin/privileges/give/permissions/to', data, 'post') },
    getPermissionsTree(data){ return fetch('/admin/privileges/permissions/tree', data) },
    getRolePermissions(data){ return fetch('/admin/privileges/role/permissions', data) },
    addPermission(data){ return fetch('/admin/privileges/add/permission', data, 'post') },
    editPermission(data){ return fetch('/admin/privileges/edit/permission', data, 'post') },
    deletePermission(data){ return fetch('/admin/privileges/delete/permission', data, 'post') },
    deleteContent(data){ return fetch('/admin/cms/content/delete', data, 'post') },
    saveContent(data){ return fetch('/admin/cms/content/save', data, 'post') },
    getModel(data){ return fetch('/admin/cms/model/get', data) },
    getChannelContents(data){ return fetch('/admin/cms/contents', data) },
    getWholeContent(data){ return fetch('/admin/cms/content/whole', data) },
    getContentPositions(data){ return fetch('/admin/cms/content/positions', data) },
    deleteModel(data){ return fetch('/admin/cms/model/delete', data, 'post') },
    addFieldType(data){ return fetch('/admin/cms/model/field/type/add', data, 'post') },
    getModels(data){ return fetch('/admin/cms/model', data) },
    saveModelFieldOrder(data){ return fetch('/admin/cms/model/save/field/order', data, 'post') },
    deleteModelField(data){ return fetch('/admin/cms/model/delete/field', data, 'post') },
    saveModel(data){ return fetch('/admin/cms/model/save', data, 'post') },
    modelSaveField(data){ return fetch('/admin/cms/model/save/field', data, 'post') },
    getPositionContents(data){ return fetch('/admin/cms/position/contents', data) },
    getRoleUsers(data){ return fetch('/admin/privileges/role/users', data) },
    deleteRole(data){ return fetch('/admin/privileges/delete/role', data, 'post') },
    getComments(data){ return fetch('/admin/cms/get/comments', data) },
    getContentComments(data){ return fetch('/admin/cms/get/content/comments', data) },
    saveAdPosition(data){ return fetch('/admin/cms/save/ad/position', data, 'post') },
    getAdPositions(data){ return fetch('/admin/cms/get/ad/positions', data) },
    getAds(data){ return fetch('/admin/cms/get/ads', data) },
    getAd(data){ return fetch('/admin/cms/get/ad', data) },
    deleteAdPosition(data){ return fetch('/admin/cms/delete/ad/position', data) },
    deleteAd(data){ return fetch('/admin/cms/delete/ad', data) },
    saveAd(data){ return fetch('/admin/cms/save/ad', data, 'post') },
    getOptionalTemplatePrefix(data){ return fetch('/admin/cms/get/optional/template/prefix', data) },
    getOptionalTemplatePath(data){ return fetch('/admin/cms/get/optional/template/path', data) },
    getOptionalThemes(data){ return fetch('/admin/cms/get/optional/themes', data) },
    getOrders(data){ return fetch('/admin/cms/orders', data) },
    getOrderDetail(data){ return fetch('/admin/cms/order/detail', data) },
    closeOrder(data){ return fetch('/admin/cms/order/close', data, 'post') },
    saveSiteSetting(data){ return fetch('/admin/cms/save/site/setting', data, 'post') },
    getSiteSetting(data){ return fetch('/admin/cms/get/site/setting', data) },
    getHistories(data){return fetch('/admin/histories', data) },
    getExternalContents(data){return fetch('/admin/cms/external/contents', data)},
    getExternalContent(data){return fetch('/admin/cms/external/content', data)},

    sniperGetDepartmentLevel1(data){ return fetch('/admin/sniper/employee/departments/level1', data) },
    sniperGetDepartmentsTreeSelect(data){ return  fetch('/admin/sniper/employee/departments/tree/select', data) },
    sniperSaveDepartment(data){ return fetch('/admin/sniper/employee/save/department', data, 'post') },
    sniperGetDepartmentDetail(data){ return fetch('/admin/sniper/employee/get/department/detail', data)},
    sniperGetDepartmentDescendants(data){ return fetch('/admin/sniper/employee/get/department/descendants', data) },
    sniperGetPositionsTreeSelect(data){ return  fetch('/admin/sniper/employee/positions/tree/select', data) },
    sniperSavePosition(data){ return fetch('/admin/sniper/employee/save/position', data, 'post') },
    sniperGetPositionDetail(data){ return fetch('/admin/sniper/employee/get/position/detail', data) },
    sniperGetPositionDescendants(data){ return fetch('/admin/sniper/employee/get/position/descendants', data) },
    sniperDeletePosition(data){ return fetch('/admin/sniper/employee/delete/position', data, 'post') },
    sniperEmployeePositionChange(data){ return fetch('/admin/sniper/employee/position/change', data, 'post') },

    sniperEmployeePositionChangeHistories(data){ return fetch('/admin/sniper/employee/position/change/histories', data) },
    sniperSaveEmployee(data){ return fetch('/admin/sniper/employee/save/employee', data, 'post') },
    sniperGetDepartmentEmployee(data){ return fetch('/admin/sniper/employee/department/employee', data) },
    sniperDeleteDepartment(data){ return fetch('/admin/sniper/employee/delete/department', data, 'post') },
    sniperGetEmployeeDetail(data){ return fetch('/admin/sniper/employee/get/employee/detail', data)},
    sniperDeleteEmployeeEducation(data){ return fetch('/admin/sniper/employee/delete/employee/education', data, 'post')},
    sniperDeleteEmployeeJob(data){ return fetch('/admin/sniper/employee/delete/employee/job', data, 'post')},

    sniperDingGetDepartments(data){ return fetch('/admin/sniper/employee/ding/get/departments', data)},
    sniperDingGetDepartmentUsers(data){ return fetch('/admin/sniper/employee/ding/get/department/users', data)},
    sniperDingGetUsersAttendance(data){ return fetch('/admin/sniper/employee/ding/get/users/attendance', data)},
    sniperDingGetWeekAvgAttendance(data){ return fetch('/admin/sniper/employee/ding/get/user/week/attendance/avg', data)},
    sniperDingGetMonthAvgAttendance(data){ return fetch('/admin/sniper/employee/ding/get/user/month/attendance/avg', data)},
    sniperDingGetDepartmentWeekAvgAttendance(data){ return fetch('/admin/sniper/employee/ding/get/user/department/week/attendance/avg', data)},
    sniperDingGetUser(data){ return fetch('/admin/sniper/employee/ding/get/user', data)},
    sniperDingGetToday(data){ return fetch('/admin/sniper/employee/ding/get/today', data)},

}