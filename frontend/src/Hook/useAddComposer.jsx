import useGetCoockie from "./useGetCoockie";

export default function useAddComposer() {
    const credentials = useGetCoockie("token");
    
    return function (composerName, composerDescription) {
        return fetch(`http://localhost:8245/composer`, {
            method: 'POST',
            credentials: 'include',
            mode: 'cors',
            headers: {
                'Authorization': `Bearer ${credentials}`
            },
            body: JSON.stringify({
                name: composerName,
                description: composerDescription,
            })
        }).then(data => data.json())
    }
}