import { useState, useEffect } from "react";

import useGetInstrument from "../../Hook/useGetInstrument";

export default function Instrument(props) {
    const [instrument, setInstrument] = useState([]);

    const getInstrument = useGetInstrument();

    useEffect(() => {
        getInstrument(props.id).then(data => {
            setInstrument(data.instrument);
        });
    }, []);


    return (
        <h1 className='text-3xl my-12 font-medium text-center text-primary_first font-black'>{instrument.name}</h1>
    );
};
