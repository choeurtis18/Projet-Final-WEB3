export default function useGetMasterclassByComposer() {
    return function (id) {
        return fetch(`http://localhost:8245/masterclass/composer/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}