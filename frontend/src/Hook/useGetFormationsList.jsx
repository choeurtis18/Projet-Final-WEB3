export default function useGetFormationsList() {
    return function () {
        return fetch('http://localhost:8245/formations', {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}