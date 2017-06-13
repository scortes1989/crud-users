class User {
    static get(then) {
        axios.get('/api/v1/core/users')
            .then(({data}) => then(data.data));
    }

    static show(element, then) {
        axios.get('/api/v1/core/users/' + element)
            .then(({data}) => then(data.data));
    }
}

export default User;