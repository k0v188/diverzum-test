export const ApiMixins = {
    methods: {
      get(url) {
        return axios.get(url)
            .then( (response) => {
                return response.data;
            });
      },
      post(url, data) {
        return axios.post(url, data)
            .then( (response) => {
                return response.data;
            });
      },
      put(url, data) {
        return axios.put(url, data)
            .then( (response) => {
                return response.data;
            });
      },
      delete(url) {
        return axios.delete(url)
            .then( (response) => {
                return response.data;
            });
      },
    }
}

export default ApiMixins;
