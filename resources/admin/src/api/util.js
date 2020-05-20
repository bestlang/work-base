export const getPrefix = function() {
    return location.origin === process.env.SITE_URL ? 'ajax' : 'api'
}