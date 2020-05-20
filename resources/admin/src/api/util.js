export const getPrefix = function() {
    //return location.origin === process.env.SITE_URL ? 'ajax' : 'api'
    return location.origin.indexOf('8000') > 0 ? 'ajax' : 'api'
}