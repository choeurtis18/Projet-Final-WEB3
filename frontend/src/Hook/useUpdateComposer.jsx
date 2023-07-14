import useGetCoockie from "./useGetCoockie";

export default function useUpdateComposer() {
    const credentials = useGetCoockie("token");
    
    return function (composerName, composerDescription, id) {
        return fetch(`http://localhost:8245/composer/${id}`, {
            method: 'PATCH',
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