import useGetCoockie from "./useGetCoockie";

export default function useUpdateInstrument() {
    const credentials = useGetCoockie("token");
    
    return function (instrumentName, id) {
        return fetch(`http://localhost:8245/instrument/${id}`, {
            method: 'PATCH',
            credentials: 'include',
            mode: 'cors',
            headers: {
                'Authorization': `Bearer ${credentials}`
            },
            body: JSON.stringify({
                name: instrumentName,
           })
        }).then(data => data.json())
    }
}