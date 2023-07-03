export default function useGetComposer() {
    return function (id) {
        return fetch(`http://localhost:8245/composer/${id}`, {
            method: 'GET',
            mode: "cors"
        })
            .then(data => data.json())
    }
}