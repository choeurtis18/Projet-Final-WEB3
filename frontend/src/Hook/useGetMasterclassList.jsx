export default function useGetMasterclassList() {
    return function () {
        return fetch('http://localhost:8245/masterclasses', {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}