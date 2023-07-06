export default function useGetMasterclassCentreDeFormation() {
    return function (id) {
        return fetch(`http://localhost:8245/centre_formation/masterclass/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}