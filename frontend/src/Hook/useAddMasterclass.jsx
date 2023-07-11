export default function useAddMasterclass() {
    //const credentials = btoa(`${loggedUser.username}:${loggedUser.password}`);

    return function (MasterclassName) {
        return fetch(`http://localhost:8245/create_Masterclass`, {
            method: 'POST',
            credentials: 'include',
            mode: 'cors',
            /*
            headers: {
                'Authorization': `Basic ${credentials}`
            },
            */
            body: JSON.stringify({
                name: MasterclassName,
           })
        })
            .then(res => res.json())
    }
}