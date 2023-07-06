export default function useAddInstrument() {
    //const credentials = btoa(`${loggedUser.username}:${loggedUser.password}`);

    return function (instrumentName) {
        return fetch(`http://localhost:8245/create_instrument`, {
            method: 'POST',
            credentials: 'include',
            mode: 'cors',
            /*
            headers: {
                'Authorization': `Basic ${credentials}`
            },
            */
            body: JSON.stringify({
                name: instrumentName,
           })
        })
            .then(res => res.json())
    }
}