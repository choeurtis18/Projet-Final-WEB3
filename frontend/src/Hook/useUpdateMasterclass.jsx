import useGetCoockie from "./useGetCoockie";

export default function useUpdateMasterclass() {
    const credentials = useGetCoockie("token");
    
    return function (masterclassTitle, masterclassDescription, masterclassCertification,
        masterclassInstrument, masterclassComposer, id) {
        return fetch(`http://localhost:8245/masterclass/${id}`, {
            method: 'PATCH',
            credentials: 'include',
            mode: 'cors',
            headers: {
                'Authorization': `Bearer ${credentials}`
            },
            body: JSON.stringify({
                title: masterclassTitle,
                description: masterclassDescription,
                certification: masterclassCertification,
                instrument: masterclassInstrument,
                composer: masterclassComposer,
            })
        }).then(data => data.json())
    }
}