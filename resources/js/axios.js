// axios.js
import axios from 'axios'

axios.defaults.withCredentials = true
axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest'

const setupCsrf = () => {
  return axios.get('/sanctum/csrf-cookie')
    .then(() => {
      console.log('CSRF cookie set successfully')
    })
    .catch((error) => {
      console.error('Error fetching CSRF cookie:', error)
    })
}

setupCsrf()

const axiosInstance = axios.create()

axiosInstance.interceptors.response.use(
  response => response,
  error => {
    if (error.response && error.response.status === 401) {
      console.warn('Authentication required - redirecting to login')
    //  window.location.href = '/login'
    }
    return Promise.reject(error)
  }
)

export { setupCsrf }
export default axiosInstance