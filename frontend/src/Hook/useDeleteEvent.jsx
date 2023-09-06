import useGetCoockie from "./useGetCoockie";

export default function useDeleteEvent() {
    const credentials = useGetCoockie("token");
    
    return function (id) {
        return fetch(`http://localhost:8245/event/${id}`, {
            method: 'DELETE',
            credentials: 'include',
            mode: 'cors',
            headers: {
                'Authorization': `Bearer ${credentials}`
            }
        }).then(data => data.json())
    }
}