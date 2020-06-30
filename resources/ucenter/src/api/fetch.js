import axios from 'axios';

const fetch = (url, data = {}, method = 'get', headers) => {
  const options = {
    url,
    method,
    data,
  }

  if (method === 'get') {
    options.params = data
  }

  if (headers) {
    options.headers = headers
  }

  axios.interceptors.request.use(function(config){
    config.headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
    return config
  })

  axios.interceptors.response.use((response) => {
    if (response.data.code === 401) {
      window.location.href = `${window.location.origin}/login`
    }
    return response
  }, (error) => Promise.reject(error))

  return axios(options)
}

export default fetch
