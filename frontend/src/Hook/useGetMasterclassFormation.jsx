export default function useGetMasterclassFormation() {
    return function (id) {
        return fetch(`http://localhost:8245/formation/masterclass/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}