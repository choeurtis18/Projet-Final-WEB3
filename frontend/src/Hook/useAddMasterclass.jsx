import useGetCoockie from "./useGetCoockie";

export default function useAddMasterclass() {
    const credentials = useGetCoockie("token");

    return function (masterclassTitle, masterclassDescription, masterclassCertification,
                    masterclassInstrument, masterclassComposer) {

        return fetch(`http://localhost:8245/masterclass`, {
            method: 'POST',
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
        })
            .then(res => res.json())
    }
}