export default {
    getAll(page = 1) {
        // return a promise object.
        return new Promise((resolve, reject) => {
            Vue.http.get('/api/tasks').then((response) => resolve(response.json().data || []));
        });
    },
    add(task) {
        return new Promise((resolve, reject) => {
            Vue.http.post('/api/tasks', {
                body: task.body,
                color: task.color
            }).then((response) => resolve(response.json().data));
        });
    },
    toggle(task) {
        return new Promise((resolve, reject) => {
            Vue.http.patch('/api/tasks/' + task.id, {
                completed: !task.completed
            }).then((response) => resolve(response.json().data));
        });
    },
    remove(task) {
        return new Promise((resolve, reject) => {
            console.log(task);
            Vue.http.delete('/api/tasks/' + task.id)
                .then((response) => resolve(response.json().data))
                .catch((response) => reject(response.json()));
        });
    }
}
