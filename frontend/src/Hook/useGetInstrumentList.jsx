export default function useGetUserList() {
    return function () {
        return fetch('http://localhost:8245/instrument', {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}