import useGetCoockie from "./useGetCoockie";

export default function useUpdateEvent() {
    const credentials = useGetCoockie("token");
    
    return function (eventName, eventDescription, eventDateStart, eventDateEnd, id) {
        return fetch(`http://localhost:8245/event/${id}`, {
            method: 'PATCH',
            credentials: 'include',
            mode: 'cors',
            headers: {
                'Authorization': `Bearer ${credentials}`
            },
            body: JSON.stringify({
                name: eventName,
                description: eventDescription,
                date_start: eventDateStart,
                date_end: eventDateEnd,
           })
        }).then(data => data.json())
    }
}