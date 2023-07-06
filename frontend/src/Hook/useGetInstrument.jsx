export default function useGetInstrument() {
    return function (id) {
        return fetch(`http://localhost:8245/instrument/${id}`, {
            method: 'GET',
            mode: "cors"
        })
            .then(data => data.json())
    }
}