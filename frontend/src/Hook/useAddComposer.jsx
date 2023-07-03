export default function useAddComposer() {
    //const credentials = btoa(`${loggedUser.username}:${loggedUser.password}`);

    return function (composerName, composerDescription) {
        return fetch(`http://localhost:8245/create_composer`, {
            method: 'POST',
            credentials: 'include',
            mode: 'cors',
            /*
            headers: {
                'Authorization': `Basic ${credentials}`
            },
            */
            body: JSON.stringify({
                name: composerName,
                description: composerDescription,
           })
        })
            .then(res => res.json())
    }
}