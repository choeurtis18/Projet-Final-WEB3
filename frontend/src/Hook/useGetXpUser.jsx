export default function useGetXpUser() {
    return function () {
        return fetch('http://localhost:8245//users/xp', {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}