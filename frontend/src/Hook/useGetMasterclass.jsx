export default function useGetMasterclass() {
    return function (id) {
        return fetch(`http://localhost:8245/masterclass/${id}`, {
            method: 'GET',
            mode: "cors"
        }).then(data => data.json())
    }
}