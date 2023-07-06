export default function useGetMasterclassByInstruments() {
    return function (id) {
        return fetch(`http://localhost:8245/masterclass/instrument/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}