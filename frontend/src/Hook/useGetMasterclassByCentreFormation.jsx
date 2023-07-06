export default function useGetMasterclassByCentreFormation() {
    return function (id) {
        return fetch(`http://localhost:8245/masterclasses/centredeformation/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}