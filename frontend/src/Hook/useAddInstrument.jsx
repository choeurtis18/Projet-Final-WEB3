import useGetCoockie from "./useGetCoockie";

export default function useAddInstrument() {
    const credentials = useGetCoockie("token");
    
    return function (instrumentName) {
        return fetch(`http://localhost:8245/create_instrument`, {
            method: 'POST',
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